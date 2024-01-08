<?php

namespace App\Providers;

use App\Events\ModelCreated;
use App\Models\ServiceNote;
use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketLog;
use App\Models\Support\Ticket\TicketResponse;
use App\Models\User;
use App\Models\Wiki\Wiki;
use App\Observer\ServiceNoteObserver;
use App\Observer\UserObserver;
use App\Observers\TicketLogObserver;
use App\Observers\TicketObserver;
use App\Observers\TicketResponseObserver;
use App\Observers\WikiObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\ModelCreated as ModelCreatedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        ServiceNote::observe(ServiceNoteObserver::class);
        Wiki::observe(WikiObserver::class);
        Ticket::observe(TicketObserver::class);
        TicketResponse::observe(TicketResponseObserver::class);
        TicketLog::observe(TicketLogObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
