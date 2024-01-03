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
    /**
    * @codeCoverageIgnore
    */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command("verify", ["action" => "events"])->daily();
        $schedule->command("verify", ["action" => "eventPublish"])->daily();
        $schedule->command("verify", ["action" => "claimbonuse"])->dailyAt("20:00");

        $schedule->command("action", ["action" => "daily_flux"])->daily();
        $schedule->command("action", ["action" => "daily_config"])->daily();
        $schedule->command("action", ["action" => "monthly_bonus"])->monthlyOn(30);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require_once base_path('routes/console.php');
    }
}
