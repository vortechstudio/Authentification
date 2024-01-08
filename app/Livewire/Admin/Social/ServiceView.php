<?php

namespace App\Livewire\Admin\Social;

use App\Models\ServiceNote;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceView extends Component
{
    use WithPagination;

    public \App\Models\Service $service;

    public $notes;

    // Field Note version
    public $version = '';

    public $title = '';

    public $description = '';

    public $contenue = '';

    public bool $published = false;

    public $published_at = '';

    public function mount($id)
    {
        $this->service = \App\Models\Service::find($id);
        $this->notes = $this->service->notes;
    }

    #[Title("Gestion d'un service")]
    public function render()
    {
        return view('livewire.admin.social.service-view')
            ->layout('components.layouts.admin');
    }

    public function changeStatus()
    {
        match ($this->service->status) {
            'idea' => $this->service->update(['status' => 'develop']),
            'develop' => $this->service->update(['status' => 'production'])
        };

        session()->flash('success', 'Changement de status accepté');
        $this->redirectRoute('admin.social.services.view', $this->service->id);
    }

    public function delete()
    {
        $this->service->delete();

        session()->flash('success', 'Le service à été supprimer avec succès');
        $this->redirectRoute('admin.social.services');
    }

    public function postNote()
    {
        $this->validate([
            'version' => 'required',
            'title' => 'required',
            'contenue' => 'required',
        ]);

        ServiceNote::create([
            'version' => $this->version,
            'title' => $this->title,
            'description' => $this->description,
            'contenue' => $this->contenue,
            'published' => $this->published,
            'published_at' => $this->published ? ($this->published_at == '' ? now() : Carbon::createFromTimestamp(strtotime($this->published_at))) : null,
            'service_id' => $this->service->id,
        ]);

        $this->service->update([
            'latest_version' => $this->version,
        ]);

        session()->flash('success', "La note de mise à jour <strong>{$this->title}</strong> a été créer avec succès");
        if ($this->published) {
            if ($this->published_at <= now()->endOfHour()) {
                session()->flash('info', 'La note à été publier avec succès');
            } else {
                session()->flash('info', 'La note va être publier le: '.$this->published_at->format('d/m/Y à H:i'));
            }
        }
        $this->redirectRoute('admin.social.services.view', $this->service->id);
    }

    public function deleteNote($id)
    {
        ServiceNote::find($id)->delete();
        $this->service->update([
            'latest_version' => ServiceNote::orderBy('published_at', 'desc')->first() ? ServiceNote::orderBy('published_at', 'desc')->first()->version : null,
        ]);

        session()->flash('success', 'La note de mise à jour à été supprimer');

    }
}
