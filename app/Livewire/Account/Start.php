<?php

namespace App\Livewire\Account;

use Livewire\Attributes\Title;
use Livewire\Component;

class Start extends Component
{
    #[Title('Mon compte')]
    public function render()
    {
        return view('livewire.account.start')->layout('components.layouts.app');
    }
}
