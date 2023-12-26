<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = [
        'is_active_label'
    ];

    public function gare()
    {
        return $this->belongsTo(Gare::class);
    }

    public function lignes()
    {
        return $this->hasMany(Ligne::class);
    }

    public function getIsActiveLabelAttribute()
    {
        if($this->active) {
            return "<span class='badge badge-sm badge-success'><i class='fa-solid fa-check-circle text-white me-2'></i> Hub Actif</span>";
        } else {
            return "<span class='badge badge-sm badge-danger'><i class='fa-solid fa-xmark-circle text-white me-2'></i> Hub Inactif</span>";
        }
    }
}
