<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5 gap-5">
        <button class="btn btn-sm btn-outline btn-outline-dark" wire:click="logoutAllConfirm">
            <i class="fa-solid fa-sign-out me-2"></i> Déconnecter tous les utilisateurs
        </button>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">Liste des Utilisateurs</div>
                <div class="card-toolbar">
                    <div class="d-flex align-items-center gap-3">
                        <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un utilisateur" wire:model.live.debounce.500ms="search" />
                        <select class="form-select form-select-lg w-125px me-2" wire:model.change="perPage">
                            <option class="5">5</option>
                            <option class="10">10</option>
                            <option class="25">25</option>
                            <option class="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($users->count() != 0)
                    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                        <div class="table-loading-message">
                            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                        </div>
                        <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                            <thead>
                            <tr>
                                <th></th>
                                <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Identité</x-base.table-header>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        @if($user->social->avertissement > 1)
                                            <i class="fa-solid fa-exclamation-triangle text-warning fs-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $user->social->avertissement }} {{ Str::plural('Avertissement', $user->social->avertissement) }}" data-kt-metronic-initialized="1"></i>
                                        @elseif($user->social->banned)
                                            <i class="fa-solid fa-ban text-danger fs-1" data-bs-toggle="tooltip" data-bs-original-title="Utilisateur Bannie jusqu'au {{ $user->social->banned_for->format("d/m/y H:i") }}" data-kt-metronic-initialized="1"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row align-items-center">
                                            <div class="symbol symbol-50px symbol-circle me-2">
                                                <img src="{{ $user->avatar }}" alt="">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">{{ $user->name }} (<span class="fst-italic fs-6 text-gray-300">{{ $user->token_tag }}</span>)</span>
                                                <span class="text-muted">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                            <span class="fw-bold">Status</span>
                                            {!! $user->status_label !!}
                                        </div>
                                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                            <span class="fw-bold">Type</span>
                                            {!! $user->type_label !!}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.config.users.show', $user->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Voir la fiche de l'utilisateur" data-kt-metronic-initialized="1">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <x-base.button-trash
                                            function="delete({{ $user->id }})"
                                            tooltip="Supprimer cet utilisateur"
                                            confirm="Etes-vous sur de vouloir supprimer cet utilisateur ?" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-base.is-null />
                @endif
            </div>
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
