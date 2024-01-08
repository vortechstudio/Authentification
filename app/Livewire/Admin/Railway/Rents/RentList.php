<?php

namespace App\Livewire\Admin\Railway\Rents;

use App\Models\Railway\RailwayRental;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Str;

class RentList extends Component
{
    use LivewireAlert, WithFileUploads, WithPagination;

    public string $search = '';

    public int $perPage = 5;

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public string $name = '';

    public string $contract_duration = '';

    public array $type = [];

    public $logo;

    #[Title('Gestion des services de locations')]
    public function render()
    {
        return view('livewire.admin.railway.rents.rent-list', [
            'rentals' => RailwayRental::where('name', 'like', "%{$this->search}%")
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

    private function resetField()
    {
        $this->name = '';
        $this->contract_duration = '';
        $this->type = [];
        $this->logo = null;
    }

    public function adding()
    {
        RailwayRental::create([
            'name' => $this->name,
            'uuid' => \Str::uuid(),
            'contract_duration' => $this->contract_duration,
            'type' => $this->type,
        ]);

        if (isset($this->logo)) {
            $this->logo->storeAs('/logos/rentals', Str::slug($this->name).'.png', 'public');
        }

        $this->resetField();

        $this->alert('success', 'Le service de location a été ajouter');
    }

    public function delete($id)
    {
        $rental = RailwayRental::find($id);
        $rental->delete();

        \Storage::disk('public')->delete('/logos/rentals/'.Str::slug($rental->name).'.png');

        $this->alert('success', 'Le service de location a été supprimer');
    }
}
