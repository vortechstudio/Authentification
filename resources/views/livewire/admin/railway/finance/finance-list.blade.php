<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a data-bs-toggle="modal" href="#addService" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouveau service bancaire
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-train fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des services bancaires</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un service" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
                <button class="btn btn-sm btn-primary" wire:click="actualizeAll" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fa-solid fa-refresh me-2"></i> Actualiser le flux bancaire
                    </span>
                    <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </div>
        @if($banks->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr class="fs-2 fw-semibold">
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Nom du service</x-base.table-header>
                        <th>Intêret</th>
                        <th>Seuil maximal d'emprunt</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                            <tr>
                                <td class="d-flex flex-row align-items-center gap-3">
                                    <div class="symbol symbol-50px symbol-2by3">
                                        <img src="{{ $bank->image }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fs-2 fw-semibold">{{ $bank->name }}</span>
                                        <div class="text-muted">{{ $bank->uuid }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-column w-50 border-right-1 border-gray-300">
                                            <div class="d-flex flex-row align-items-center gap-2">
                                                <span class="fw-bold">Minimum</span>
                                                <span class="fw-bold">{{ $bank->minimal_interest }} %</span>
                                            </div>
                                            <div class="d-flex flex-row align-items-center gap-2">
                                                <span class="fw-bold">Maximal</span>
                                                <span class="fw-bold">{{ $bank->maximal_interest }} %</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <span class="fw-bold fs-2">Interet actuel</span>
                                            <span class="fs-3">{{ $bank->flux()->where('date', now()->startOfDay())->exists() ? $bank->flux()->where('date', now()->startOfDay())->first()->interest : 0 }} %</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row gap-2">
                                        <span class="fw-bold">Emprunt Express:</span>
                                        <span>{{ eur($bank->maximal_account_express_base) }}</span>
                                    </div>
                                    <div class="d-flex flex-row gap-2">
                                        <span class="fw-bold">Emprunt sur marché financier:</span>
                                        <span>{{ eur($bank->maximal_account_public_base) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <x-base.button-trash
                                        function="delete({{ $bank->id }})"
                                        tooltip="Supprimer cette banque"
                                        confirm="Voulez-vous supprimer cette banque ?" />
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
    <div class="modal fade" wire:ignore.self tabindex="-1" id="addService">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouveau Service Bancaire</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" method="POST" id="formaddService" wire:submit.prevent="adding">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            label="Nom de la banque"
                            required="true" />

                        <x-form.input
                            name="description"
                            label="Description de la banque"
                            required="true" />

                        <div class="row">
                            <div class="col-6">
                                <x-form.input
                                    name="minimal_interest"
                                    label="Interet minimum"
                                    required="true" />
                            </div>
                            <div class="col-6">
                                <x-form.input
                                    name="maximal_interest"
                                    label="Interet Maximal"
                                    required="true" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-form.input
                                    name="maximal_account_express_base"
                                    label="Seuil maximal pour emprunt express"
                                    required="true" />
                            </div>
                            <div class="col-6">
                                <x-form.input
                                    name="maximal_account_public_base"
                                    label="Seuil maximal pour emprunt sur les marchés"
                                    required="true" />
                            </div>
                        </div>
                        <x-form.input
                            type="file"
                            name="logo"
                            label="Logo de la banque" />

                        <x-form.checkbox
                            name="actualize"
                            label="Demander l'actualisation du flux pour cette banque ?"
                            checkbox-color="danger" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
