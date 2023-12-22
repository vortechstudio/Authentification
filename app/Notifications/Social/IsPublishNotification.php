<?php

namespace App\Notifications\Social;

use Illuminate\Notifications\Notification;

class IsPublishNotification extends Notification{
    public function __construct(//|)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [];
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
