<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * @codeCoverageIgnore
 */
class VerifyEmailNotice extends Component
{
    public function VerifyEmailNotice()
    {
        auth()->user()->sendEmailVerificationNotification();
        toastr()->addSuccess('Un email de vérification a été envoyé', 'Vérification de votre compte');

        return redirect()->route('login');
    }

    #[Title('Vérification de compte')]
    public function render()
    {
        return view('livewire.auth.verify-email-notice')->layout('components.layouts.app');
    }
}
