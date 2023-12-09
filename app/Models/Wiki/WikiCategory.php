<?php

namespace App\Models\Wiki;

use App\Models\Social\Cercle;
use Illuminate\Database\Eloquent\Model;

class WikiCategory extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function cercle()
    {
        return $this->belongsTo(Cercle::class);
    }

    public function subcategories()
    {
        return $this->hasMany(WikiSubcategory::class);
    }
}
