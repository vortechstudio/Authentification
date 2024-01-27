<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayBadge extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $appends = ['icon'];

    public function rewards()
    {
        return $this->hasMany(RailwayBadgeReward::class);
    }

    public function getIconAttribute()
    {
        if (\Storage::disk('sftp')->exists('/badges/'.$this->action.'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/badges/'.$this->action.'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/badges/default.png'));
        }
    }
}
