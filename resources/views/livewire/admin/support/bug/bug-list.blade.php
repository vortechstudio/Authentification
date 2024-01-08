<div>
    <div class="card shadow-lg">
        <div class="card-header">
            <div class="card-title">Liste des bugs répertoriés</div>
            <div class="card-toolbar">
                <div class="me-2">
                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" placeholder="Rechercher...">
                </div>
                <div class="me-2">
                    <select class="form-select" wire:model.change="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="Done">Terminer</option>
                        <option value="Open">Ouvert</option>
                        <option value="Pending">En attente</option>
                        <option value="Reopen">Ticket Réouvert</option>
                        <option value="Work in Progress">En cours</option>
                    </select>
                </div>
                <div class="me-2">
                    <select class="form-select" wire:model.change="priorityFilter">
                        <option value="">Toutes les priorités</option>
                        <option value="Lowest">Mineur</option>
                        <option value="Low">Basse</option>
                        <option value="Medium">Normal</option>
                        <option value="High">Haute</option>
                        <option value="Highest">Urgente</option>
                    </select>
                </div>
                <div class="me-2">
                    <select class="form-select" wire:model.change="composantFilter">
                        <option value="">Toutes les composants</option>
                        <option value="Auth Vortech Studio">Plateforme Auth</option>
                        <option value="Railway Manager">Railway Manager</option>
                        <option value="VortechLab">VortechLab</option>
                    </select>
                </div>
                <div class="mx-2">
                    <button class="btn btn-sm btn-icon btn-outline btn-outline-dark" wire:click="refreshFilter" data-bs-toggle="tooltip" data-bs-original-title="Rafraichir le filtrage">
                        <i class="fa-solid fa-refresh"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(count($bugs) > 0)
                <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                    <div class="table-loading-message">
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                    </div>
                    <table class="table table-row-bordered table-striped table-row-gray-500 border gap-2 gs-5 gx-5 gy-5 align-middle">
                        <thead>
                        <tr class="fw-bolder fs-3">
                            <th class="w-50px"></th>
                            <th>Designation</th>
                            <th>Etat</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bugs as $bug)
                            <tr>
                                <td class="border border-right-1 border-gray-500">
                                    <div class="symbol symbol-30px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="{{ $bug['fields']['priority']['name'] }}">
                                        <img src="{{ $bug['fields']['priority']['iconUrl'] }}" alt="">
                                    </div>
                                </td>
                                <td class="border border-right-1 border-gray-500 w-25">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold mb-2 fs-3">{{ $bug['fields']['summary'] }}</span>
                                        <div class="d-flex flex-row align-items-center">
                                            @if($bug['fields']['components'])
                                                @foreach($bug['fields']['components'] as $component)
                                                    <div class="badge badge-secondary me-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $component['description'] }}">{{ $component['name'] }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border border-right-1 border-gray-500 w-250px">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-30px symbol-circle me-2">
                                            <img src="{{ $bug['fields']['status']['iconUrl'] }}" alt="">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $bug['fields']['status']['name'] }}</span>
                                            <div class="fs-8 text-muted">{{ $bug['fields']['status']['description'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border border-right-1 border-gray-500">
                                    <div class="d-flex flex-column">
                                        <div>
                                            <span class="fw-bold me-2">Créer le:</span>
                                            <span class="text-muted">{{ \Carbon\Carbon::createFromTimestamp(strtotime($bug['fields']['created']))->format('d/m/Y à H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-bold me-2">Mise à jour le:</span>
                                            <span class="text-muted">{{ \Carbon\Carbon::createFromTimestamp(strtotime($bug['fields']['updated']))->format('d/m/Y à H:i') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border border-right-1 border-gray-500">
                                    <a target="_blank" href="https://vortechstudio.atlassian.net/jira/servicedesk/projects/VSH/queues/custom/39/{{ $bug['key'] }}" class="btn btn-sm btn-icon btn-outline btn-outline-dark">
                                        <i class="fa-solid fa-external-link"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            @else
                <x-base.is-null
                text="Aucun bug répertorié pour le moment." />
            @endif
        </div>
    </div>
</div>
