<?php

namespace App\Livewire\Admin\Social;

use App\Models\Blog;
use Livewire\Attributes\Title;
use Livewire\Component;

class ArticleEdit extends Component
{
    public Blog $article;

    public function mount($id)
    {
        $this->article = Blog::find($id);
    }

    #[Title("Edition d'un article")]
    public function render()
    {
        return view('livewire.admin.social.article-edit')
            ->layout('components.layouts.admin');
    }

    public function update()
    {
        $this->article->save();

        session()->flash('message', "L'article ".$this->article->title.' à été édité');
        $this->redirectRoute('admin.social.articles');
    }
}
