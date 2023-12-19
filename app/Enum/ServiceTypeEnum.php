<?php

namespace App\Enum;

enum ServiceTypeEnum :string
{
    case GAME = "Jeux";
    case PLATFORM = "Plateforme";

    public static function all()
    {
        return collect([
            "jeux" => "Jeux",
            "plateforme" => "Plateforme"
        ]);
    }

    public static function selector()
    {
        $arr = collect();
        foreach (self::all() as $k => $service) {
            $arr->push([
                "id" => $k,
                "value" => $service
            ]);
        }

        return $arr;
    }
}
