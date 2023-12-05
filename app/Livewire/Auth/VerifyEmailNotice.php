<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class VerifyEmailNotice extends Component
{
    public function VerifyEmailNotice()
    {
        auth()->user()->sendEmailVerificationNotification();
        toastr()->addSuccess("Un email de vérification a été envoyé", "Vérification de votre compte");
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.auth.verify-email-notice')->layout('components.layouts.app');
    }
}
