<?php

namespace App\Livewire\Service;

use Livewire\Attributes\Title;
use Livewire\Component;

class Otp extends Component
{
    public bool $recorveryCode = false;
    #[Title('Mot de passe à usage unique (OTP)')]
    public function render()
    {
        return view('livewire.service.otp');
    }

    /**
    * @codeCoverageIgnore
    */
    public function showRecorveryCode()
    {
        $this->recorveryCode = !$this->recorveryCode;
    }
}
