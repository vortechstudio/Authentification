<?php

namespace App\Livewire\Admin\Wiki;

use App\Models\Wiki\Wiki;
use Livewire\Attributes\Title;
use Livewire\Component;

class WikiArticleEdit extends Component
{
    public Wiki $wiki;
    public string $title = '';
    public string $synopsis = '';
    public string $content = '';
    public bool $posted = false;
    public string|null $posted_at = null;
    public int $wiki_category_id = 0;
    public int $wiki_subcategory_id = 0;

    public function mount($id)
    {
        $this->wiki = Wiki::find($id);
    }
    #[Title("Edition d'un article")]
    public function render()
    {
        return view('livewire.admin.wiki.wiki-article-edit', [
            "categories" => \App\Models\Wiki\WikiCategory::selector(),
            "subcategories" => \App\Models\Wiki\WikiSubcategory::selector()
        ])
            ->layout("components.layouts.admin");
    }

    public function editArticle()
    {
        $this->wiki->update([
            "title" => $this->title != $this->wiki->title ? $this->title : $this->wiki->title,
            "synopsis" => $this->synopsis != $this->wiki->synopsis ? $this->synopsis : $this->wiki->synopsis,
            "content" => $this->content != $this->wiki->content ? $this->content : $this->wiki->content,
            "posted" => $this->posted != $this->wiki->posted ? $this->posted : $this->wiki->posted,
            "wiki_category_id" => $this->wiki_category_id != $this->wiki->wiki_category_id,
            "wiki_subcategory_id" => $this->wiki_category_id != $this->wiki->wiki_subcategory_id,
        ]);

        toastr()->addSuccess( "L'article " . $this->wiki->title . " à été édité");
        $this->redirectRoute('admin.wiki.articles');
    }
}
