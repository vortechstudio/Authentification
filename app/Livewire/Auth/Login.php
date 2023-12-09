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

    public function mount()
    {
        if (request()->has('provider')) {
            $this->provider = request()->query('provider');
        } else {
            $this->provider = '';
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
            if($this->provider == 'lab') {
                $this->redirect('https://lab.'.config('app.domain').'/login?logged=true&user_uuid='.auth()->user()->uuid);
            } else {
                $this->redirectRoute('account.index');
            }
        } else {
            session()->flash('error', 'Compte inexistant');
        }
    }
    #[Title('Connexion')]
    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }
}
