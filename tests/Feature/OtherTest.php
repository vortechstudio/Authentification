<?php

namespace Tests\Feature;

use App\Livewire\IsBannishUser;
use App\Livewire\IsOffline;
use App\Livewire\Layout\Footer;
use App\Livewire\Layout\Header;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OtherTest extends TestCase
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
        $this->user->social()->create([
            'header_img' => 'https://picsum.photos/seed/picsum/200/300',
            'profil_img' => 'https://picsum.photos/seed/picsum/200/300',
            'user_id' => $this->user->id,
        ]);
        $this->withoutExceptionHandling();
    }

    public function test_app_is_offline()
    {
        Livewire::actingAs($this->user)
            ->test(IsOffline::class)
            ->assertSee('Système Hors Ligne');
    }

    public function test_user_is_banned()
    {
        $this->user->social()->update([
            'banned' => true,
            'banned_at' => now(),
            'banned_for' => now()->addDays(7),
        ]);
        Livewire::actingAs($this->user)
            ->test(IsBannishUser::class)
            ->assertSee('Votre compte a été bannie des services de Vortech Studio.');
    }

    public function test_show_layout_header_not_connected()
    {

        $response = Livewire::test(Header::class);
        $response->assertSee('logo-default h-50px h-lg-75px');
    }

    public function test_show_layout_header_connected()
    {

        $response = Livewire::actingAs($this->user)
            ->test(Header::class);
        $response->assertSee('logo-default h-25px h-lg-30px');
    }

    public function test_show_layout_footer()
    {
        $response = Livewire::actingAs($this->user)
            ->test(Footer::class);
        $response->assertStatus(200);
    }
}
