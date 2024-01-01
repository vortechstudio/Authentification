<?php

namespace App\Models\Railway;

use App\Trait\Railway\EngineCalcTrait;
use App\Trait\Railway\EngineTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    use EngineTrait, EngineCalcTrait, HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = [
        'image_src',
        'type_transport_string',
        'type_train_string',
        "type_energy_string",
        "active_label",
        "in_shop_label",
        "in_game_label",
        "visual_label",
    ];
    protected $casts = [
        "duration_maintenance" => "datetime"
    ];

    public function technical()
    {
        return $this->hasOne(EngineTechnical::class);
    }

    public function tarif()
    {
        return $this->hasOne(EngineTarif::class);
    }

    public function getTypeTransportStringAttribute()
    {
        return match ($this->type_transport) {
            "ter" => "TER",
            "tgv" => "TGV",
            "intercity" => "Intercité/Interloire",
            "tram" => "Tram / Tram-Train",
            "metro" => "Metro",
            "bus" => "Bus",
            "other" => "Autre"
        };
    }

    public function getTypeTrainStringAttribute()
    {
        return \Str::ucfirst($this->type_train);
    }

    public function getTypeEnergyStringAttribute()
    {
        return \Str::ucfirst($this->type_energy);
    }

    public function getImageSrcAttribute()
    {
        if ($this->type_train == 'automotrice') {
            if(\Storage::disk('public')->exists('/engines/automotrice/'.\Str::slug($this->name).'-0.gif')) {
                return asset('/storage/engines/automotrice/'.\Str::slug($this->name).'-0.gif');
            } else {
                return asset('/storage/engines/default.png');
            }
        } else {
            if(\Storage::disk('public')->exists('/engines/automotrice/'.$this->type_train.'/'.\Str::slug($this->name).'.gif')) {
                return asset('/storage/engines/automotrice/'.$this->type_train.'/'.\Str::slug($this->name).'.gif');
            } else {
                return asset('/storage/engines/default.png');
            }
        }
    }

    public function getActiveLabelAttribute()
    {
        if($this->active) {
            return "<span class='badge badge-success'><i class='fa-solid fa-check-circle text-white me-1'></i> Actif</span>";
        } else {
            return "<span class='badge badge-danger'><i class='fa-solid fa-xmark-circle text-white me-1'></i> Inactif</span>";
        }
    }

    public function getInShopLabelAttribute()
    {
        if($this->in_shop) {
            return "<i class='fa-solid fa-check-circle fs-3 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-3 text-danger'></i>";
        }
    }

    public function getInGameLabelAttribute()
    {
        if($this->in_game) {
            return "<i class='fa-solid fa-check-circle fs-3 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-3 text-danger'></i>";
        }
    }

    public function getVisualLabelAttribute()
    {
        return match ($this->visual) {
            "beta" => "<span class='badge badge-warning'><i class='fa-solid fa-flask text-white me-1'></i> Béta</span>",
            "prod" => "<span class='badge badge-success'><i class='fa-solid fa-check text-white me-1'></i> Production</span>",
        };
    }

    public static function selector(): \Illuminate\Support\Collection
    {
        $arr = collect();

        foreach (self::where('in_game', true)->get() as $engine) {
            $arr->push([
                "id" => $engine->id,
                "value" => $engine->name,
            ]);
        }

        return $arr;
    }

}
