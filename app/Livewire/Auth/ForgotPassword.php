<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

class ForgotPassword extends Component
{

    public string $email;
    public function send()
    {
        $this->validate([
            "email" => 'required|email'
        ]);

        $status = Password::sendResetLink($this->only(['email']));

        if($status === Password::RESET_LINK_SENT) {
            session()->flash("message", "Un mail vous à été envoyer pour réinitialiser votre mot de passe");
        } else {
            // @codeCoverageIgnoreStart
            session()->flash("error", "Une erreur est survenue lors de l'envoi du mail");
            // @codeCoverageIgnoreEnd
        }
    }
    #[Title('Mot de passe perdu')]
    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.app');
    }
}
