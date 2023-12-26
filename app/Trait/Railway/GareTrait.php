<?php

namespace App\Trait\Railway;

trait GareTrait
{
    public static function getHabitant($type_gare, $frequentation)
    {
        return match ($type_gare) {
            "halte" => intval($frequentation * 1.2),
            "small" => intval($frequentation * 1.8),
            "medium" => intval($frequentation * 2.6),
            "large" => intval($frequentation * 4.5),
            "terminus" => intval($frequentation * 5.6),
        };
    }

    public static function defineEquipements($type_gare)
    {
        return match ($type_gare) {
            "halte" => ["info_visuel"],
            "small" => ["toilette", "info_visuel", "info_sonore"],
            "medium" => ["toilette", "info_visuel", "info_sonore", "guichets"],
            "large", "terminus" => ["toilette", "info_visuel", "info_sonore", "guichets", "ascenceurs", "escalator", "boutique", "restaurant"],
        };
    }

    public static function definePrice($type_gare, $nb_quai)
    {
        $coef = match ($type_gare) {
            "halte" => 1.05,
            "small" => 1.20,
            "medium" => 1.80,
            "large" => 2.30,
            "terminus" => 3,
        };

        $price_base = match ($type_gare) {
            "halte" => 25000,
            "small" => 47000,
            "medium" => 78000,
            "large" => 195000,
            "terminus" => 270000,
        };

        $calc = ($price_base * $coef) * $nb_quai;

        return round($calc, 2);
    }

    public static function defineTaxeHub($price, $nb_quai)
    {
        $calc = $price / $nb_quai / 20 / 10;

        return round($calc, 2);
    }
}
