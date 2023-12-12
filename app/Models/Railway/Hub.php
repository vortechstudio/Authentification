<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function gare()
    {
        return $this->belongsTo(Gare::class);
    }

    public function lignes()
    {
        return $this->hasMany(Ligne::class);
    }
}
