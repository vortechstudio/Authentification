<?php

namespace App\Livewire\Admin\Railway\Ligne;

use App\Models\Railway\Ligne;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class LigneShow extends Component
{
    use LivewireAlert;

    public Ligne $ligne;

    public function mount($id)
    {
        $this->ligne = Ligne::find($id);
    }

    #[Title("Fiche d'une ligne")]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.railway.ligne.ligne-show')
            ->layout('components.layouts.admin');
    }

    public function refresh(): void
    {
        $this->redirectRoute('admin.railway.lignes.show', $this->ligne->id);
    }

    public function calculateDistance()
    {
        $data = $this->ligne->stations()->sum('distance');

        $this->ligne->distance = $data;
        $this->ligne->save();

        $this->alert('success', $this->ligne->name, [
            'text' => 'La distance à bien été calculer',
        ]);
    }

    public function calculatePrice()
    {
        if ($this->ligne->distance == 0) {
            $this->alert('warning', $this->ligne->name, [
                'text' => 'Veuillez effectuer le calcule de distance avant !',
            ]);
        } else {
            $this->ligne->update([
                'price' => Ligne::calcPrice($this->ligne),
            ]);

            $this->alert('success', $this->ligne->name, [
                'text' => 'Le prix de la ligne à bien été calculer',
            ]);
        }
    }

    public function production()
    {
        $this->ligne->update([
            'visual' => 'prod',
        ]);

        $this->alert('success', $this->ligne->name, [
            'text' => 'La ligne est maintenant en production',
        ]);
    }

    public function activate()
    {
        $this->ligne->update([
            'active' => true,
        ]);

        $this->alert('success', $this->ligne->name, [
            'text' => 'La ligne est maintenant active',
        ]);
    }

    public function desactivate()
    {
        $this->ligne->update([
            'active' => false,
        ]);

        $this->alert('success', $this->ligne->name, [
            'text' => 'La ligne est maintenant désactiver',
        ]);
    }

    public function delete()
    {
        $ligne = $this->ligne;
        $ligne->delete();

        $this->alert('success', $this->ligne->name, [
            'text' => 'La ligne à été supprimer',
        ]);
    }
}
