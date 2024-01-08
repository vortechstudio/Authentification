<?php

namespace App\Livewire\Admin\Railway;

use Livewire\Attributes\Title;
use Livewire\Component;

class EngineShow extends Component
{
    public \App\Models\Railway\Engine $engine;

    public function mount(int $id)
    {
        $this->engine = \App\Models\Railway\Engine::find($id);
    }

    #[Title("Fiche d'un matériel")]
    public function render()
    {
        return view('livewire.admin.railway.engine-show')
            ->layout('components.layouts.admin');
    }

    public function active()
    {
        $this->engine->update([
            'active' => true,
        ]);

        session()->flash('success', 'Matériel roulant activé');
    }

    public function inactive()
    {
        $this->engine->update([
            'active' => false,
        ]);

        session()->flash('success', 'Matériel roulant désactivé');
    }

    public function production()
    {
        $this->engine->update([
            'visual' => 'prod',
        ]);

        session()->flash('success', 'Matériel roulant passer en production');
    }

    public function delete()
    {
        $this->engine->delete();

        session()->flash('success', 'Matériel roulant supprimé');
        $this->redirectRoute('admin.railway.engines');
    }
}
