<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineTarif extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
}
