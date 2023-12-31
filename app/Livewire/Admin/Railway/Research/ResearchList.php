<?php

namespace App\Livewire\Admin\Railway\Research;

use App\Models\Railway\ResearchCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Str;

class ResearchList extends Component
{
    use LivewireAlert, WithFileUploads;
    public string $name = '';
    public string $description = '';

    public string $name_research = '';
    public string $description_research = '';
    public int $research_category_id = 0;
    public int $coast_base = 0;
    public int $duration_base = 0;
    public $logo;
    #[Title("Gestion des recherches & développement")]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.railway.research.research-list', [
            "categories" => ResearchCategory::with('projects')
                ->get()
        ])
            ->layout('components.layouts.admin');
    }

    private function resetField(): void
    {
        $this->name = '';
        $this->description = '';
    }

    public function addingCategory(): void
    {
        $this->validate([
            'name' => 'required|string',
        ]);

        ResearchCategory::create([
            "name" => $this->name,
            "description" => $this->description
        ]);

        $this->alert('success', 'Catégorie ajoutée avec succès !');
        $this->resetField();
    }

    public function addingResearch(): void
    {
        $this->validate([
            'name_research' => 'required|string',
            'research_category_id' => 'required|integer',
            'coast_base' => 'required|integer',
            'duration_base' => 'required|integer',
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:1024',
        ]);

        $logo = $this->logo->store('research', 'public');
        if(isset($this->logo)) {
            $this->logo->storeAs('/icons/research', Str::slug($this->name_research).".png", 'public');
        }

        ResearchCategory::find($this->research_category_id)
            ->projects()
            ->create([
                "name" => $this->name_research,
                "description" => $this->description_research,
                "coast_base" => $this->coast_base,
                "duration_base" => $this->duration_base,
            ]);

        $this->alert('success', 'Recherche ajoutée avec succès !');
        $this->resetField();
    }

    public function deleteCategory($category_id): void
    {
        $category = \App\Models\Railway\ResearchCategory::find($category_id);
        $category->delete();

        $this->alert('success', 'Catégorie supprimée avec succès !');
    }

    public function deleteResearch($research_id): void
    {
        $research = \App\Models\Railway\ResearchProject::find($research_id);
        $research->delete();

        \Storage::disk('public')->delete('/icons/research/'.Str::slug($research->name).'.png');

        $this->alert('success', 'Recherche supprimée avec succès !');
    }
}
