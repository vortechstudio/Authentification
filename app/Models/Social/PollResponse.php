<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Model;

class PollResponse extends Model
{
    public $timestamps = false;

    protected $casts = [
        'users' => 'array',
    ];

    protected $guarded = [];
    protected $append = [
        "percent_with_count"
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function getPercentWithCountAttribute()
    {
        $moy_count = Poll::where('id', $this->poll_id)->first()->responses()->sum('count');
        
        return $this->count * 100 / $moy_count;

    }
}
