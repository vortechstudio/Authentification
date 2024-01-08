<?php

namespace App\Livewire\Admin\Railway\Cards;

use App\Models\Railway\RailwayAdvantageCard;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class CardsList extends Component
{
    use LivewireAlert,WithPagination;

    public string $search = '';

    public int $perPage = 25;

    public string $orderField = 'description';

    public string $orderDirection = 'ASC';

    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'description'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public string $type = '';

    public string $class = '';

    public float $qte = 0;

    public int $tpoint_cost = 0;

    public ?int $model_id = null;

    #[Title('Gestion des portes cartes')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = collect();
        $categories->push([
            'slug' => 'third',
            'name' => 'Troisième classe',
            'color_bg' => 'bg-grey-800',
            'color_text' => 'text-grey-300',
            'cards' => RailwayAdvantageCard::where('class', 'third')
                ->where('description', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
        $categories->push([
            'slug' => 'second',
            'name' => 'Seconde classe',
            'color_bg' => 'bg-red-800',
            'color_text' => 'text-red-300',
            'cards' => RailwayAdvantageCard::where('class', 'second')
                ->where('description', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
        $categories->push([
            'slug' => 'first',
            'name' => 'Première classe',
            'color_bg' => 'bg-blue-800',
            'color_text' => 'text-blue-300',
            'cards' => RailwayAdvantageCard::where('class', 'first')
                ->where('description', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
        $categories->push([
            'slug' => 'premium',
            'name' => 'Premium',
            'color_bg' => 'bg-yellow-800',
            'color_text' => 'text-yellow-300',
            'cards' => RailwayAdvantageCard::where('class', 'premium')
                ->where('description', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);

        return view('livewire.admin.railway.cards.cards-list', [
            'categories' => $categories,
        ])
            ->layout('components.layouts.admin');
    }

    public function refresh(): void
    {
        RailwayAdvantageCard::generateAll();
        $this->alert('success', 'Les cartes ont été générées');
    }

    public function adding()
    {
        $this->validate([
            'class' => 'required',
            'type' => 'required',
            'qte' => 'required',
            'tpoint_cost' => 'required',
        ]);

        RailwayAdvantageCard::create([
            'class' => $this->class,
            'type' => $this->type,
            'description' => RailwayAdvantageCard::generateDescriptionFromType($this->type, $this->qte),
            'qte' => $this->qte,
            'tpoint_cost' => $this->tpoint_cost,
            'drop_rate' => RailwayAdvantageCard::calculateDropRateByType($this->qte, $this->type),
            'model_id' => $this->model_id,
        ]);
        $this->reset();

        $this->alert('success', 'La carte a été ajoutée');

    }

    public function delete($id)
    {
        RailwayAdvantageCard::find($id)->delete();
        $this->alert('success', 'La carte a été supprimée');
    }

    /**
     * @codeCoverageIgnore
     */
    #[On('refresh-list')]
    public function refresh_list()
    {
    }
}
