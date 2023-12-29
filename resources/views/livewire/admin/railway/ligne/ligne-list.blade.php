<div>
    @include("components.layouts.include.alert")
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-train fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des lignes</span>
            </div>
            <div class="d-flex flex-row">
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($lignes->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr>
                       <th>Ligne</th>
                       <th>Hub Origine</th>
                        <x-base.table-header :direction="$orderDirection" name="price" :field="$orderField">Prix Brut</x-base.table-header>
                        <th>Statistique</th>
                        <x-base.table-header :direction="$orderDirection" name="active" :field="$orderField">Status</x-base.table-header>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lignes as $ligne)
                        <tr>
                            <td>{{ $ligne->name }}</td>
                            <td>{{ $ligne->hub->gare->name }}</td>
                            <td>{{ eur($ligne->price) }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <i class="fa-solid fa-map-marker me-1"></i>
                                        <span>{{ $ligne->distance }} Km</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <i class="fa-solid fa-clock me-1"></i>
                                        <span>{{ $ligne->time_min }} min</span>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <i class="fa-solid fa-meta me-1"></i>
                                        <span>{{ $ligne->visual }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {!! $ligne->status_label !!}
                            </td>
                            <td>
                                <a href="{{ route('admin.railway.lignes.show', $ligne->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Voir la ligne">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button wire:click="delete({{ $ligne->id }})" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer la ligne" data-kt-initialized="1" wire:loading.attr="disabled" wire:confirm="Etes-vous sur de vouloir supprimer cette ligne ?">
                                    <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                    <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $lignes->links() }}
            </div>
        @else
            <div class="d-flex flex-row justify-content-center align-items-center rounded bg-gray-300 p-5 m-5">
                <i class="fa-solid fa-exclamation-triangle text-warning fs-1 me-2"></i>
                <span class="fs-2x">Aucunes données disponibles !</span>
            </div>
        @endif
    </div>
</div>
