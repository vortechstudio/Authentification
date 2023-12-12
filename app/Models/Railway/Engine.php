<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function technical()
    {
        return $this->hasOne(EngineTechnical::class);
    }
}
