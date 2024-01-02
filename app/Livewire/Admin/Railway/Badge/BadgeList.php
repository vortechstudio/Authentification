<?php

namespace App\Livewire\Admin\Railway\Badge;

use App\Models\Railway\RailwayBadge;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class BadgeList extends Component
{
    use WithPagination, LivewireAlert;
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
    public string $action = '';
    public string $action_count = '';
    #[Title("Gestion des Badges & Récompenses")]
    public function render()
    {
        return view('livewire.admin.railway.badge.badge-list', [
            "badges" => RailwayBadge::where('name', "like", "%{$this->search}%")
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate($this->perPage)
        ])
            ->layout("components.layouts.admin");
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

    public function adding()
    {
        RailwayBadge::create([
            "name" => $this->name,
            "uuid" => \Str::uuid(),
            "action" => $this->action,
            "action_count" => $this->action_count
        ]);

        $this->alert('success', 'Badge ajoute avec success');
    }

    public function delete($id)
    {
        $badge = RailwayBadge::find($id);
        $badge->delete();

        $this->alert('success', 'Badge supprimé avec success');
    }
}
