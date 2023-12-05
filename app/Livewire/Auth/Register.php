<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

class Register extends Component
{
    #[Title('Inscription')]
    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.app');
    }
}
