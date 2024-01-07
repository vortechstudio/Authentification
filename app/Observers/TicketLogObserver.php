<?php

namespace App\Observers;

use App\Models\Support\Ticket\TicketLog;
use App\Notifications\System\SendMessageNotification;

class TicketLogObserver
{
    public function created(TicketLog $ticketLog): void
    {
        $ticketLog->ticket->user->notify(new SendMessageNotification(
            "Nouvelle information sur votre ticket",
            "Une nouvelle information a été ajoutée à votre ticket. Vous pouvez la consulter en cliquant sur le bouton ci-dessous.",
            "info",
            "fa-info-circle",
            "https://support.".config("app.domain")."/tickets/".$ticketLog->ticket->id
        ));
    }
}
