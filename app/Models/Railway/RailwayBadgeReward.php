<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayBadgeReward extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = ["type_string"];

    public function badge()
    {
        return $this->belongsTo(RailwayBadge::class);
    }

    public function getTypeStringAttribute()
    {
        return match ($this->type) {
            "argent" => "Argent",
            "tpoint" => "T Point",
            "engine" => "Matériel Roulant",
            "hubs" => "Hubs & connexes",
            "boost" => "Boost de recherche",
        };
    }
    public static function selectorType()
    {
        $argc = collect();

        $argc->push([
            "id" => "argent",
            "value" => "Argent"
        ]);
        $argc->push([
            "id" => "tpoint",
            "value" => "T Point"
        ]);
        $argc->push([
            "id" => "engine",
            "value" => "Matériel Roulant"
        ]);
        $argc->push([
            "id" => "hubs",
            "value" => "Hubs & connexes"
        ]);
        $argc->push([
            "id" => "boost",
            "value" => "Boost de recherche"
        ]);

        return $argc;
    }
}
