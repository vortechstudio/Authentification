<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class LigneStation extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function gare()
    {
        return $this->belongsTo(Gare::class);
    }

    public function ligne()
    {
        return $this->belongsTo(Ligne::class);
    }
}
