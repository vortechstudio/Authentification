<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RailwayBanque extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'image',
    ];

    public function flux()
    {
        return $this->hasMany(RailwayBanqueFlux::class);
    }

    public function getImageAttribute()
    {
        if (\Storage::disk('sftp')->exists('/logos/banks/'.Str::slug($this->name).'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/logos/banks/'.Str::slug($this->name).'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/logos/banks/default.png'));
        }
    }
}
