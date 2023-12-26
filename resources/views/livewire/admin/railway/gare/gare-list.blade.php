<div>
    @include("components.layouts.include.alert")
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouvelle gare
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-train fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des Gares</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher une gare" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($gares->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Gare</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="type_gare" :field="$orderField">Type</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="is_hub" :field="$orderField">Hub</x-base.table-header>
                        <th>Coordonnée</th>
                        <th>Nombre de ligne</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gares as $gare)
                        <tr>
                            <td>{{ $gare->name }}</td>
                            <td>{{ $gare->type_gare_string }}</td>
                            <td>
                                {!! $gare->is_hub_label !!}
                                @if($gare->hub)
                                    {!! $gare->hub->is_active_label !!}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <i class="fa-solid fa-map-marked me-2"></i>
                                        <span>{{ $gare->latitude }},</span>
                                        <span>{{ $gare->longitude }}</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <i class="fa-solid fa-house me-2"></i>
                                        <span>{{ $gare->city }}</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <i class="fa-solid fa-globe me-2"></i>
                                        <span>{{ $gare->pays }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($gare->is_hub)
                                    <span class="badge badge-primary">{{ $gare->hub->lignes()->count() }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route("admin.railway.gares.show", $gare->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Voir la fiche">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button wire:click="deleteGare({{ $gare->id }})" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer la gare" data-kt-initialized="1" wire:loading.attr="disabled" wire:confirm="Etes-vous sur de vouloir supprimer ce matériel ?">
                                    <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                    <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="d-flex flex-row justify-content-center align-items-center rounded bg-gray-300 p-5 m-5">
                <i class="fa-solid fa-exclamation-triangle text-warning fs-1 me-2"></i>
                <span class="fs-2x">Aucunes données disponibles !</span>
            </div>
        @endif
    </div>
</div>
