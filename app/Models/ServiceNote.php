<?php

namespace App\Models;

use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ServiceNote extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
