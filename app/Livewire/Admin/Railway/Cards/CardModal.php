<?php

namespace App\Livewire\Admin\Railway\Cards;

use App\Livewire\Forms\Admin\Railway\Cards\CardForm;
use App\Models\Railway\RailwayAdvantageCard;
use LivewireUI\Modal\ModalComponent;

class CardModal extends ModalComponent
{
    public ?RailwayAdvantageCard $card = null;

    public CardForm $form;

    public function mount(?RailwayAdvantageCard $card = null)
    {
        if ($card && $card->exists) {
            $this->form->setCard($card);
        }
    }

    public function save()
    {
        $this->form->save();
        $this->closeModal();
        $this->dispatch('refresh-list');
    }

    public function render()
    {
        return view('livewire.admin.railway.cards.card-modal');
    }
}
