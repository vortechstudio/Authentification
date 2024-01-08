<?php

namespace App\Models\Support\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
