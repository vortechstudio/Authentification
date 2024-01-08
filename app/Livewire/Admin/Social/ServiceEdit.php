<?php

namespace App\Livewire\Admin\Social;

use Livewire\Attributes\Title;
use Livewire\Component;

class ServiceEdit extends Component
{
    public \App\Models\Service $service;

    public function mount($id)
    {
        $this->service = \App\Models\Service::find($id);
    }

    #[Title("Edition d'un service")]
    public function render()
    {
        return view('livewire.admin.social.service-edit')
            ->layout('components.layouts.admin');
    }

    public function update()
    {
        $this->service->save();
    }
}
