<?php

namespace App\Listeners;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ModelCreated as EventModelCreated;

class ModelCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventModelCreated $event): void
    {
        $event->model->notify(new ModelCreatedNotification);
    }
}
