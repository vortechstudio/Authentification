<?php

namespace App\Livewire\Account;

use Livewire\Attributes\Title;
use Livewire\Component;

class HistoryAccount extends Component
{
    #[Title('Historique du compte')]
    public function render()
    {
        return view('livewire.account.history-account')->layout('components.layouts.app');
    }
}
