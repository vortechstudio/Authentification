<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class ResearchCategory extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = ['icon'];

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ResearchProject::class, 'research_category_id');
    }

    public static function selector()
    {
        $argc = collect();
        foreach (self::all() as $category) {
            $argc->push([
                "id" => $category->id,
                "value" => $category->name
            ]);
        }

        return $argc;
    }

    public function getIconAttribute()
    {
        return match ($this->name) {
            'Hubs' => 'fas fa-warehouse',
            'Matériels Roulants' => 'fas fa-train',
            'Lignes' => 'fas fa-route',
            'Service de location' => 'fas fa-hand-holding-usd',
            'Service bancaire' => 'fas fa-university',
            default => 'fas fa-question-circle'
        };
    }
}
