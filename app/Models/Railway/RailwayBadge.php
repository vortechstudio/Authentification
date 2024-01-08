<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayBadge extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $appends = ['icon'];

    public function rewards()
    {
        return $this->hasMany(RailwayBadgeReward::class);
    }

    public function getIconAttribute()
    {
        if (\Storage::disk('public')->exists('/badges/'.$this->action.'.png')) {
            return asset('/storage/badges/'.$this->action.'.png');
        } else {
            return asset('/storage/badges/default.png');
        }
    }
}
