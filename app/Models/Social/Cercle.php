<?php

namespace App\Models\Social;

use App\Models\Blog;
use App\Models\Wiki\WikiCategory;
use Illuminate\Database\Eloquent\Model;

class Cercle extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = ['image', 'slug'];


    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_cercle', 'cercle_id', 'post_id');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_cercle', 'cercle_id', 'blog_id');
    }

    public function wiki_category()
    {
        return $this->belongsTo(WikiCategory::class);
    }
    public function getImageAttribute(): string
    {
        return asset('/storage/icons/cercles/'.$this->getSlugAttribute().'.webp');
    }

    public function getSlugAttribute(): string
    {
        return \Str::slug($this->name);
    }
}
