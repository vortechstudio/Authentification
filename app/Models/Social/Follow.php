<?php

namespace App\Models\Social;

use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Follow extends Model
{
    use Notifiable;

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
    ];
}
