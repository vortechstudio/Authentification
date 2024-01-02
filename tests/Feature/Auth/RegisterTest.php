<?php

namespace Auth;

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Model::unsetEventDispatcher();
        Model::flushEventListeners();
    }

    public function test_render_register_page()
    {
        $this->withoutExceptionHandling();

        $response = Livewire::test(Register::class);

        $response->assertStatus(200);
    }

    public function test_register_user_success()
    {
        $this->withoutExceptionHandling();

        $response = Livewire::test(Register::class)
            ->set('firstname', 'John')
            ->set('lastname', 'Doe')
            ->set('email', 'jdoe@gmail.com')
            ->set('password', 'password')
            ->call('register');

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'jdoe@gmail.com'
        ]);
    }

    public function test_register_error_with_validation()
    {
        $this->withoutExceptionHandling();

        $response = Livewire::test(Register::class)
            ->set('firstname', '')
            ->set('lastname', '')
            ->set('email', '')
            ->set('password', '')
            ->call('register');


        $response->assertHasErrors([
            'email' => 'required',
            'password' => 'required'
        ]);
    }
}
