<?php

namespace App\Enum;

enum ServiceStatusEnum :string
{
    case IDEA = "Idée";
    case DEVELOP = "En développement";
    case PRODUCTION = "En production";

    public static function all()
    {
        return collect([
            "idea" => "Idée",
            "develop" => "En développement",
            "production" => "En production"
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
