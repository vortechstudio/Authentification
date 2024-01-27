<?php

namespace App\Notifications\System;

use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalButton;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class SendMessageNotification extends Notification
{
    public function __construct(
        public string  $title,
        public string  $message,
        public string  $type = 'info',
        public string  $icon = 'fa-info-circle',
        public ?string $url = ''
    )
    {
    }

    public function via($notifiable): array
    {
        return ['database', OneSignalChannel::class];
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

    public function toOneSignal($notifiable)
    {
        $signal = OneSignalMessage::create()
            ->setSubject($this->title)
            ->setBody($this->message)
            ->setUrl(config('app.url'));

        $this->defineIconForSignal($signal);
        $this->defineButtonForSignal($signal);

        return $signal;
    }

    private function defineIconForSignal($signal)
    {
        $signal->setIcon(storageToUrl('icons/status/'.$this->type.'.png'));
    }

    public function defineButtonForSignal($signal)
    {
        if(!empty($this->url)) {
            $signal->webButton(
                OneSignalWebButton::create('link')
                ->text('Voir')
                ->url($this->url)
            );
        }
    }
}
