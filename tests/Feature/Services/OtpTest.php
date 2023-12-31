<?php

namespace Tests\Feature\Services;

use App\Livewire\Service\Otp;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OtpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Model::unsetEventDispatcher();
        Model::flushEventListeners();
        $this->user = User::factory()->create([
            'email' => 'test@test.com',
        ]);
    }

    public function test_render()
    {
        Livewire::actingAs($this->user)
            ->test(Otp::class)
            ->assertStatus(200);
    }
}
