<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeleteNotification extends Notification
{
    public function __construct(public User $user)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'VORTECH STUDIO')
            ->error()
            ->subject('Suppression de votre compte')
            ->greeting('Cher '.$this->user->name)
            ->line('Nous vous informons que votre compte à été supprimé de notre base de donnée.')
            ->line("Si vous n'êtes pas à l'origine de cette demande, veuillez contacter le support.")
            ->salutation('Bien cordialement');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
