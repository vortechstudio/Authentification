<?php

namespace App\Models\Railway;

use App\Trait\Railway\GareTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gare extends Model
{
    use GareTrait, HasFactory;

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
    ];

    protected $guarded = [];

    protected $appends = [
        'type_gare_string',
        'is_hub',
        'is_hub_label',
    ];

    public function weather()
    {
        return $this->hasOne(GareWeather::class);
    }

    public function hub()
    {
        return $this->hasOne(Hub::class);
    }

    public function stations()
    {
        return $this->hasMany(LigneStation::class);
    }

    public function getTypeGareStringAttribute()
    {
        return match ($this->type_gare) {
            'halte' => 'Halte',
            'small' => 'Petite Gare',
            'medium' => 'Moyenne Gare',
            'large' => 'Grande Gare',
            'terminus' => 'Terminus'
        };
    }

    public function getTypeEquipementIconAttribute($equipement)
    {
        return match ($equipement) {
            'toilette' => 'fa-restroom',
            'info_sonore' => 'fa-volume-up',
            'info_visuel' => 'fa-eye',
            'ascenceurs' => 'fa-elevator',
            'escalator' => 'fa-stairs',
            'guichets' => 'fa-ticket',
            'boutique' => 'fa-shop',
            'restaurant' => 'fa-utensils',
        };
    }

    public function getTypeEquipementStringAttribute($equipement)
    {
        return match ($equipement) {
            'toilette' => 'Toilette',
            'info_sonore' => 'Information Sonore',
            'info_visuel' => 'Information visuelle',
            'ascenceurs' => 'Ascenceurs',
            'escalator' => 'Escalateurs',
            'guichets' => 'Guichets',
            'boutique' => 'Boutique',
            'restaurant' => 'Restaurant',
        };
    }

    public function getIsHubAttribute()
    {
        return $this->hub()->count() != 0;
    }

    public function getIsHubLabelAttribute()
    {
        if ($this->getIsHubAttribute()) {
            return "<i class='fa-solid fa-check-circle fs-1 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-1 text-danger'></i>";
        }
    }

    public static function selector()
    {
        $argc = collect();

        foreach (self::all() as $gare) {
            $argc->push([
                'id' => $gare->id,
                'value' => $gare->name,
            ]);
        }

        return $argc;
    }
}
