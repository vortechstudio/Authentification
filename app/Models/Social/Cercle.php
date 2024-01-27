<?php

namespace App\Models\Social;

use App\Models\Blog;
use App\Models\Wiki\WikiCategory;
use Illuminate\Database\Eloquent\Model;

class Cercle extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'image',
        'slug',
        'image_icon',
        'image_header',
        'image_full',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_cercle', 'cercle_id', 'post_id');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_cercle', 'cercle_id', 'blog_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_cercle', 'cercle_id', 'event_id');
    }

    public function wiki_category()
    {
        return $this->belongsTo(WikiCategory::class);
    }

    public function getImageAttribute(): string
    {
        return storageToUrl(\Storage::disk('sftp')->url('icons/cercles/'.$this->getSlugAttribute().'.webp'));
    }

    public function getImageIconAttribute()
    {
        if(\Storage::disk('sftp')->exists('/cercles/'.$this->getSlugAttribute().'/icon_'.$this->getSlugAttribute().'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/cercles/'.$this->getSlugAttribute().'/icon_'.$this->getSlugAttribute().'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/cercles/icon_default.png'));
        }
    }

    public function getImageHeaderAttribute()
    {
        if(\Storage::disk('sftp')->exists('/cercles/'.$this->getSlugAttribute().'/header_'.$this->getSlugAttribute().'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/cercles/'.$this->getSlugAttribute().'/header_'.$this->getSlugAttribute().'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/cercles/header_default.png'));
        }
    }

    public function getImageFullAttribute()
    {
        if(\Storage::disk('sftp')->exists('/cercles/'.$this->getSlugAttribute().'/'.$this->getSlugAttribute().'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/cercles/'.$this->getSlugAttribute().'/'.$this->getSlugAttribute().'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/cercles/full_default.png'));
        }
    }

    public function getSlugAttribute(): string
    {
        return \Str::slug($this->name);
    }

    public static function selector()
    {
        $arr = collect();
        foreach (self::all() as $cercle) {
            $arr->push([
                'id' => $cercle->id,
                'value' => $cercle->name,
            ]);
        }

        return $arr;
    }
}
