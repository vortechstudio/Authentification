<?php

namespace App\Livewire\Account;

use Livewire\Attributes\Title;
use Livewire\Component;

class HistoryLogin extends Component
{
    #[Title('Historique de connexion')]
    public function render()
    {
        return view('livewire.account.history-login')->layout('components.layouts.app');
    }
}
