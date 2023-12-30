<div>
    @include("components.layouts.include.alert")
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="{{ route('admin.railway.engines.create') }}" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouveau matériel roulant
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-train fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des matériels roulants</span>
            </div>
            <div class="d-flex flex-row" wire:ignore>
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un matériel roulant" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px me-2" wire:model.change="perPage">
                    <option></option>
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
                <select class="form-select form-select-lg w-125px me-2" placeholder="test" wire:model.change="type_train">
                    <option></option>
                    @foreach(\App\Models\Railway\Engine::selectorTypeTrain() as $type)
                        <option value="{{ $type['id'] }}">{{ $type['value'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if($engines->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="type_train" :field="$orderField">Type</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="active" :field="$orderField">Status</x-base.table-header>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($engines as $engine)
                        <tr>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-70px symbol-2by3 me-3">
                                        <img src="{{ $engine->image_src }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-3">{{ $engine->name }}</span>
                                        <div class="text-muted">{{ $engine->uuid }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row justify-content-between mb-1">
                                        <span class="fw-bold">Type Matériel</span>
                                        <span>{{ $engine->type_train_string }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between mb-1">
                                        <span class="fw-bold">Type Transport</span>
                                        <span>{{ $engine->type_transport_string }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between mb-1">
                                        <span class="fw-bold">Energie</span>
                                        <span>{{ $engine->type_energy_string }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                        <span class="fw-bold">Etat actuel</span>
                                        <span>{!! $engine->active_label !!}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                        <span class="fw-bold">En Boutique</span>
                                        <span>{!! $engine->in_shop_label !!}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                        <span class="fw-bold">En jeux</span>
                                        <span>{!! $engine->in_game_label !!}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                        <span class="fw-bold">Processus</span>
                                        <span>{!! $engine->visual_label !!}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="gap-3">
                                <a href="{{ route('admin.railway.engines.show', $engine->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-primary" data-bs-toggle="tooltip" data-bs-original-title="Voir le matériel" data-kt-initialized="1" wire:navigate>
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.railway.engines.editer', $engine->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-info" data-bs-toggle="tooltip" data-bs-original-title="Editer le matériel" data-kt-initialized="1" wire:navigate>
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.railway.engines.pictures', $engine->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-warning" data-bs-toggle="tooltip" data-bs-original-title="Envoyer les images" data-kt-initialized="1" wire:navigate>
                                    <i class="fa-solid fa-images"></i>
                                </a>
                                <button wire:click="deleteMateriel({{ $engine->id }})" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer le matériel" data-kt-initialized="1" wire:loading.attr="disabled" wire:confirm="Etes-vous sur de vouloir supprimer ce matériel ?">
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
