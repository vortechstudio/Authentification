<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5 gap-5">
        <a wire:click="refresh" class="btn btn-sm btn-outline btn-outline-primary" wire:confirm="Cette action va supprimer tous les portes cartes afin de les remplacer, voulez-vous vraiment rafraichir les données ?">
            <i class="fa-solid fa-refresh me-2"></i> Rafraichir les porte carte
        </a>
        <button class="btn btn-sm btn-outline btn-outline-dark" wire:click="$dispatch('openModal', {component: 'admin.railway.cards.card-modal'})">
            <i class="fa-solid fa-plus-circle me-2"></i> Ajouter une carte
        </button>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="accordion" id="kt_accordion_1">
            @foreach($categories as $category)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion_{{ $category['slug'] }}_header">
                        <button class="accordion-button fs-4 fw-semibold {{ $categories->first()['slug'] == $category['slug'] ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_{{ $category['slug'] }}_body" aria-expanded="{{ $categories->first()['slug'] == $category['slug'] ? 'true' : 'false' }}" aria-controls="accordion_{{ $category['slug'] }}_body">
                            <span class="symbol symbol-50px me-2">
                                <span class="symbol-label {{ $category['color_bg'] }}">
                                    <i class="fa-solid fa-wallet {{ $category['color_text'] }} fs-1"></i>
                                </span>
                            </span>
                            <span class="fw-bold fs-2 {{ $category['color_text'] }}">{{ $category['name'] }} ({{ $category['cards']->count() }})</span>
                        </button>
                    </h2>
                    <div id="accordion_{{ $category['slug'] }}_body" class="accordion-collapse collapse {{ $categories->first()['slug'] == $category['slug'] ? 'show' : '' }}" aria-labelledby="accordion_{{ $category['slug'] }}_header" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div class="card shadow-lg">
                                <div class="card-header">
                                    <div class="card-title">&nbsp;</div>
                                    <div class="card-toolbar">
                                        <div class="d-flex flex-row">
                                            <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher une carte" wire:model.live.debounce.500ms="search" />
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
                                    @if($category['cards']->count() != 0)
                                        <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                                            <div class="table-loading-message">
                                                <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                                            </div>
                                            <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                                                <thead>
                                                <tr class="fs-2 fw-semibold">
                                                    <x-base.table-header :direction="$orderDirection" name="description" :field="$orderField">Information</x-base.table-header>
                                                    <x-base.table-header :direction="$orderDirection" name="tpoint_cost" :field="$orderField">Cout</x-base.table-header>
                                                    <x-base.table-header :direction="$orderDirection" name="drop_rate" :field="$orderField">Taux de drop</x-base.table-header>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($category['cards'] as $card)
                                                    <tr>
                                                        <td class="d-flex flex-row align-items-center">
                                                            <div class="symbol symbol-50px me-2">
                                                                <img src="{{ $card->type_icon }}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bold">{{ $card->description }}</span>
                                                                <div>
                                                                    <span class="fw-bold">Type:</span>
                                                                    {{ $card->type_string }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ $card->tpoint_cost }} Tpoint
                                                        </td>
                                                        <td>{{ $card->drop_rate }} %</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-icon btn-outline btn-outline-primary" wire:click="$dispatch('openModal', {component: 'admin.railway.cards.card-modal', arguments:{card: {{ $card }}}})">
                                                                <i class="fa-solid fa-edit"></i>
                                                            </button>
                                                            <x-base.button-trash
                                                                function="delete({{ $card->id }})"
                                                                tooltip="Supprimer cette carte"
                                                                confirm="Etes-vous sur de vouloir supprimer cette carte ?" />
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
                                    {{ $category['cards']->links()  }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @livewire('wire-elements-modal')
</div>
