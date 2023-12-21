<?php

namespace App\Livewire\Admin\Social;

use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Event extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    public string $orderField = 'title';
    public string $orderDirection = 'ASC';

    public string $title = '';
    public string $start_at = '';
    public string $end_at = '';
    public string $synopsis = '';
    public string $contenue = '';
    public string $type_event = '';
    public int $cercle_id = 0;
    public int $showId = 0;
    public int $editId = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    #[Title("Gestion des Evénements")]
    public function render()
    {
        return view('livewire.admin.social.event', [
            "events" => \App\Models\Social\Event::where('title', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
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

    private function resetField()
    {
        $this->title = '';
        $this->start_at = '';
        $this->end_at = '';
        $this->synopsis = '';
        $this->contenue = '';
        $this->type_event = '';
        $this->cercle_id = '';
    }

    public function createEvent()
    {
        $this->validate([
            "title" => "required",
            "start_at" => "required",
            "end_at" => "required",
            "synopsis" => "required",
            "contenue" => "required",
            "type_event" => "required",
            "cercle_id" => "required",
        ]);

        $event = \App\Models\Social\Event::create([
            "title" => $this->title,
            "start_at" => Carbon::createFromTimestamp(strtotime($this->start_at)),
            "end_at" => Carbon::createFromTimestamp(strtotime($this->end_at)),
            "synopsis" => $this->synopsis,
            "content" => $this->contenue,
            "type_event" => $this->type_event
        ]);

        \App\Models\Social\Cercle::find($this->cercle_id)->events()->attach($event->id);

        session()->flash('message', "L'évènement à été créer avec succès");

    }

    public function startShow(int $id)
    {
        $this->showId = $id;
    }

    public function startEdit(int $id)
    {
        $this->editId = $id;
    }
}
