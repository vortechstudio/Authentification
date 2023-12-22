<?php

namespace App\Console\Command\System;

use App\Models\Social\Event;
use App\Models\User;
use App\Notifications\Social\IsPublishNotification;
use App\Notifications\System\AlertStatusEventNotification;
use Illuminate\Console\Command;

class SystemVerifyCommand extends Command
{
    protected $signature = 'system:verify {action}';

    protected $description = 'Verificateur de commande SYSTEM';

    public function handle(): void
    {
        match ($this->argument('action')) {
            "events" => $this->verifyStatusEvents(),
            "eventPublish" => $this->verifyEventIsPublish()
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
}
