<?php

namespace App\Observers;

use App\Models\Support\Ticket\Ticket;

class TicketObserver
{
    public function created(Ticket $ticket): void
    {
        if(auth()->user()->admin) {
            $ticket->logs()->create(["action" => "Création du ticket par un administrateur"]);
        } else {
            $ticket->logs()->create(["action" => "Création du ticket"]);
        }
    }

    public function updated(Ticket $ticket): void
    {
        match ($ticket->status) {
            "open" => $ticket->logs()->create(["action" => "Le ticket a été ouvert"]),
            "closed" => $ticket->logs()->create(["action" => "Le ticket a été fermé"]),
            "waiting" => $ticket->logs()->create(["action" => "Le ticket est en attente"]),
        };

        match ($ticket->priority) {
            "low" => $ticket->logs()->create(["action" => "La priorité du ticket a été mise à faible"]),
            "medium" => $ticket->logs()->create(["action" => "La priorité du ticket a été mise à moyenne"]),
            "high" => $ticket->logs()->create(["action" => "La priorité du ticket a été mise à haute"]),
        };
    }

    public function deleted(Ticket $ticket): void
    {
        $ticket->logs()->create(["action" => "Le ticket a été supprimé"]);
    }

    public function restored(Ticket $ticket): void
    {
        $ticket->logs()->create(["action" => "Le ticket a été restauré"]);
    }
}
