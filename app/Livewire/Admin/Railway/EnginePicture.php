<?php

namespace App\Livewire\Admin\Railway;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class EnginePicture extends Component
{
    public \App\Models\Railway\Engine $engine;

    public function mount($id)
    {
        $this->engine = \App\Models\Railway\Engine::find($id);
    }
    #[Title("Envoie des images du matériel roulant")]
    public function render()
    {
        return view('livewire.admin.railway.engine-picture')
            ->layout("components.layouts.admin");
    }
}
