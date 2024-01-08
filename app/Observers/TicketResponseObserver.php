<?php

namespace App\Observers;

use App\Models\Support\Ticket\TicketResponse;
use App\Notifications\System\SendMessageNotification;

class TicketResponseObserver
{
    public function created(TicketResponse $ticketResponse): void
    {
        $ticketResponse->user->notify(new SendMessageNotification(
            "Nouvelle réponse sur votre ticket",
            "Une nouvelle réponse a été ajoutée à votre ticket. Vous pouvez la consulter en cliquant sur le bouton ci-dessous.",
            "info",
            "fa-info-circle",
            "https://support.".config("app.domain")."/tickets/".$ticketResponse->ticket->id
        ));
    }
}
