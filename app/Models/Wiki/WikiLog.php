<?php

namespace App\Models\Wiki;

use Illuminate\Database\Eloquent\Model;

class WikiLog extends Model
{
    protected $guarded = [];

    public function wiki()
    {
        return $this->belongsTo(Wiki::class);
    }
}
