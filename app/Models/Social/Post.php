<?php

namespace App\Models\Social;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'deleted_at' => 'datetime',
        'is_reject_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class, 'post_cercle', 'post_id', 'cercle_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
