<?php

namespace App\Livewire\Admin\Wiki;

use Livewire\Component;
use Livewire\WithPagination;

class WikiSubcategory extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    public string $orderField = 'name';
    public string $orderDirection = 'ASC';
    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    public $category;

    public function mount($category_id)
    {
        $this->category = \App\Models\Wiki\WikiCategory::find($category_id);
    }
    public function render()
    {
        return view('livewire.admin.wiki.wiki-subcategory', [
            "subcategories" => \App\Models\Wiki\WikiSubcategory::where('wiki_category_id', $this->category->id)
            ->where('name', 'like', "%{$this->search}%")
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
}
