<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class RailwayBanqueFlux extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function banque()
    {
        return $this->belongsTo(RailwayBanque::class, 'railway_banque_id');
    }
}
