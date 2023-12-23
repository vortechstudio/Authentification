<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BannedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public string $reason
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), "VORTECH LAB ADVISOR")
            ->error()
            ->subject("Banissement de votre compte")
            ->greeting("Cher ".$this->user->name)
            ->line("Malgré nos différentes relances et nos avertissement, vous persistez dans une démarche qui ne correspond pas à nos conditions d'utilisation.")
            ->line('De ce fais, votre compte à été bannie pour une durée de 7 jours à compter de ce jour ('.$this->user->social->banned_at->format("d/m/Y à H:i").' -> '.$this->user->social->banned_for->format("d/m/Y à H:i").')')
            ->line("<strong>Raison du banissement </strong>: ".$this->reason)
            ->salutation("Bien cordialement");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
