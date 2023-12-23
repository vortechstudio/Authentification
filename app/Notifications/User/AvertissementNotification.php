<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AvertissementNotification extends Notification
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
        return ['mail', "database"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), "VORTECH LAB ADVISOR")
            ->error()
            ->subject("Avertissement à votre encontre")
            ->greeting("Cher ".$this->user->name)
            ->line("Malgré nos relances pour non respect des conditions d'utilisation de Vortech Lab, vous avez persistés à ne pas résoudre les problèmes qui ont énuméré lors de nos précédentes notifications.")
            ->line('Nous sommes obliger de vous notifier ce '.$this->countAdvertissementString()." à votre encontre.")
            ->line("Par ailleurs, les informations qui posaient un problème aux conditions ont été supprimée.")
            ->line("Nous espérons, que dorénavant vous respecterez, nos conditions qui sont là pour rappel, pour discuter, commenter de manière normal et ethiques sur nos différents canaux de discussion.")
            ->line("<strong>Raison de l'avertissement </strong>: ".$this->reason)
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
            'type' => "warning",
            'icon' => "fa-exclamation-triangle",
            'title' => "Avertissement à votre encontre",
            'description' => "Un email vous à été notifier pour vous soumettre un avertissement à votre encontre",
            'time' => now(),
        ];
    }

    private function countAdvertissementString()
    {
        return match($this->user->social->avertissement) {
            0 => "Premier",
            1 => "Deuxième",
            2 => "Dernier"
        };
    }
}
