<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class IsBannishUser extends Component
{
    #[Title('Votre compte à été bannie')]
    public function render()
    {
        return view('livewire.is-bannish-user');
    }
}
