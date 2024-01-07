<?php

namespace App\Livewire\Admin\Support\Ticket;

use App\Models\Support\Ticket\Ticket;
use Livewire\Component;

class TicketChat extends Component
{
    public Ticket $ticket;
    public function render()
    {
        return view('livewire.admin.support.ticket.ticket-chat', [
            "ticket" => $this->ticket,
            "responses" => $this->ticket->responses()->orderBy('created_at', 'desc')->get()
        ]);
    }
}
