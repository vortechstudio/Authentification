<?php

namespace App\Enum;

enum BlogSubcategoryEnum :string
{
    case Notice = "Annonce";
    case EVENT = "Evénement";
    case NEWS = "A la Une";
    case AUTH = "Authentification & Espace Membre";

    public static function all()
    {
        return collect([
            "notice" => "Annonce",
            "event" => "Evènement",
            "news" => "A la une",
            "auth" => "Authentification & Espace Membre",
        ]);
    }

    public static function get($search)
    {
        return collect([
            "notice" => "Annonce",
            "event" => "Evènement",
            "news" => "A la une",
            "auth" => "Authentification & Espace Membre",
        ])->get($search);
    }
}
