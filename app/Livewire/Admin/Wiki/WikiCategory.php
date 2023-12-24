<?php

namespace App\Livewire\Admin\Wiki;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class WikiCategory extends Component
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
    public int $category_id = 0;
    public int $edit_cat = 0;
    public string $name = '';
    public int $cercle_id = 0;
    #[Title("Gestion des catégories du wiki")]
    public function render()
    {
        return view('livewire.admin.wiki.wiki-category', [
            "categories" => \App\Models\Wiki\WikiCategory::with('cercle', 'subcategories')
            ->where('name', 'like', "%{$this->search}%")
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
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

    private function resetField()
    {
        $this->name = '';
        $this->cercle_id = 0;
    }

    public function addCategory()
    {
        $this->validate([
            "name" => "required",
            "cercle_id" => "required"
        ]);

        \App\Models\Wiki\WikiCategory::create([
            "name" => $this->name,
            "icon" => "1.png",
            "cercle_id" => $this->cercle_id
        ]);
        $this->resetField();

        session()->flash("success", "La catégorie <strong>{$this->name}</strong> a été créé avec succès");
    }

    public function showSubcategory(int $category_id)
    {
        $this->category_id = $category_id;
    }

    public function startEditCategory(int $category_id)
    {
        $this->edit_cat = $category_id;
    }

    public function editCategory()
    {
        \App\Models\Wiki\WikiCategory::find($this->edit_cat)
            ->update([
                "name" => $this->name,
                "cercle_id" => $this->cercle_id,
            ]);

        $this->resetField();

        session()->flash("success", "La catégorie <strong>{$this->name}</strong> a été edité avec succès");
    }

    public function addSubCategory()
    {
        $this->validate([
            "name" => "required"
        ]);

        \App\Models\Wiki\WikiSubcategory::create([
            "name" => $this->name,
            "wiki_category_id" => $this->category_id
        ]);
        $this->resetField();

        session()->flash("success", "La sous catégorie <strong>{$this->name}</strong> a été créé avec succès");
    }

    public function deleteCategory($category_id)
    {
        \App\Models\Wiki\WikiCategory::find($category_id)
            ->delete();

        session()->flash('success', "La catégorie à été supprimé");
    }

    public function deleteSubCategory($subcategory_id)
    {
        \App\Models\Wiki\WikiSubcategory::find($subcategory_id)
            ->delete();

        session()->flash('success', "La sous catégorie à été supprimer");
    }
}
