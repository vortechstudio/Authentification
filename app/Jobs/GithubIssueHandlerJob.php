<?php

namespace App\Jobs;

use Github\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Monolog\LogRecord;

class GithubIssueHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public LogRecord $record
    )
    {
    }

    public function handle(): void
    {
        $this->storeToGithub();
    }

    private function storeToGithub(): void
    {
        $client = new Client();
        $client->authenticate(config('services.github.token'), null, Client::AUTH_ACCESS_TOKEN);

        $errorTitle = "Erreur: {$this->record['message']}";
        $errorDetails = [
            'message' => $this->record['message'],
            'context' => $this->record['context'],
            'level' => $this->record['level_name'],
            'time' => $this->record['datetime']->format('Y-m-d H:i:s'),
        ];

        $openai = $this->generateDescriptionWithGpt($errorTitle, $errorDetails);

        ob_start();
        ?>
        ## Détail de l'erreur
        Message: <?= $errorDetails['message'] ?>
        Contexte: <?= json_encode($errorDetails['context']) ?>
        Niveau: <?= $errorDetails['level'] ?>
        Date: <?= $errorDetails['time'] ?>

        ## Description
        <?= $openai[0]['description'] ?>

        ## Reproduction
        <?= $openai[1]['reproduce'] ?>

        ## Comportement attendu
        <?= $openai[2]['comportement'] ?>

        ## Solution proposé
        <?= $openai[3]['solution'] ?>
        <?php
        $issueContent = ob_get_clean();

        try {
            $client->api('issue')
                ->create(
                    config('updater.github_username'),
                    config('updater.github_repository'),
                    [
                        'title' => $errorTitle,
                        'body' => $issueContent,
                        'labels' => ['bug', 'auto-generated'],
                    ]
                );
        }catch (\Exception $exception) {
            \Log::info("Impossible de créer une issue sur Github: {$exception->getMessage()}");
        }
    }

    private function generateDescriptionWithGpt(string $errorTitle, array $errorDetails): \Illuminate\Support\Collection
    {
        $results = collect();

        $describe = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "assistant",
                    "content" => "Description sous le format issue de GITHUB: \n".$errorTitle."\n".$errorDetails["message"]."\n".$errorDetails["context"],
                ],
            ]
        ]);

        $reproduce = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "assistant",
                    "content" => "Comment reproduire l'erreur: \n".$errorTitle."\n".$errorDetails["message"]."\n".$errorDetails["context"],
                ],
            ]
        ]);

        $comportement = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "assistant",
                    "content" => "Comportement attendu: \n".$errorTitle."\n".$errorDetails["message"]."\n".$errorDetails["context"],
                ],
            ]
        ]);

        $solution = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "assistant",
                    "content" => "Solution proposé: \n".$errorTitle."\n".$errorDetails["message"]."\n".$errorDetails["context"],
                ],
            ]
        ]);

        $results->push(['description' => $describe->choices[0]->message->content]);
        $results->push(['reproduce' => $reproduce->choices[0]->message->content]);
        $results->push(['comportement' => $comportement->choices[0]->message->content]);
        $results->push(['solution' => $solution->choices[0]->message->content]);

        return $results;
    }
}
