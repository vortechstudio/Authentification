<?php

namespace App\Enum;

enum BlogCategoryEnum : string
{
    case RAILWAY = "Railway Manager";
    case VORTECH = "Entreprise";

    public static function all()
    {
        return collect([
            "railway" => "Railway Manager",
            "vortech" => "Vortech Studio"
        ]);
    }

    public static function get($search)
    {
        return collect([
            "railway" => "Railway Manager",
            "vortech" => "Vortech Studio"
        ])->get($search);
    }
}
