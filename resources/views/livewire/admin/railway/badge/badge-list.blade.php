<div x-data="{form_add_badge: false}">
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a x-on:click="form_add_badge = ! form_add_badge" class="btn btn-sm btn-outline btn-outline-primary">
            <div x-show="!form_add_badge">
                <i class="fa-solid fa-plus-circle me-2"></i> Nouveau Badge
            </div>
            <div x-show="form_add_badge">
                <i class="fa-solid fa-minus-circle me-2"></i> Nouveau Badge
            </div>
        </a>
    </div>
    <div class="card shadow-lg mb-10" x-show="form_add_badge">
        <x-base.alert
            type="info"
            icon="fa-solid fa-info-circle"
            title="Note concernant la création de badge"
            content="Avant d'ajouter le badge en base de donnée, veuillez créer la fonction dans l'écouteur d'évènement du programme" />

        <form action="" wire:submit.prevent="adding">
            <div class="card-header">
                <div class="card-title">Nouveau Badge</div>
                <div class="card-toolbar">
                    <x-base.button
                        is-link="false"
                        is-icon="true"
                        color="danger"
                        icon="fa-solid fa-xmark"
                        wire:click="form_add_badge = ! form_add_badge" />

                </div>
            </div>
            <div class="card-body">
                <x-form.input
                    name="name"
                    label="Nom du badge"
                    required="true" />

                <x-form.input
                    name="action"
                    label="Désignation de l'action"
                    hint="Nom de la fonction camel_case"
                    required="true" />

                <x-form.input
                    name="action_count"
                    label="Nombre d'action avant déclenchement du badge"
                    required="true" />

            </div>
            <div class="card-footer">
                <x-form.button />
            </div>
        </form>
    </div>
    <div class="card shadow-lg">
        <div class="card-header">
            <div class="card-title">Liste des badges</div>
            <div class="card-toolbar">
                <div class="d-flex align-items-center gap-3">
                    <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un badge" wire:model.live.debounce.500ms="search" />
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
            @if($badges->count() != 0)
                <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                    <div class="table-loading-message">
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                    </div>
                    <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                        <thead>
                        <tr>
                            <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Libellé</x-base.table-header>
                            <th>Actions</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($badges as $badge)
                            <tr>
                                <td class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-30px me-3">
                                        <img src="{{ $badge->icon }}" alt="{{ $badge->action }}">
                                    </div>
                                    <div class="fw-semibold">{{ $badge->name }}</div>
                                </td>
                                <td>{{ $badge->action }} <span class="badge badge-sm badge-primary">{{ $badge->action_count }}</span></td>
                                <td>
                                    <x-base.button
                                        is-link="true"
                                        is-icon="true"
                                        :link="route('admin.railway.badges.show', $badge->id)"
                                        tooltip="Voir le badge"
                                        icon="fa-eye" />
                                    <x-base.button-trash
                                        function="delete({{ $badge->id }})"
                                        tooltip="Supprimer le badge"
                                        confirm="Voulez-vous supprimer le badge {{ $badge->name }} ?" />
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
            {{ $badges->links() }}
        </div>
    </div>
</div>
