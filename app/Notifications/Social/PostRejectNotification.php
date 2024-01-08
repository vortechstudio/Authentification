<?php

namespace App\Notifications\Social;

use App\Models\Social\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostRejectNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Post $post
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'VORTECH LAB ADVISOR')
            ->error()
            ->subject("Blocage d'un poste sur Vortech Lab !")
            ->greeting('Cher '.$this->post->user->name)
            ->line("Le poste <strong>{$this->post->title}</strong> à fait l'objet d'un blocage pour certaine raison qui ne respecte pas nos conditions d'utilisation du service Vortech Lab.")
            ->line('Afin de débloquer votre poste, veuillez le vérifier et le faire correspondre à nos critères.')
            ->line("Si dans 7 jours, le poste n'à pas été modifier, il sera supprimer, et un avertissement vous sera transmis.<br>Pour rappel au bout de 3 avertissements, vous pouvez être soumis à une sanction allant jusqu'au banissement pur et simple de Vortech Lab.")
            ->line("Nous pensons qu'il s'agit simplement d'un moment d'égarement qui ne ce reproduira pas.")
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
            'type' => 'danger',
            'icon' => 'fa-xmark',
            'title' => 'Alerte concernant un de vos postes',
            'description' => "Le poste : <strong>{$this->post->title}</strong> à fait l'objet d'un blocage par un modérateur.",
            'time' => now(),
        ];
    }
}
