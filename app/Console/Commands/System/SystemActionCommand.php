<?php

namespace App\Console\Commands\System;

use App\Models\Railway\RailwayBanque;
use App\Models\Railway\RailwaySetting;
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
            "daily_config" => $this->dailyConfig(),
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

    private function dailyConfig(): void
    {
        RailwaySetting::where('name', 'price_diesel')->first()->update([
            "value" => generateRandomFloat(1.1, 2.2)
        ]);
        RailwaySetting::where('name', 'price_electricity')->first()->update([
            "value" => generateRandomFloat(0.10,0.56)
        ]);
        RailwaySetting::where('name', 'price_kilometer')->first()->update([
            "value" => generateRandomFloat(0.45,1.96)
        ]);
        RailwaySetting::where('name', 'price_parking')->first()->update([
            "value" => generateRandomFloat(1,2)
        ]);
        RailwaySetting::where('name', 'price_tpoint')->first()->update([
            "value" => generateRandomFloat(1, 1.2)
        ]);
    }
}
