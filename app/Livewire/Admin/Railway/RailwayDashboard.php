<?php

namespace App\Livewire\Admin\Railway;

use Livewire\Attributes\Title;
use Livewire\Component;

class RailwayDashboard extends Component
{
    #[Title("Railway Manager")]
    public function render()
    {
        return view('livewire.admin.railway.railway-dashboard')
            ->layout("components.layouts.admin");
    }
}
