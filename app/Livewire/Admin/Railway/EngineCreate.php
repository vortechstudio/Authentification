<?php

namespace App\Livewire\Admin\Railway;

use App\Models\Railway\EngineTechnical;
use Livewire\Attributes\Title;
use Livewire\Component;

class EngineCreate extends Component
{
    public string $name = '';

    public string $type_transport = '';

    public string $type_train = '';

    public string $type_energy = '';

    public bool $active = false;

    public bool $in_shop = false;

    public bool $in_game = false;

    public string $visual = '';

    public string $price_shop = '';

    public string $money_shop = '';

    public string $essieux = '';

    public string $velocity = '';

    public string $type_motor = '';

    public string $type_marchandise = '';

    public string $nb_marchandise = '';

    public string $nb_wagon = '';

    #[Title("Création d'un matériel roulant")]
    public function render()
    {
        return view('livewire.admin.railway.engine-create')
            ->layout('components.layouts.admin');
    }

    public function addEngine()
    {
        $this->validate([
            'name' => 'required',
            'type_transport' => 'required',
            'type_train' => 'required',
            'type_energy' => 'required',
            'essieux' => 'required',
            'velocity' => 'required',
            'type_motor' => 'required',
            'type_marchandise' => 'required',
        ]);

        $duree_maintenance = \App\Models\Railway\Engine::calcDurationMaintenance($this->essieux);

        $engine = \App\Models\Railway\Engine::create([
            'uuid' => \Str::uuid(),
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'type_transport' => $this->type_transport,
            'type_train' => $this->type_train,
            'type_energy' => $this->type_energy,
            'duration_maintenance' => $duree_maintenance,
            'active' => $this->active,
            'in_shop' => $this->in_shop,
            'in_game' => $this->in_game,
            'visual' => $this->visual,
            'price_shop' => $this->price_shop,
            'money_shop' => $this->money_shop,
        ]);

        EngineTechnical::create([
            'essieux' => $this->essieux,
            'velocity' => $this->velocity,
            'type_motor' => $this->type_motor,
            'type_marchandise' => $this->type_marchandise,
            'nb_wagon' => $this->nb_wagon,
            'engine_id' => $engine->id,
        ]);

        session()->flash('success', 'Le matériel roulant à été créer avec succès');
        $this->redirectRoute('admin.railway.engines');
    }
}
