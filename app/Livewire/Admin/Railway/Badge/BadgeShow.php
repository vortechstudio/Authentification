<?php

namespace App\Livewire\Admin\Railway\Badge;

use App\Models\Railway\RailwayBadge;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class BadgeShow extends Component
{
    use WithPagination, LivewireAlert;
    public string $search = '';
    public int $perPage = 5;
    public string $orderField = 'type';
    public string $orderDirection = 'ASC';
    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'type'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    public RailwayBadge $badge;
    public string $type = '';
    public string $value = '';

    public function mount($id)
    {
        $this->badge = RailwayBadge::find($id);
    }
    #[Title("Fiche d'un badge")]
    public function render()
    {
        return view('livewire.admin.railway.badge.badge-show', [
            "rewards" => $this->badge->rewards()->where('type', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage)
        ])
            ->layout("components.layouts.admin", ["subpage" => $this->badge->name]);
    }

    public function adding()
    {
        $this->badge->rewards()->create([
            "type" => $this->type,
            "value" => $this->value,
            "railway_badge_id" => $this->badge->id
        ]);

        $this->alert('success', 'Récompense ajoute avec success');
    }

    public function delete($id)
    {
        $reward = $this->badge->rewards()->find($id);
        $reward->delete();

        $this->alert('success', 'Récompense supprimé avec success');
    }
}
