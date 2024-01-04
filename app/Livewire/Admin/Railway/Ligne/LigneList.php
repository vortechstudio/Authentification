<?php

namespace App\Livewire\Admin\Railway\Ligne;

use App\Models\Railway\Ligne;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class LigneList extends Component
{
    use WithPagination;
    public int $perPage = 5;
    public string $orderField = 'hub_id';
    public string $orderDirection = 'ASC';
    protected array $queryString = [
        'orderField' => ['except' => 'hub_id'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    #[Title("Gestion des lignes")]
    public function render()
    {
        return view('livewire.admin.railway.ligne.ligne-list', [
            "lignes" => Ligne::with('start', 'end', 'hub')
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
    }

    /**
    * @codeCoverageIgnore
    */
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
        Ligne::find($id)
            ->delete();

        session()->flash('success', "La ligne à été supprimer");
    }
}
