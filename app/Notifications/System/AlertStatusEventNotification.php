<?php

namespace App\Notifications\System;

use Illuminate\Notifications\Notification;

class AlertStatusEventNotification extends Notification{
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
