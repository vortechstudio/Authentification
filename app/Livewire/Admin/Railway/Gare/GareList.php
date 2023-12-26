<?php

namespace App\Livewire\Admin\Railway\Gare;

use App\Models\Railway\Gare;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class GareList extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    public string $orderField = 'name';
    public string $orderDirection = 'ASC';
    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    #[Title("Gestion des gares")]
    public function render()
    {
        return view('livewire.admin.railway.gare.gare-list', [
            "gares" => Gare::with('hub', 'stations')
            ->where('name', 'like', "%{$this->search}%")
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate($this->perPage)
        ])
            ->layout("components.layouts.admin");
    }

    public function setOrderField(string $name)
    {
        if($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : "ASC";
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function delete($id)
    {
        $gare = Gare::find($id);
        $gare->delete();


        session()->flash('success', "La Gare <strong>{$gare->name}</strong> a été supprimer");
    }
}
