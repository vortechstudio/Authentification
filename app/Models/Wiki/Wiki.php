<?php

namespace App\Models\Wiki;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wiki extends Model
{
    use SoftDeletes;
    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(WikiCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(WikiSubcategory::class);
    }

    public function contributors()
    {
        return $this->belongsToMany(User::class, 'wiki_user', 'wiki_id', 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(WikiLog::class);
    }
}
