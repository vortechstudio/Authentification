<?php

namespace App\Livewire\Forms\Admin\Railway\Cards;

use App\Models\Railway\RailwayAdvantageCard;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CardForm extends Form
{
    public ?RailwayAdvantageCard $card = null;
    public string $class = '';
    public string $type = '';
    public float $qte = 0;
    public int $tpoint_cost = 0;
    public int|null $model_id = null;

    public function setCard(?RailwayAdvantageCard $card = null)
    {
        $this->card = $card;
        $this->class = $card->class;
        $this->type = $card->type;
        $this->qte = $card->qte;
        $this->tpoint_cost = $card->tpoint_cost;
        $this->model_id = $card->model_id;
    }

    public function save()
    {
        $this->validate();

        if(!$this->card) {
            RailwayAdvantageCard::create([
                "class" => $this->class,
                "type" => $this->type,
                "description" => RailwayAdvantageCard::generateDescriptionFromType($this->type, $this->qte),
                "qte" => $this->qte,
                "tpoint_cost" => $this->tpoint_cost,
                "drop_rate" => RailwayAdvantageCard::calculateDropRateByType($this->qte, $this->type),
                "model_id" => $this->model_id,
            ]);
        } else {
            $this->card->update([
                "class" => $this->class,
                "type" => $this->type,
                "description" => RailwayAdvantageCard::generateDescriptionFromType($this->type, $this->qte),
                "qte" => $this->qte,
                "tpoint_cost" => $this->tpoint_cost,
                "drop_rate" => RailwayAdvantageCard::calculateDropRateByType($this->qte, $this->type),
                "model_id" => $this->model_id,
            ]);
        }
        $this->reset();
    }

    public function rules()
    {
        return [
            'class' => ['required', 'string'],
            'type' => ['required', 'string'],
            'qte' => ['required', 'numeric'],
            'tpoint_cost' => ['required', 'numeric'],
            'model_id' => ['nullable', 'numeric'],
        ];
    }
}
