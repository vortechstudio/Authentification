<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Tableau de Bord')]
    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('components.layouts.admin');
    }
}
