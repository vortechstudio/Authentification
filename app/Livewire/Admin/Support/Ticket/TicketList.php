<?php

namespace App\Livewire\Admin\Support\Ticket;

use App\Livewire\Forms\Admin\Support\Ticket\TicketForm;
use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination, LivewireAlert;
    public TicketForm $form;
    public $search = '';
    public $perPage = 10;
    public $priorityFilter = '';
    public $statusFilter = '';
    public $serviceFilter = '';
    public $sortBy = 'title';
    public $sortDirection = 'asc';
    public $createForm = false;

    public function mount(?int $id = null)
    {
        if($id) {
            $this->form->setTicket(Ticket::find($id));
        }
    }
    #[Title("Gestionnaire de tickets de support")]
    public function render()
    {
        $query = Ticket::with(['user', 'service', 'category'])
            ->where('title', 'like', '%' . $this->search . '%');

        if($this->priorityFilter) {
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

        if($this->form->selectedService) {
            $this->form->ticketCategories = TicketCategory::where('service_id', $this->form->selectedService)->get();
        }

        $tickets = $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.support.ticket.ticket-list', compact('tickets'))
            ->layout('components.layouts.admin');
    }

    public function refreshFilter()
    {
        $this->priorityFilter = '';
        $this->statusFilter = '';
        $this->serviceFilter = '';
        $this->search = '';
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

    public function showCreateForm()
    {
        $this->createForm = true;
    }
    public function hideCreateForm()
    {
        $this->createForm = false;
    }

    public function createTicket()
    {
        try {
            $this->form->save();
            $this->alert("success", "Le ticket a été créé avec succès");
            $this->resetPage();
        } catch (\Exception $e) {
            \Log::emergency($e->getMessage(), [$e->getCode()]);
            $this->alert("error", "Une erreur est survenue lors de la création du ticket");
        }
    }


}
