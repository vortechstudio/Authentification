<?php

namespace App\Notifications\System;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class SendMessageNotification extends Notification
{
    public function __construct(
        public string $title,
        public string $message,
        public string $type = 'info',
        public string $icon = 'fa-info-circle',
        public string|null $url = ""
    )
    {
    }

    public function via($notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->type,
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->message,
            'time' => now(),
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => $this->type,
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->message,
            'time' => now(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon(asset('/storage/icons/status/'.$this->type.'.png'))
            ->body($this->message);
    }
}
