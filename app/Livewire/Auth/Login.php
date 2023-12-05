<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

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
            $this->redirectRoute('account.index');
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
