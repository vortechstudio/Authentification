<?php

namespace App\Livewire\Admin\Wiki;

use App\Models\Wiki\Wiki;
use Livewire\Attributes\Title;
use Livewire\Component;

class WikiArticleShow extends Component
{
    public Wiki $wiki;

    public function mount($id)
    {
        $this->wiki = Wiki::find($id);
    }
    #[Title("Fiche d'un article")]
    public function render()
    {
        return view('livewire.admin.wiki.wiki-article-show')
            ->layout("components.layouts.admin");
    }

    public function publish()
    {
        $this->wiki->update([
            "posted" => true,
            "posted_at" => now()
        ]);

        session()->flash("success", "Article publier");
    }

    public function unpublish()
    {
        $this->wiki->update([
            "posted" => false,
            "posted_at" => null
        ]);

        session()->flash("success", "Article dépublier");
    }

    public function delete()
    {
        $this->wiki->delete();

        session()->flash("success", "Article supprimer");
        $this->redirectRoute('admin.wiki.articles');
    }
}
