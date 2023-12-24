<?php

namespace App\Models\Wiki;

use Illuminate\Database\Eloquent\Model;

class WikiSubcategory extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public static function selector()
    {
        $arr = collect();
        foreach (self::all() as $cat) {
            $arr->push([
                "id" => $cat->id,
                "value" => $cat->name
            ]);
        }

        return $arr;
    }

    public function category()
    {
        return $this->belongsTo(WikiCategory::class);
    }

    public function articles()
    {
        return $this->hasMany(Wiki::class);
    }
}
