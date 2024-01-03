<?php

namespace App\Models\Railway;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RailwayBonus extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = [
        "icon",
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "user_bonus", "railway_bonus_id", "user_id")
            ->withPivot('claimed_at')
            ->withTimestamps();
    }

    public function getIconAttribute()
    {
        return asset('/storage/icons/bonus/'.$this->type.'.png');
    }

    public static function generateDesignationFromType(string $type, int $value): string
    {
        return match($type) {
            "argent" => "+ $value €",
            "tpoint" => "+ $value",
            "simulation" => "+ $value ".\Str::plural("simulation", $value),
            "audit_int" => "+ $value ".\Str::plural("audit", $value)." ".\Str::plural("interne", $value),
            "audit_ext" => "+ $value ".\Str::plural("audit", $value)." ".\Str::plural("externe", $value),
        };
    }

    public static function generateValueFromType(string $type)
    {
        return match ($type) {
            "argent" => round(generateRandomFloat(10000, 900000), -3, PHP_ROUND_HALF_UP),
            default => mt_rand(1,50)
        };
    }

    public static function generateType()
    {
        $array = collect([
            "argent",
            "tpoint",
            "simulation",
            "audit_int",
            "audit_ext"
        ]);

        return $array->random();
    }
}
