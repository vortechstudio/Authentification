<?php

namespace App\Enum;

enum ServiceStatusEnum :string
{
    case IDEA = "Idée";
    case DEVELOP = "En développement";
    case PRODUCTION = "En production";
}
