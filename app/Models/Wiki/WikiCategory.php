<?php

namespace App\Models\Wiki;

use App\Models\Social\Cercle;
use Illuminate\Database\Eloquent\Model;

class WikiCategory extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = [
        "icon_path"
    ];

    public function cercle()
    {
        return $this->belongsTo(Cercle::class);
    }

    public function subcategories()
    {
        return $this->hasMany(WikiSubcategory::class);
    }

    public function getIconPathAttribute()
    {
        if(\Storage::disk("public")->exists("/icons/wiki/category/{$this->id}.png")) {
            return asset("/storage/icons/wiki/category/{$this->id}.png");
        } else {
            return asset("/storage/icons/wiki/category/default.png");
        }
    }
}
