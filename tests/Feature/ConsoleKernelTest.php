<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsoleKernelTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_verify_events()
    {
        $this->artisan('verify', ['action' => 'events'])
            ->assertSuccessful();
    }

    public function test_console_verify_event_publish()
    {
        $this->artisan('verify', ['action' => 'eventPublish'])
            ->assertSuccessful();
    }

    public function test_console_verify_claim_bonus()
    {
        $this->artisan('verify', ['action' => 'claimbonuse'])
            ->assertSuccessful();
    }

    public function test_console_action_daily_flux()
    {
        $this->artisan('action', ['action' => 'daily_flux'])
            ->assertSuccessful();
    }

    public function test_console_action_monthly_bonus()
    {
        $this->artisan('action', ['action' => 'monthly_bonus'])
            ->assertSuccessful();
    }
}
