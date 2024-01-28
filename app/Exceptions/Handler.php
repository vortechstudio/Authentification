<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            $this->createGithubIssue($e);
        });
    }

    protected function createGithubIssue($exception)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://api.github.com/repos/'.config('updater.github_username').'/'.config('updater.github_repository').'/issues', [
            'headers' => [
                'Authorization' => 'token ' . config('updater.github_token'),
                'Accept' => 'application/vnd.github.v3+json',
            ],
            'json' => [
                'title' => 'Exception: ' . $exception->getMessage(),
                'body' => "Détails de l'erreur:\n```\n" . $exception->getTraceAsString() . "\n```",
            ],
        ]);
    }
}
