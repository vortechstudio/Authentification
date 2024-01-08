<?php

namespace App\Livewire\Admin\Social;

use App\Models\Cms;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PageCreate extends Component
{
    #[Validate('required|max:255')]
    public $title = '';

    #[Validate('required')]
    public $content = '';

    public bool $published = false;

    public int $parent_id = 0;

    #[Title("Création d'une page")]
    public function render()
    {
        return view('livewire.admin.social.page-create')
            ->layout('components.layouts.admin');
    }

    public function store()
    {
        $page = Cms::create([
            'title' => $this->title,
            'content' => $this->content,
            'published' => $this->published,
            'published_at' => $this->published ? now() : null,
            'parent_id' => $this->parent_id == 0 ?? $this->parent_id,
        ]);

        session()->flash('success', 'La page à été créer avec succès');
        if ($page->published) {
            session()->flash('success', 'La page à été publié et est disponible sur le site');
        }

        $this->redirectRoute('admin.social.pages');
    }
}
