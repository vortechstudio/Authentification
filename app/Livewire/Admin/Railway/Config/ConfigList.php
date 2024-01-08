<?php

namespace App\Livewire\Admin\Railway\Config;

use App\Models\Railway\RailwaySetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ConfigList extends Component
{
    use LivewireAlert, WithPagination;

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

    public string $value = '';

    public int $editId = 0;

    #[Title('Gestion de la configuration globale')]
    public function render()
    {
        return view('livewire.admin.railway.config.config-list', [
            'settings' => RailwaySetting::where('name', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ])
            ->layout('components.layouts.admin');
    }

    /**
     * @codeCoverageIgnore
     */
    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function startEdit(int $id): void
    {
        $this->editId = $id;
    }

    public function adding()
    {
        $this->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        RailwaySetting::create([
            'name' => $this->name,
            'value' => $this->value,
        ]);

        $this->resetPage();
        $this->reset();

        $this->alert('success', 'Configuration ajoutée avec succès');
    }

    public function editing(int $id)
    {
        $this->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        RailwaySetting::find($id)->update([
            'name' => $this->name,
            'value' => $this->value,
        ]);

        $this->resetPage();
        $this->reset();

        $this->alert('success', 'Configuration modifiée avec succès');
    }

    /**
     * @codeCoverageIgnore
     */
    public function updating($name, $value)
    {
        if ($name === 'search') {
            $this->resetPage();
        }
    }
}
