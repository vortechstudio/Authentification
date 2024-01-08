<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class EngineTechnical extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
}
