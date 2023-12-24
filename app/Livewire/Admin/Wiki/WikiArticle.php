<?php

namespace App\Livewire\Admin\Wiki;

use App\Models\Wiki\Wiki;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class WikiArticle extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    public string $orderField = 'title';
    public string $orderDirection = 'ASC';
    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    #[Title("Gestion des articles du wiki")]
    public function render()
    {
        return view('livewire.admin.wiki.wiki-article', [
            "articles" => Wiki::with('category', 'subcategory', 'contributors')
            ->where('title', 'like', "%{$this->search}%")
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate($this->perPage)
        ])->layout("components.layouts.admin");
    }

    public function setOrderField(string $name)
    {
        if($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : "ASC";
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function deleteArticle(int $article_id)
    {
        Wiki::find($article_id)
            ->delete();

        session()->flash('success', "Cette article à été supprimer");
    }
}
