<?php

namespace App\Livewire\Forms\Admin\Support\Ticket;

use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TicketForm extends Form
{
    public ?Ticket $ticket;

    public $title = '';
    public $priority = '';
    public $status = '';
    public $user_id = 0;
    public $service_id = 0;
    public $ticket_category_id = 0;
    public $message = '';
    public $selectedService = null;
    public $ticketCategories  = [];
    public $pushToJira = false;

    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->title = $ticket->title;
        $this->priority = $ticket->priority;
        $this->status = $ticket->status;
        $this->user_id = $ticket->user_id;
        $this->service_id = $ticket->service_id;
        $this->ticket_category_id = $ticket->ticket_category_id;
        $this->message = $ticket->responses()->first()->message;
    }

    public function save()
    {
        $this->validate([
            "title" => "required",
            "priority" => "required",
            "user_id" => "required",
            "selectedService" => "required",
            "ticket_category_id" => "required",
            "message" => "required",
        ]);

        $ticket = Ticket::create([
            "title" => $this->title,
            "priority" => $this->priority,
            "status" => "open",
            "user_id" => $this->user_id,
            "service_id" => $this->selectedService,
            "ticket_category_id" => $this->ticket_category_id,
        ]);
        $ticket->responses()->create([
            "message" => $this->message,
            "user_id" => auth()->id(),
        ]);
    }
}
