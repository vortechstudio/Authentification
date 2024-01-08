<?php

namespace App\Livewire\Admin\Social;

use Livewire\Attributes\Title;
use Livewire\Component;

class ServiceEditor extends Component
{
    public \App\Models\Service $service;

    public $page_content = '';

    public function mount($id)
    {
        $this->service = \App\Models\Service::find($id);
    }

    #[Title('Edition du contenue du service')]
    public function render()
    {
        return view('livewire.admin.social.service-editor')
            ->layout('components.layouts.admin');
    }

    public function update()
    {
        $this->service->update([
            'page_content' => $this->page_content,
        ]);

        session()->flash('success', 'Le contenue à été édité avec succès');

        $this->redirectRoute('admin.social.services');
    }
}
