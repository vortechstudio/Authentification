<?php

namespace App\Models\Railway;

use App\Trait\Railway\LigneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    use LigneTrait, HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = ["name", "status_label"];

    public function start()
    {
        return $this->belongsTo(Gare::class, "start_gare_id");
    }

    public function end()
    {
        return $this->belongsTo(Gare::class, "end_gare_id");
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function stations()
    {
        return $this->hasMany(LigneStation::class);
    }

    public function getNameAttribute()
    {
        return $this->start->name. " - ".$this->end->name;
    }

    public function getStatusLabelAttribute()
    {
        if($this->active) {
            return "<i class='fa-solid fa-check-circle fs-2 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-2 text-danger'></i>";
        }
    }
}
