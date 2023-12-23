<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfil extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [
        'banned_at' => "datetime",
        "banned_for" => "datetime"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
