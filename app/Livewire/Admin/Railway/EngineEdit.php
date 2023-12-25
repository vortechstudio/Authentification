<?php

namespace App\Livewire\Admin\Railway;

use Livewire\Attributes\Title;
use Livewire\Component;

class EngineEdit extends Component
{
    public \App\Models\Railway\Engine $engine;

    #[Title("Edition d'un matériel roulant")]
    public function render()
    {
        return view('livewire.admin.railway.engine-edit')
            ->layout("components.layouts.admin");
    }
}
