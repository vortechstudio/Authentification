<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public string $provider = '';

    /**
     * @codeCoverageIgnore
     */
    public function mount()
    {
        if (request()->has('provider')) {
            $this->provider = request()->query('provider');
        } else {
            $this->provider = '';
        }
        if (\Auth::check()) {
            $this->RouteProvider();
        }

    }

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember);

        if (auth()->check()) {
            auth()->user()->update([
                'status' => 'online',
            ]);
            $this->RouteProvider();
        } else {
            session()->flash('error', 'Compte inexistant');
        }
    }

    #[Title('Connexion')]
    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }

    /**
     * @codeCoverageIgnore
     */
    public function RouteProvider()
    {
        if ($this->provider == 'lab') {
            $this->redirect('https://lab.'.config('app.domain').'/login?logged=true&user_uuid='.auth()->user()->uuid."&name=".auth()->user()->name);
        } else {
            $this->redirectRoute('account.index');
        }
    }
}
