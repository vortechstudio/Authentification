<?php

namespace App\Service;

use App\Models\Social\Event;

class PollingSystem
{
    public static function verify(Event $event): bool
    {
        if ($event->participants()->count() != 0) {
            return true;
        } else {
            return false;
        }
    }
}
