<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class Gare extends Model
{
    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
    ];
    protected $guarded = [];

    public function weather()
    {
        return $this->hasOne(GareWeather::class);
    }

    public function hub()
    {
        return $this->hasOne(Hub::class);
    }

    public function stations()
    {
        return $this->hasMany(LigneStation::class);
    }
}
