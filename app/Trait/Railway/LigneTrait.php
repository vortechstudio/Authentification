<?php

namespace App\Trait\Railway;

use App\Models\Railway\Ligne;

trait LigneTrait
{
    public static function calcPrice(Ligne $ligne)
    {
        return ($ligne->distance * $ligne->time_min) * $ligne->nb_station;
    }
}
