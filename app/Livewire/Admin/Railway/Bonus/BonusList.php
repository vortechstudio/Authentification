<?php

namespace App\Livewire\Admin\Railway\Bonus;

use App\Models\Railway\RailwayBonus;
use Livewire\Attributes\Title;
use Livewire\Component;

class BonusList extends Component
{
    #[Title('Gestion des bonus journaliers')]
    public function render()
    {
        return view('livewire.admin.railway.bonus.bonus-list', [
            'bonuses' => RailwayBonus::all(),
        ])
            ->layout('components.layouts.admin');
    }
}
