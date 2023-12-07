<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

class PasswordConfirmation extends Component
{
    public string $password = '';

    public function confirm()
    {
        if(!\Hash::check($this->password, auth()->user()->password)) {
            $this->addError('password', 'Mot de passe incorrect');
        }

        session()->passwordConfirmed();

        return redirect()->intended();

    }
    #[Title("Confirmation de l'accès")]
    public function render()
    {
        return view('livewire.auth.password-confirmation')->layout('components.layouts.app');
    }
}
