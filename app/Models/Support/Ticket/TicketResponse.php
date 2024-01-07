<?php

namespace App\Models\Support\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
