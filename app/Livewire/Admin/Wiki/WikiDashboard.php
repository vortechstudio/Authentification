<?php

namespace App\Livewire\Admin\Wiki;

use Livewire\Attributes\Title;
use Livewire\Component;

class WikiDashboard extends Component
{
    #[Title("Wiki")]
    public function render()
    {
        return view('livewire.admin.wiki.wiki-dashboard')
            ->layout("components.layouts.admin");
    }
}
