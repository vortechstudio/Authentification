<?php

namespace App\Livewire\Admin\Railway\Ligne;

use App\Models\Railway\Gare;
use App\Models\Railway\Ligne;
use App\Models\Railway\LigneStation;
use Livewire\Component;

class LigneShowStation extends Component
{
    public array|object|null $stations;
    public Ligne $ligne;
    public int $gare_id = 0;

    protected $listeners = ['refreshComponent' => '$refresh'];
    public function render()
    {
        return view('livewire.admin.railway.ligne.ligne-show-station');
    }

    public function adding()
    {
        $latestStation = $this->ligne->stations()->latest('id')->first();
        $gare = Gare::find($this->gare_id);
        $station = LigneStation::create([
            "time" => 0,
            "distance" => 0,
            "gare_id" => $this->gare_id,
            "ligne_id" => $this->ligne->id
        ]);

        // Calcule de la distance entre station -1 et station

        if($latestStation) {
            $distance = $latestStation->calculDistance(
                $latestStation->gare->latitude,
                $latestStation->gare->longitude,
                $gare->latitude,
                $gare->longitude
            );

            if($this->ligne->type_ligne == 'ter' || $this->ligne->type_ligne == 'intercite') {
                $vitesse = $this->convertVitesse(160);
            } elseif ($this->ligne->type_ligne == 'tgv') {
                $vitesse = $this->convertVitesse(320);
            } elseif ($this->ligne->type_ligne == 'transilien') {
                $vitesse = $this->convertVitesse(120);
            } elseif ($this->ligne->type_ligne == "tram" || $this->ligne->type_ligne == 'metro') {
                $vitesse = $this->convertVitesse(90);
            } else {
                $vitesse = $this->convertVitesse(50);
            }

            $station->update([
                "distance" => $distance,
                "time" => $latestStation->time + $latestStation->calculTemps($distance, $vitesse)
            ]);
        } else {
            $station->update([
                "distance" => 0,
                "time" => 0
            ]);
        }

        $this->ligne->time_min = $station->time;
        $this->ligne->save();


        session()->flash('success', "Gare ajouter avec succès");
    }

    public function delete($id)
    {
        $station = LigneStation::find($id);

        $this->ligne->update([
            "time_min" => $this->ligne->time_min - $station->time
        ]);

        $station->delete();

        session()->flash("success", "La station à été supprimer");

    }

    private function convertVitesse($vitesse)
    {
        return $vitesse / 3.6;
    }
}
