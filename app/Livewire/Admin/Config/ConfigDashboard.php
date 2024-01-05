<?php

namespace App\Livewire\Admin\Config;

use Livewire\Component;

class ConfigDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.config.config-dashboard')
            ->layout("components.layouts.admin");
    }
}
