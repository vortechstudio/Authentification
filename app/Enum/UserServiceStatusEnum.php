<?php

namespace App\Enum;

enum UserServiceStatusEnum :string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
