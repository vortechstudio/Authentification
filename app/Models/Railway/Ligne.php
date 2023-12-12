<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function start()
    {
        return $this->belongsTo(Gare::class, "start_gare_id");
    }

    public function end()
    {
        return $this->belongsTo(Gare::class, "end_gare_id");
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function stations()
    {
        return $this->hasMany(LigneStation::class);
    }
}
