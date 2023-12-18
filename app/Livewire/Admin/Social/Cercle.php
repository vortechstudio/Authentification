<?php

namespace App\Livewire\Admin\Social;

use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Cercle extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    #[Validate('required|max:255')]
    public $name = '';
    #[Title("Liste des cercles")]
    public function render()
    {
        $this->resetPage();
        return view('livewire.admin.social.cercle', [
            "cercles" => \App\Models\Social\Cercle::where('name', 'like', "%{$this->search}%")
            ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
    }

    public function store()
    {
        \App\Models\Social\Cercle::create([
            "name" => $this->name
        ]);

        session()->flash('success', "Le cercle à été ajouté avec succès");
        $this->redirectRoute('admin.social.cercles');
    }

    public function deleteCercle($cercle_id)
    {
        \App\Models\Social\Cercle::find($cercle_id)->delete();
        session()->flash('success', "Le cercle à bien été supprimé");
    }
}
