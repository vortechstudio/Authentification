<?php

namespace App\Livewire\Admin\Social;

use App\Models\Cms;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    #[Title("Gestion des Pages")]
    public function render()
    {
        $this->resetPage();
        return view('livewire.admin.social.page', [
            'pages' => Cms::where('title', 'like', "%{$this->search}%")
                ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
    }

    public function deletePage($page_id)
    {
        Cms::find($page_id)->delete();
        session()->flash('success', "L'article à bien été supprimé");
    }
}
