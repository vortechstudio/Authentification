<?php

namespace App\Livewire\Admin\Railway\Gare;

use App\Models\Railway\Gare;
use Livewire\Attributes\Title;
use Livewire\Component;

class GareShow extends Component
{
    public Gare $gare;

    public function mount($id)
    {
        $this->gare = Gare::find($id);
    }
    #[Title("Fiche de la gare")]
    public function render()
    {
        return view('livewire.admin.railway.gare.gare-show')
            ->layout("components.layouts.admin");
    }

    public function production()
    {
        $this->gare->hub->update([
            "visual" => "prod"
        ]);

        session()->flash("success", "Gare passer en production");
    }

    public function desactive()
    {
        $this->gare->hub->update([
            "active" => false
        ]);

        session()->flash("success", "Gare désactiver");
    }

    public function active()
    {
        $this->gare->hub->update([
            "active" => true
        ]);

        session()->flash("success", "Gare Activé");
    }

    public function delete()
    {
        $this->gare->delete();

        session()->flash("success", "Gare supprimer");
        $this->redirectRoute("admin.railway.gares");
    }
}
