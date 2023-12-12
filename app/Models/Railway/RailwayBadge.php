<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class RailwayBadge extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function rewards()
    {
        return $this->hasMany(RailwayBadgeReward::class);
    }
}
