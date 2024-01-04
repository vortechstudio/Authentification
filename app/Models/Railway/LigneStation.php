<?php

namespace App\Models\Railway;

use AnthonyMartin\GeoLocation\GeoPoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneStation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function gare()
    {
        return $this->belongsTo(Gare::class, 'gare_id');
    }

    public function ligne()
    {
        return $this->belongsTo(Ligne::class);
    }

    public function calculTemps($distance, $vitesse)
    {
        $timeInSecond = $distance/$vitesse;
        return intval(($timeInSecond * 60) / 1.8); // Convertir en minutes si nécessaire
    }

    public function calculDistance($lat1, $lon1, $lat2, $lon2)
    {
        $geoA = new GeoPoint($lat1, $lon1);
        $geoB = new GeoPoint($lat2, $lon2);

        return $geoA->distanceTo($geoB, 'km');
    }
}
