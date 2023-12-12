<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cms extends Model
{
    use SoftDeletes;

    protected $casts = [
        'published_at' => 'datetime',
    ];
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Cms::class, 'parent_id');
    }
}
