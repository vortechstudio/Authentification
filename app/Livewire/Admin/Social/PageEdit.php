<?php

namespace App\Livewire\Admin\Social;

use App\Models\Cms;
use Livewire\Attributes\Title;
use Livewire\Component;

class PageEdit extends Component
{
    public Cms $page;
    public $title = '';
    public $content = '';
    public $published;
    public $parent_id;

    public function mount($id)
    {
        $this->page = Cms::find($id);
        $this->page->published ? $this->published = true : $this->published = false;
    }
    #[Title("Edition d'une page")]
    public function render()
    {
        return view('livewire.admin.social.page-edit')
            ->layout('components.layouts.admin');
    }

    public function update()
    {
        dd($this->all());
        try {
            $this->page->save();
        }catch (\Exception $exception) {
            session()->flash('error', "Un problème à eu lieu lors de la sauvegarde des informations : <strong>{$exception->getMessage()}</strong>");
        }

        session()->flash('success', "La page " . $this->page->title . " à été édité");
        $this->redirectRoute('admin.social.pages');
    }
}
