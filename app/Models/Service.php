<?php

namespace App\Models;

use App\Enum\ServiceStatusEnum;
use App\Enum\ServiceTypeEnum;
use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Service extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected $casts = [
    ];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class
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
