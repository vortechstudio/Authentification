<?php

namespace App\Models\Wiki;

use App\Models\Social\Cercle;
use Illuminate\Database\Eloquent\Model;

class WikiCategory extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'icon_path',
    ];

    public function cercle()
    {
        return $this->belongsTo(Cercle::class);
    }

    public function subcategories()
    {
        return $this->hasMany(WikiSubcategory::class);
    }

    public static function selector()
    {
        $arr = collect();
        foreach (self::all() as $cat) {
            $arr->push([
                'id' => $cat->id,
                'value' => $cat->name,
            ]);
        }

        return $arr;
    }

    public function getIconPathAttribute()
    {
        if (\Storage::disk('sftp')->exists("/icons/wiki/category/{$this->id}.png")) {
            return storageToUrl(\Storage::disk('sftp')->url("/icons/wiki/category/{$this->id}.png"));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url("/icons/wiki/category/default.png"));
        }
    }
}
