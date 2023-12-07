<?php

namespace App\Livewire\Service;

use Livewire\Attributes\Title;
use Livewire\Component;

class AccessList extends Component
{
    #[Title('Etat des services & Options')]
    public function render()
    {
        return view('livewire.service.access-list');
    }
}
