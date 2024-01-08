<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    protected $guarded = [];

    protected $appends = [
        'premium_icon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function userRewards()
    {
        return $this->hasMany(UserRewards::class);
    }

    public function getPremiumIconAttribute()
    {
        return "<i class='fa-solid ".self::getPremiumStyle($this->premium, 'icon').' '.self::getPremiumStyle($this->premium, 'text')." fs-2x'></i>";
    }

    public static function getPremiumStyle($premium, $style)
    {
        if ($premium) {
            return match ($style) {
                'text' => 'text-green-500',
                'icon' => 'fa-check text-green-500',
                'bg' => 'bg-green-300',
            };
        } else {
            return match ($style) {
                'text' => 'text-red-500',
                'icon' => 'fa-times text-red-500',
                'bg' => 'bg-red-300',
            };
        }
    }
}
