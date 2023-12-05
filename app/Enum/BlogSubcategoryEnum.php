<?php

namespace App\Enum;

enum BlogSubcategoryEnum :string
{
    case Notice = "Annonce";
    case EVENT = "Evénement";
    case NEWS = "A la Une";
    case AUTH = "Authentification & Espace Membre";
}
