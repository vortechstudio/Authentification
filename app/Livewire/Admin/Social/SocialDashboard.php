<?php

namespace App\Livewire\Admin\Social;

use Livewire\Attributes\Title;
use Livewire\Component;

class SocialDashboard extends Component
{
    #[Title("Sociales & Blogs")]
    public function render()
    {
        return view('livewire.admin.social.social-dashboard')
            ->layout('components.layouts.admin');
    }
}
