<?php

namespace App\Livewire\Admin\Social;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Service extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    #[Title("Gestion des services")]
    public function render()
    {
        return view('livewire.admin.social.service', [
            "services" => \App\Models\Service::with('notes')
                    ->where('name', 'like', "%{$this->search}%")
                    ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
    }
}
