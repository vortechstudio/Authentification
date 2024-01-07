<?php

namespace App\Livewire\Admin\Support\Ticket;

use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketResponse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Jira\Laravel\Facades\Jira;
use Livewire\Attributes\Title;
use Livewire\Component;

class TicketShow extends Component
{
    use LivewireAlert;
    public $ticketId;
    public $ticket;
    public $ticketLogs;
    public $ticketResponses;
    public $message = '';

    public function mount(int $id)
    {
        $this->ticketId = $id;
        $this->ticket = Ticket::find($id);
        $this->ticketLogs = $this->ticket->logs()->orderBy('created_at', 'desc')->get();
        $this->ticketResponses = $this->ticket->responses()->orderBy('created_at', 'desc')->get();
        $this->markResponsesAsRead();
    }
    #[Title("")]
    public function render()
    {

        return view('livewire.admin.support.ticket.ticket-show')
            ->layout('components.layouts.admin');
    }

    public function send()
    {
        $this->validate([
            "message" => "required"
        ]);

        $this->ticket->update([
            "updated_at" => now()
        ]);

        $this->ticket->responses()->create([
            "message" => $this->message,
            "user_id" => auth()->id()
        ]);
        $this->message = '';
    }

    public function closeTicket()
    {
        $this->ticket->update([
            "status" => "closed"
        ]);
    }

    public function openTicket()
    {
        $this->ticket->update([
            "status" => "open"
        ]);
    }

    public function transfertToJira()
    {
        $ticket = Jira::issues()->create([
            "fields" => [
                "project" => [
                    "key" => "VSH"
                ],
                "summary" => $this->ticket->title,
                "description" => $this->ticket->responses()->first()->message,
                "issuetype" => [
                    "name" => "Bug"
                ],
                "priority" => [
                    "name" => \Str::ucfirst($this->ticket->priority)
                ]
            ],
        ]);

        $this->ticket->update([
            "jira_ticket_id" => $ticket["key"]
        ]);
        $this->ticket->responses()->create([
            "message" => "Le ticket a été transféré sur Jira",
            "user_id" => auth()->id()
        ]);

        $this->alert("success", "Le ticket a été transféré sur Jira");
    }

    public function markResponsesAsRead()
    {
        TicketResponse::where('ticket_id', $this->ticketId)
            ->where('user_id',  auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
