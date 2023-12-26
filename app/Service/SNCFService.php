<?php

namespace App\Service;

use Illuminate\Support\Collection;

class SNCFService
{
    public Collection $gare;
    public Collection $frequentation;

    public function __construct()
    {
        $this->gare = collect();

        foreach ($this->extractJsonFileGare() as $gare) {
            $this->gare->push([
                "name" => $gare['alias_libelle_noncontraint'],
                "latitude" => $gare['latitude_entreeprincipale_wgs84'],
                "longitude" => $gare['longitude_entreeprincipale_wgs84'],
                "city" => $gare['commune_libellemin'],
                'pays' => "France",
            ]);
        }

        $this->frequentation = collect();

        foreach ($this->extractJsonFileFreq() as $freq) {
            $this->frequentation->push([
                "name" => $freq['nom_gare'],
                "freq" => $freq['total_voyageurs_2022']
            ]);
        }
    }

    public function searchGare($search)
    {
        return $this->gare->where('name', $search)->first();
    }

    public function searchFreq($search)
    {
        return $this->frequentation->where('name', $search)->first();
    }

    private function extractJsonFileGare()
    {
        $file = fopen(public_path('/storage/referentiel-gares-voyageurs.json'), 'r');
        $gares = json_decode(fread($file, filesize(public_path('/storage/referentiel-gares-voyageurs.json'))), true);
        fclose($file);

        return $gares;
    }

    private function extractJsonFileFreq()
    {
        $file = fopen(public_path('/storage/frequentation-gares.json'), 'r');
        $gares = json_decode(fread($file, filesize(public_path('/storage/frequentation-gares.json'))), true);
        fclose($file);

        return $gares;
    }
}
