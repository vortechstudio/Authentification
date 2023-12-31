<?php

namespace App\Livewire\Admin\Railway\Config;

use App\Models\Railway\RailwaySetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ConfigEdit extends Component
{
    use LivewireAlert,WithPagination;
    public RailwaySetting $setting;
    public string $name = '';
    public string $value = "";

    public function mount() {
        $this->name = $this->setting->name;
        $this->value = $this->setting->value;
    }

    public function render()
    {
        return view('livewire.admin.railway.config.config-edit');
    }

    public function save()
    {
        $this->validate([
            "setting.value" => "required",
        ]);
        $this->setting->update([
            "name" => $this->name,
            "value" => $this->value
        ]);

        $this->alert("success", "La configuration a bien été modifiée");
        $this->resetPage();
    }
}
