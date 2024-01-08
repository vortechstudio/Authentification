<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RailwayRental extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'image',
    ];

    public function getImageAttribute()
    {
        if (\Storage::disk('public')->exists('/logos/rentals/'.Str::slug($this->name).'.png')) {
            return asset('/storage/logos/rentals/'.Str::slug($this->name).'.png');
        } else {
            return asset('/storage/logos/rentals/default.png');
        }
    }
}
