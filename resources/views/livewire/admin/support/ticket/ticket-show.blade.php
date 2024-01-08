<div>
    <div class="card shadow-lg mb-10">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between">
                <span class="fw-bolder fs-2x">{{ $ticket->title }}</span>
                <div class="me-2 d-flex align-items-center">
                    <span class="me-2">
                        {!! $ticket->status_label !!}
                    </span>
                    {!! $ticket->priority_label !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="card-title">
                        <div class="d-flex flex-column">
                            <span class="text-dark fw-bold fs-2">{{ $ticket->user->name }}</span>
                            {!! $ticket->user->status_label !!}
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <span class="fw-bold me-3">Dernière MAJ:</span>
                        @if($ticketResponses->count() > 0)
                            @if($ticketResponses->first()->created_at->diffInDays() > 1)
                                <span>{{ $ticketResponses->first()->created_at->format("d/m/Y à H:i") }}</span>
                            @else
                                <span>{{ $ticketResponses->first()->created_at->longRelativeDiffForHumans() }}</span>
                            @endif
                        @else
                            <span class="text-danger">Aucune Réponse</span>
                        @endif
                    </div>
                </div>
                <livewire:admin.support.ticket.ticket-chat :ticket="$ticket" />
                <div class="card-footer pt-4">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <textarea class="form-control form-control-flush" rows="1" placeholder="Répondre..." wire:model.defer="message"></textarea>
                            <button class="btn btn-primary ms-2" wire:click="send">Envoyer</button>
                        </div>
                        @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4 h-300px h-lg-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="card-title">&nbsp;</div>
                    <div class="card-toolbar gap-2">
                        @if($ticket->status == 'open' || $ticket->status == 'pending')
                            <button wire:click="closeTicket" class="btn btn-sm btn-icon btn-outline btn-outline-danger" data-bs-toggle="tooltip" data-bs-original-title="Clôturer le ticket">
                                <i class="fa-solid fa-lock"></i>
                            </button>
                        @else
                            <button wire:click="openTicket" class="btn btn-sm btn-icon btn-outline btn-outline-success" data-bs-toggle="tooltip" data-bs-original-title="Rouvrir le ticket">
                                <i class="fa-solid fa-unlock"></i>
                            </button>
                        @endif
                        @if(!$ticket->is_jira_ticket)
                            <button wire:click="transfertToJira" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Transférer à JIRA">
                                <i class="fa-brands fa-jira"></i>
                            </button>
                        @else
                            <a href="{{ $ticket->jira_info['self'] }}" class="btn btn-sm btn-icon btn-outline btn-outline-warning" data-bs-toggle="tooltip" data-bs-original-title="Voir le ticket sur jira">
                                <i class="fa-brands fa-jira"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold fs-2">Etat</span>
                        {!! $ticket->status_label !!}
                    </div>
                    <div class="separator border-gray-400 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold fs-2">Priorité</span>
                        {!! $ticket->priority_label !!}
                    </div>
                    <div class="separator border-gray-400 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold fs-2">Service</span>
                        {{ $ticket->service->name }}
                    </div>
                    <div class="separator border-gray-400 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold fs-2">Catégorie</span>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid {{ $ticket->category->icon }} fs-1 me-2"></i> {{ $ticket->category->name }}
                        </div>
                    </div>
                    <div class="separator border-gray-400 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold fs-2">Créer le</span>
                        <div class="d-flex align-items-center">
                            <span class="me-1">{{ $ticket->created_at->format("d/m/Y à H:i") }}</span>
                            <span class="text-muted">({{ $ticket->created_at->shortAbsoluteDiffForHumans() }})</span>
                        </div>
                    </div>
                    <div class="separator border-gray-400 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold fs-2">Mise à jour le</span>
                        <div class="d-flex align-items-center">
                            <span class="me-1">{{ $ticket->updated_at->format("d/m/Y à H:i") }}</span>
                            <span class="text-muted">({{ $ticket->updated_at->shortAbsoluteDiffForHumans() }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
