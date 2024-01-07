<?php

namespace App\Livewire\Admin\Support\Ticket;

use App\Models\Support\Ticket\Ticket;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination, LivewireAlert;
    public $search = '';
    public $perPage = 10;
    public $priorityFilter = '';
    public $statusFilter = '';
    public $serviceFilter = '';
    public $sortBy = 'title';
    public $sortDirection = 'asc';
    #[Title("Gestionnaire de tickets de support")]
    public function render()
    {
        $query = Ticket::with(['user', 'service', 'category'])
            ->where('title', 'like', '%' . $this->search . '%');

        if($this->priorityFilter) {
            dd($this->priorityFilter);
            $query->where('priority', $this->priorityFilter);
        }

        if($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if($this->serviceFilter) {
            $query->whereHas('service', function($query) {
                $query->where('name', $this->serviceFilter);
            });
        }

        $tickets = $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.support.ticket.ticket-list', compact('tickets'))
            ->layout('components.layouts.admin');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function setOrderField(string $field)
    {
        if($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }


}
