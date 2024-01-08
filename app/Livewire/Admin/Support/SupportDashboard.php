<?php

namespace App\Livewire\Admin\Support;

use Livewire\Attributes\Title;
use Livewire\Component;

class SupportDashboard extends Component
{
    #[Title('Gestion du support technique')]
    public function render()
    {
        return view('livewire.admin.support.support-dashboard')
            ->layout('components.layouts.admin');
    }
}
