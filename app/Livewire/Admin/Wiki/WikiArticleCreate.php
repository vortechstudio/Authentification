<?php

namespace App\Livewire\Admin\Wiki;

use App\Models\Wiki\Wiki;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

class WikiArticleCreate extends Component
{
    public string $title = '';

    public string $synopsis = '';

    public string $content = '';

    public bool $posted = false;

    public ?string $posted_at = null;

    public int $wiki_category_id = 0;

    public int $wiki_subcategory_id = 0;

    //---------------//
    #[Title("Création d'un article")]
    public function render()
    {
        return view('livewire.admin.wiki.wiki-article-create', [
            'categories' => \App\Models\Wiki\WikiCategory::selector(),
            'subcategories' => \App\Models\Wiki\WikiSubcategory::selector(),
        ])
            ->layout('components.layouts.admin');
    }

    public function addArticle()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'wiki_category_id' => 'required',
            'wiki_subcategory_id' => 'required',
        ]);

        Wiki::create([
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'content' => $this->content,
            'posted' => $this->posted,
            'posted_at' => $this->posted ? ($this->posted_at ? Carbon::createFromTimestamp(strtotime($this->posted_at)) : now()) : null,
            'wiki_category_id' => $this->wiki_category_id,
            'wiki_subcategory_id' => $this->wiki_subcategory_id,
        ]);

        session()->flash('success', "L'article <strong>{$this->title}</strong> a été créé avec succès");
        $this->redirectRoute('admin.wiki.articles');
    }
}
