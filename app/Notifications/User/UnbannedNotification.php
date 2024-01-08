<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnbannedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'VORTECH LAB ADVISOR')
            ->subject("Vous n'êtes plus bannis de Vortech Studio")
            ->greeting('Cher '.$this->user->name)
            ->line('Allez la punition à asser durée, vous pouvez de nouveau acceder aux services de Vortech Studio')
            ->line('Mais attention, la prochaine punition peut être pire que la précédente !')
            ->salutation('Bien cordialement');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'success',
            'icon' => 'fa-check-circle',
            'title' => 'Déblocage de votre compte',
            'description' => "Vous n'êtes plus bannis des services de Vortech Studio",
            'time' => now(),
        ];
    }
}
