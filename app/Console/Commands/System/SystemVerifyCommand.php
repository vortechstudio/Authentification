<?php

namespace App\Console\Commands\System;

use App\Models\Social\Event;
use App\Models\Social\Post;
use App\Models\Social\PostComment;
use App\Models\User;
use App\Models\UserProfil;
use App\Notifications\Social\IsPublishNotification;
use App\Notifications\System\AlertStatusEventNotification;
use App\Notifications\User\AvertissementNotification;
use App\Notifications\User\UnbannedNotification;
use Illuminate\Console\Command;

class SystemVerifyCommand extends Command
{
    protected $signature = 'verify {action}';

    protected $description = 'Verificateur de commande SYSTEM';

    public function handle(): void
    {
        match ($this->argument('action')) {
            "events" => $this->verifyStatusEvents(),
            "eventPublish" => $this->verifyEventIsPublish(),
            "postIsBlocked" => $this->verifyPostIsBlocked(),
            "postCommentIsBlocked" => $this->verifyPostCommentIsBlocked(),
            "accountBanned" => $this->verifyAccountBanned()
        };
    }

    private function verifyStatusEvents()
    {
        foreach (Event::all() as $event) {
            $calc_diff_in_day = now()->startOfDay()->diffInDays($event->end_at->endOfDay());
            $alert_pass_submitting = intval($calc_diff_in_day * 75 / 100);
            $alert_pass_evaluating = intval($calc_diff_in_day * 45 / 100);
            $alert_pass_closed = intval($calc_diff_in_day * 5 /100);
            if($event->status = 'progress') {
                if($calc_diff_in_day <= $alert_pass_submitting) {
                    $this->notifyAdmin($event, "Vous devez impérativement passer cette évènement en <strong>Soumission</strong>");
                }
            }

            if($event->status = 'submitting') {
                if($calc_diff_in_day <= $alert_pass_evaluating) {
                    $this->notifyAdmin($event, "Vous devez impérativement passer cette évènement en <strong>Evaluation</strong>");
                }
            }

            if($event->status == 'evaluation') {
                if($calc_diff_in_day <= $alert_pass_closed) {
                    $this->notifyAdmin($event, "Vous devez impérativement passer cette évènement en <strong>Cloture</strong>. Par défault il le sera à la date et heure de la fin de l'évènement.");
                }
                if(now()->endOfDay() == $event->end_at->endOfDay()) {
                    $event->update([
                        "status" => "closed"
                    ]);

                    $this->notifyAdmin($event, "L'évènement à été automatiquement cloturer");
                }
            }
        }
    }

    private function notifyAdmin(Event $event, string $message)
    {
        foreach (User::where('admin', true)->get() as $user) {
            $user->notify(new AlertStatusEventNotification($event, $message));
        }
    }

    private function verifyEventIsPublish()
    {
        foreach (Event::all() as $event) {
            if($event->start_at->startOfDay() == now()->startOfDay()) {
                $event->notify(new IsPublishNotification("event", $event));
            }
        }
    }

    private function verifyPostIsBlocked()
    {
        foreach (Post::where('is_reject', true) as $post) {
            if($post->is_reject_at->startOfDay == now()->subDays(7)->startOfDay()) {
                if($post->user->social->avertissement > 3) {
                    $post->user->social->banned = true;
                    $post->user->social->banned_at = now();
                    $post->user->social->banned_for = now()->addDays(7)->startOfDay();
                    $post->user->social->save();

                    $post->user->logs()->create([
                        "action" => "Banissement du compte pour une durée de 7 jours",
                        "user_id" => $post->user->id
                    ]);
                } else {
                    $post->user->social->avertissement++;
                    $post->user->social->save();

                    $post->user->notify(new AvertissementNotification(
                        $post->user,
                        "Non respect des règles éthiques d'utilisations du service Vortech Lab"
                    ));
                    $post->user->logs()->create([
                        "action" => "Avertissement pour non respect des conditions d'utilisations de Vortech Lab",
                        "user_id" => $post->user->id
                    ]);

                    $post->delete();
                }
            }
        }
    }
    private function verifyPostCommentIsBlocked()
    {
        foreach (PostComment::where('is_reject', true) as $comment) {
            if($comment->is_reject_at->startOfDay == now()->subDays(7)->startOfDay()) {
                if($comment->user->social->avertissement > 3) {
                    $comment->user->social->banned = true;
                    $comment->user->social->banned_at = now();
                    $comment->user->social->banned_for = now()->addDays(7)->startOfDay();
                    $comment->user->social->save();

                    $comment->user->logs()->create([
                        "action" => "Banissement du compte pour une durée de 7 jours",
                        "user_id" => $comment->user->id
                    ]);
                } else {
                    $comment->user->social->avertissement++;
                    $comment->user->social->save();

                    $comment->user->notify(new AvertissementNotification(
                        $comment->user,
                        "Non respect des règles éthiques d'utilisations du service Vortech Lab"
                    ));
                    $comment->user->logs()->create([
                        "action" => "Avertissement pour non respect des conditions d'utilisations de Vortech Lab",
                        "user_id" => $comment->user->id
                    ]);

                    $comment->delete();
                }
            }
        }
    }

    private function verifyAccountBanned()
    {
        foreach (UserProfil::all() as $profil) {
            if($profil->banned && $profil->banned_for->startOfDay == now()->startOfDay()) {
                $profil->update([
                    "banned" => false,
                    "banned_at" => null,
                    "banned_for" => null,
                    "avertissement" => 0
                ]);

                $profil->user->notify(new UnbannedNotification($profil->user));
            }
        }
    }
}
