<?php

namespace App\Enum;

enum BlogAuthorEnum :string
{
    case VortechStudio = 'VortechStudio';
    case RailwayManager = "Railway Manager";

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
