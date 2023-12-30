<div >
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a data-bs-toggle="modal" href="#addService" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouveau service
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-train fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des services de location</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un service" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($rentals->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr class="fs-2 fw-semibold">
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Nom du service</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="contract_duration" :field="$orderField">Durée des contrats</x-base.table-header>
                        <th>Accepte</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rentals as $rental)
                        <tr>
                            <td class="d-flex flex-row align-items-center gap-3">
                                <div class="symbol symbol-50px symbol-2by3">
                                    <img src="{{ $rental->image }}" alt="">
                                </div>
                                <span class="fs-2 fw-semibold">{{ $rental->name }}</span>
                            </td>
                            <td>{{ $rental->contract_duration }} {{ Str::plural("Semaine", $rental->contract_duration) }}</td>
                            <td class="d-flex flex-wrap gap-2">
                                @foreach($rental->type as $type)
                                    <div class="symbol symbol-30px symbol-2by3">
                                        <img src="{{ asset('/storage/icons/railway/transport/logo_'.$type.'.svg') }}" alt="" data-bs-toggle="tooltip" data-bs-original-title="{{ Str::ucfirst($type) }}">
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <x-base.button-trash
                                    function="delete({{ $rental->id }})"
                                    tooltip="Supprimer ce service"
                                    confirm="Etes-vous sur de vouloir supprimer ce service ?" />
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
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addService">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouveau service de location</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" method="POST" id="form" wire:submit.prevent="adding">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            label="Nom du service"
                            required="true" />

                        <x-form.input
                            name="contract_duration"
                            label="Durée des contrats"
                            required="true"
                            hint="En semaine" />

                        <x-form.input
                            type="file"
                            name="logo"
                            label="Logo de l'entreprise" />

                        <div class="d-flex flex-wrap gap-3">
                            <x-form.checkbox
                                name="type"
                                label="TER"
                                value="ter" />

                            <x-form.checkbox
                                name="type"
                                label="TGV"
                                value="tgv" />

                            <x-form.checkbox
                                name="type"
                                label="Intercité/Interloire"
                                value="intercite" />

                            <x-form.checkbox
                                name="type"
                                label="Autres"
                                value="other" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
