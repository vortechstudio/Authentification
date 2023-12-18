<?php

namespace App\Models;

use App\Enum\UserServiceStatusEnum;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    protected $guarded = [];
    protected $casts = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
