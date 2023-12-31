<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a data-bs-toggle="modal" href="#adding" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouvelle configuration
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-train fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des configurations</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher une config" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($settings->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr class="fs-2 fw-semibold">
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="value" :field="$orderField">Valeur</x-base.table-header>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $setting->name }}</td>
                            <td>{{ number_format($setting->value, 2, ',', ' ') }}</td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-outline btn-outline-primary" wire:click="startEdit({{ $setting->id }})" data-bs-toggle="tooltip" data-bs-original-title="Editer">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        @if($editId == $setting->id)
                            <tr>
                                <livewire:admin.railway.config.config-edit :setting="$setting" :key="$setting->id" />
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{ $settings->links() }}
            </div>
        @else
            <x-base.is-null />
        @endif
    </div>
</div>
