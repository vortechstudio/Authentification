<?php

namespace App\Livewire\Admin\Social;

use App\Models\Social\Poll;
use Livewire\Component;

class EventPollResponse extends Component
{
    public Poll $poll;
    public string $name = '';

    public function render()
    {
        return view('livewire.admin.social.event-poll-response');
    }

    public function addResponse()
    {
        $this->validate([
            'name' => "required"
        ]);

        $this->poll->responses()->create([
            'name' => $this->name,
            "users" => json_encode([]),
            "poll_id" => $this->poll->id
        ]);

    }

    public function deleteResponse(int $id) {
        $this->poll->responses()->find($id)->delete();

        session()->flash("success", "Réponse supprimer");
    }
}
