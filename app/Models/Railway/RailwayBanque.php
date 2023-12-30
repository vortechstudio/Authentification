<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class RailwayBanque extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function flux()
    {
        return $this->hasMany(RailwayBanqueFlux::class);
    }
}
