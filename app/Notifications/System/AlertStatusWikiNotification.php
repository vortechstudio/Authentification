<?php

namespace App\Notifications\System;

use App\Models\User;
use App\Models\Wiki\Wiki;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertStatusWikiNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Wiki $wiki,
        public User $user,
        public string $statement
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if($this->statement == 'created') {
            return [
                'type' => "info",
                'icon' => "fa-file",
                'title' => "Nouvelle article sur le wiki",
                'description' => "L'article <strong>{$this->wiki->title}</strong> a été publié",
                'time' => now(),
            ];
        } else {
            return [
                'type' => "info",
                'icon' => "fa-file",
                'title' => "Edition d'un article du wiki",
                'description' => "L'article <strong>{$this->wiki->title}</strong> a été mise à jour",
                'time' => now(),
            ];
        }
    }
}
