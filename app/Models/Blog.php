<?php

namespace App\Models;

use App\Enum\BlogAuthorEnum;
use App\Enum\BlogCategoryEnum;
use App\Enum\BlogSubcategoryEnum;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];
    protected $casts = [
        'published_at' => 'datetime',
        'publish_social_at' => 'datetime',
        'category' => BlogCategoryEnum::class,
        "subcategory" => BlogSubcategoryEnum::class,
        'author' => BlogAuthorEnum::class,
    ];
    protected $appends = [
        'slug'
    ];

    public function getSlugAttribute()
    {
        return \Str::slug($this->title);
    }
}
