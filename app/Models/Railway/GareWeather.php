<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class GareWeather extends Model
{
    public $timestamps = false;

    protected $casts = [
        'latest_update' => 'datetime',
    ];
    protected $guarded = [];

    public function gare()
    {
        return $this->belongsTo(Gare::class);
    }
}
