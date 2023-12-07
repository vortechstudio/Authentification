<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    public $datas;
    public $tableName;

    public function mount($datas, $tableName)
    {
        $this->datas = $datas;
        $this->tableName = $tableName;
    }

    public function render()
    {
        return view('livewire.component.table');
    }

}
