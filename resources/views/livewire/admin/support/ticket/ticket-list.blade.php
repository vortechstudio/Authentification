<div>
    @if($createForm)
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">Création du ticket de support manuel</div>
                <div class="card-toolbar">
                    <button class="btn btn-sm btn-outline btn-outline-dark" wire:click="hideCreateForm">
                        <i class="fa-solid fa-times me-2"></i> Annuler
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="" wire:submit.prevent="createTicket">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-12 col-lg-9 mb-10">
                            <x-form.input
                                name="title"
                                label="Titre du ticket"
                                required="true"
                                is-model="true"
                                model="form" />

                            <x-form.textarea
                                name="message"
                                label="Description principal du ticket"
                                required="true"
                                is-model="true"
                                type="tinymce"
                                model="form" />


                        </div>
                        <div class="col-sm-12 col-lg-3 mb-10">
                            <div class="mb-10">
                                <label for="selectedService" class="form-label required">Services</label>
                                <select class="form-select" wire:model.change="form.selectedService">
                                    <option value=""></option>
                                    @foreach(\App\Models\Service::all() as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(!empty($form->ticketCategories))
                                <div class="mb-10">
                                    <label for="ticket_category_id" class="form-label required">Catégorie</label>
                                    <select class="form-select" id="ticket_category_id" wire:model.change="form.ticket_category_id">
                                        <option value=""></option>
                                        @foreach($form->ticketCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="mb-10">
                                <label for="priority" class="form-label required">Priorité</label>
                                <select class="form-select" wire:model="form.priority">
                                    <option value=""></option>
                                    <option value="low">Basse</option>
                                    <option value="medium">Normal</option>
                                    <option value="high">Haute</option>
                                </select>
                            </div>
                            <div class="mb-10">
                                <label for="user_id" class="form-label required">Utilisateur concerné</label>
                                <select class="form-select" id="user_id" wire:model="form.user_id">
                                    <option value=""></option>
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-form.checkbox
                                name="pushToJira"
                                label="Créer le ticket sur Jira"
                                is-model="true"
                                model="form" />

                            <div class="d-flex flex-end">
                                <x-form.button text-submit="Créer le ticket" />
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa-solid fa-ticket fs-1 me-3"></i> Liste des tickets de support
                </div>
                <div class="card-toolbar d-flex flex-wrap align-items-center">
                    <div class="me-2">
                        <input type="text" class="form-control" wire:model.live.debounce.500ms="search" placeholder="Rechercher...">
                    </div>
                    <div class="me-2">
                        <select class="form-select" wire:model.change="statusFilter">
                            <option value="">Tous les statuts</option>
                            <option value="open">Ouvert</option>
                            <option value="pending">En attente</option>
                            <option value="closed">Fermé</option>
                        </select>
                    </div>
                    <div class="me-2">
                        <select class="form-select" wire:model.change="priorityFilter">
                            <option value="">Toutes les priorités</option>
                            <option value="low">Basse</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Haute</option>
                        </select>
                    </div>
                    <div class="me-2">
                        <select class="form-select" wire:model.change="serviceFilter">
                            <option value="">Tous les services</option>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mx-2">
                        <button class="btn btn-sm btn-icon btn-outline btn-outline-dark" wire:click="refreshFilter" data-bs-toggle="tooltip" data-bs-original-title="Rafraichir le filtrage">
                            <i class="fa-solid fa-refresh"></i>
                        </button>
                    </div>
                    <div class="mx-2">
                        <button class="btn btn-sm btn-icon btn-primary" wire:click="showCreateForm">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($tickets->count() > 0)
                    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                        <div class="table-loading-message">
                            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                        </div>
                        <table class="table table-row-bordered table-striped table-row-gray-500 border gap-2 gs-5 gx-5 gy-5 align-middle">
                            <thead>
                            <tr class="fw-bolder fs-3">
                                <x-base.table-header :direction="$sortDirection" name="priority" :field="$sortBy"></x-base.table-header>
                                <x-base.table-header :direction="$sortDirection" name="ticket_category_id" :field="$sortBy"></x-base.table-header>
                                <th>Sujet</th>
                                <x-base.table-header :direction="$sortDirection" name="service_id" :field="$sortBy">Service</x-base.table-header>
                                <th>Utilisateurs</th>
                                <x-base.table-header :direction="$sortDirection" name="status" :field="$sortBy">Etat</x-base.table-header>
                                <x-base.table-header :direction="$sortDirection" name="updated_at" :field="$sortBy">Mise à jour</x-base.table-header>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td class="border border-right-1 border-gray-500">{!! $ticket->priority_label !!} <span class="d-none">{{ $ticket->priority }}</span></td>
                                    <td class="border border-right-1 border-gray-500"><i class="fa-solid {{ $ticket->category->icon }} fs-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $ticket->category->name }}"></i> </td>
                                    <td class="border border-right-1 border-gray-500">{{ $ticket->title }}</td>
                                    <td class="border border-right-1 border-gray-500">{{ $ticket->service->name }}</td>
                                    <td class="d-flex flex-row align-items-center border border-right-1 border-gray-500">
                                        <div class="symbol symbol-50px symbol-circle me-2">
                                            <img src="{{ $ticket->user->avatar }}" alt="">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin.config.users.show', $ticket->user->id) }}" class="text-hover-primary fw-bold fs-3">{{ $ticket->user->name }}</a>
                                            <span class="text-muted fs-8 fw-bold">#{{ $ticket->user->token_tag }}</span>
                                        </div>
                                    </td>
                                    <td class="border border-right-1 border-gray-500">{!! $ticket->status_label !!}</td>
                                    <td class="border border-right-1 border-gray-500">{{ $ticket->updated_at->format("d/m/Y H:i") }}</td>
                                    <td class="border border-right-1 border-gray-500">
                                        <a href="{{ route('admin.support.tickets.show', $ticket->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-primary" data-bs-toggle="tooltip" data-bs-original-title="Voir le ticket">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-base.is-null
                        text="Aucun ticket de support n'a été trouvé." />
                @endif
            </div>
            <div class="card-footer">
                {{ $tickets->links() }}
            </div>
        </div>
    @endif
</div>
