<?php

namespace App\View\Components\Admin\Social;

use App\Models\Social\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventEdit extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Event $event
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.social.event-edit');
    }
}
