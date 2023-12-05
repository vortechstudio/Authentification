<?php

namespace App\Models;

use App\Enum\ServiceStatusEnum;
use App\Enum\ServiceTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    protected $casts = [
        "type" => ServiceTypeEnum::class,
        "status" => ServiceStatusEnum::class
    ];

    public function user_service()
    {
        return $this->hasMany(UserService::class);
    }

    public function notes()
    {
        return $this->hasMany(ServiceNote::class);
    }
}
