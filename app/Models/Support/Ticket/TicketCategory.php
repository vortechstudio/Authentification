<?php

namespace App\Models\Support\Ticket;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
