<?php

namespace App\Livewire\Admin\Config\User;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserShow extends Component
{
    public ?User $user;

    public function mount(int $id)
    {
        $this->user = User::find($id);
    }
    #[Title("")]
    public function render()
    {
        return view('livewire.admin.config.user.user-show')
            ->layout("components.layouts.admin");
    }
}
