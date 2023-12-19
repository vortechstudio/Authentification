<?php

namespace App\Livewire\Admin\Social;

use Livewire\Attributes\Title;
use Livewire\Component;

class ServiceCreate extends Component
{
    public $name = '';
    public $type = '';
    public $description = '';
    public $status = '';
    public $url_site = '';

    #[Title("Création d'un service")]
    public function render()
    {
        return view('livewire.admin.social.service-create')
            ->layout('components.layouts.admin');
    }

    public function store()
    {
        $this->validate([
            'name' => "required|max:255",
            "type" => "required",
            "description" => "required"
        ]);

        $service = \App\Models\Service::create([
            "name" => $this->name,
            "type" => $this->type,
            "description" => $this->description,
            "status" => $this->status,
            "url_site" => $this->url_site,
            "page_content" => "{}"
        ]);

        session()->flash("success", "Le service {$this->name} à été ajouter avec succès");
        session()->flash("info", "Veuillez remplir la page du service de manière général");

        $this->redirectRoute('admin.social.services.editor', $service->id);
    }
}
