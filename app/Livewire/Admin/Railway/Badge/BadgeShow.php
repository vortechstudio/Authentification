<?php

namespace App\Livewire\Admin\Railway\Badge;

use App\Models\Railway\RailwayBadge;
use App\Models\Railway\RailwayBadgeReward;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class BadgeShow extends Component
{
    use LivewireAlert, WithPagination;

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
            'rewards' => $this->badge->rewards()->where('type', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ])
            ->layout('components.layouts.admin', ['subpage' => $this->badge->name]);
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

    public function adding()
    {
        $this->badge->rewards()->create([
            'type' => $this->type,
            'value' => $this->value,
            'railway_badge_id' => $this->badge->id,
        ]);

        $this->alert('success', 'Récompense ajoute avec success');
    }

    public function delete($id)
    {
        $reward = RailwayBadgeReward::find($id);
        $reward->delete();

        $this->alert('success', 'Récompense supprimé avec success');
    }
}
