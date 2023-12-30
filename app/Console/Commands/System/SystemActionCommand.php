<?php

namespace App\Console\Commands\System;

use App\Models\Railway\RailwayBanque;
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
    }
}
