<?php

namespace App\Console\Commands\System;

use App\Models\Railway\RailwayBanque;
use App\Models\User;
use App\Notifications\System\SendMessageNotification;
use Illuminate\Console\Command;

class SystemActionCommand extends Command
{
    protected $signature = 'action {action}';

    protected $description = 'Effectue des actions propre aux services';

    public function handle(): void
    {
        match ($this->argument('action')) {
            "daily_flux" => $this->dailyFlux(),
        };
    }

    private function dailyFlux(): void
    {
        foreach (RailwayBanque::all() as $banque) {
            $banque->flux()->create([
                "date" => now()->startOfDay(),
                "interest" => generateRandomFloat($banque->minimal_interest, $banque->maximal_interest),
                "railway_banque_id" => $banque->id
            ]);
        }

        foreach (User::where('admin', true)->get() as $user) {
            $user->notify(new SendMessageNotification(
                "Flux Bancaire quotidien",
                "Le flux des intêret bancaire à été mise à jours",
                "info",
                "fa-info-circle"
            ));
        }
    }
}
