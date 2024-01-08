<?php

namespace App\Livewire\Admin\Social;

use App\Models\Blog;
use App\Notifications\Social\IsPublishNotification;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ArticleCreate extends Component
{
    #[Validate('required|max:255')]
    public $title = '';

    public $category = '';

    public $cercle_id = '';

    public $subcategory = '';

    public $description = '';

    #[Validate('required')]
    public $contenue = '';

    public bool $published = false;

    public bool $publish_social = false;

    #[Validate('required')]
    public $author = '';

    public bool $promote = false;

    #[Title("Création d'un article")]
    public function render()
    {
        return view('livewire.admin.social.article-create')
            ->layout('components.layouts.admin');
    }

    public function store()
    {
        $article = Blog::create([
            'title' => $this->title,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'description' => $this->description,
            'contenue' => $this->contenue,
            'published' => $this->published,
            'published_at' => $this->published ? now() : null,
            'publish_to_social' => $this->publish_social,
            'publish_social_at' => $this->publish_social ? now() : null,
            'promote' => $this->promote,
            'author' => $this->author,
        ]);

        if ($article->published) {
            $article->notify(new IsPublishNotification('blog', $article));
        }

        session()->flash('message', "L'article a bien été enregistré");

        $this->redirectRoute('admin.social.articles');

    }
}
