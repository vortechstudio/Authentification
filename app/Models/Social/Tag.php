<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $fillable = ['tag'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
