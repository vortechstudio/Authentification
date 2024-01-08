<?php

namespace App\Livewire\Admin\Railway;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Engine extends Component
{
    use WithPagination;

    public string $search = '';

    public string $type_train = '';

    public int $perPage = 5;

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    protected array $queryString = [
        'search' => ['except' => ''],
        'type_train' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    #[Title('Gestion des matériels roulants')]
    public function render()
    {
        return view('livewire.admin.railway.engine', [
            'engines' => \App\Models\Railway\Engine::where('name', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', "%{$this->type_train}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ])
            ->layout('components.layouts.admin');
    }

    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function deleteMateriel($id)
    {
        \App\Models\Railway\Engine::find($id)
            ->delete();

        session()->flash('success', 'Le matériel roulant à été supprimé');
    }
}
