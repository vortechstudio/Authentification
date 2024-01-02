<?php

namespace App\Enum;
/**
* @codeCoverageIgnore
*/
enum ServiceStatusEnum :string
{
    case IDEA = "Idée";
    case DEVELOP = "En développement";
    case PRODUCTION = "En production";

    /**
     * @codeCoverageIgnore
     */
    public static function all()
    {
        return collect([
            "idea" => "Idée",
            "develop" => "En développement",
            "production" => "En production"
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
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
