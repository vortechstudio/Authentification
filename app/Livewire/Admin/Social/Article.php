<?php

namespace App\Livewire\Admin\Social;

use App\Models\Blog;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Article extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public string $subcategory = '';

    public int $article_id = 0;

    public int $perPage = 5;

    #[Title('Gestion des Articles')]
    public function render()
    {
        $this->resetPage();

        return view('livewire.admin.social.article', [
            'articles' => Blog::where('title', 'like', "%{$this->search}%")
                ->where('category', 'like', "%{$this->category}%")
                ->where('subcategory', 'like', "%{$this->subcategory}%")
                ->paginate($this->perPage),
        ])
            ->layout('components.layouts.admin');
    }

    public function deleteArticle($article_id)
    {
        Blog::find($article_id)->delete();

        session()->flash('message', 'Article supprimé avec succès.');
    }
}
