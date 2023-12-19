<?php

namespace App\Livewire\Admin\Social;

use App\Models\ServiceNote;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceView extends Component
{
    use WithPagination;
    public \App\Models\Service $service;
    public $notes;


    public function mount($id)
    {
        $this->service = \App\Models\Service::find($id);
        $this->notes = $this->service->notes;
    }
    #[Title("Gestion d'un service")]
    public function render()
    {
        return view('livewire.admin.social.service-view')
            ->layout('components.layouts.admin');
    }

    public function changeStatus()
    {
        match ($this->service->status) {
            "idea" => $this->service->update(["status" => "develop"]),
            "develop" => $this->service->update(["status" => "production"])
        };

        session()->flash('success', "Changement de status accepté");
        $this->redirectRoute('admin.social.services.view', $this->service->id);
    }

    public function delete()
    {
        $this->service->delete();

        session()->flash("success", "Le service à été supprimer avec succès");
        $this->redirectRoute('admin.social.services');
    }
}
