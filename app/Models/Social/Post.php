<?php

namespace App\Models\Social;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use SoftDeletes, Searchable, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'deleted_at' => 'datetime',
        'is_reject_at' => 'datetime',
    ];

    public function searchableAs()
    {
        return match(config('app.env')) {
            "local" => "dev_post",
            "staging" => "test_post",
            "production" => "prod_post",
        };
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['cercles'] = $this->cercles->pluck('name')->toArray();

        return $array;
    }

    protected function views(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => number_format($value, 0, ',', ' '),
        );
    }


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

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByLoggedInUser(int $user_id): bool
    {
        return !$this->likes->where('user_id', $user_id)->isEmpty();
    }
}
