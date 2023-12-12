<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class RailwayBadgeReward extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function badge()
    {
        return $this->belongsTo(RailwayBadge::class);
    }
}
