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
        if (\Storage::disk('sftp')->exists('/logos/rentals/'.Str::slug($this->name).'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/logos/rentals/'.Str::slug($this->name).'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/logos/rentals/default.png'));
        }
    }
}
