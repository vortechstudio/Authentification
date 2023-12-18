<?php

namespace App\Models\Social;

use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    use Notifiable;
    public $timestamps = false;
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}
