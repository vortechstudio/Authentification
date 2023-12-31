<?php

namespace App\Console;

use App\Models\Railway\RailwayBanque;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command("verify", ["action" => "events"])->daily();
        $schedule->command("verify", ["action" => "eventPublish"])->daily();

        $schedule->command("action", ["action" => "daily_flux"])->daily();
        $schedule->command("action", ["action" => "daily_config"])->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
