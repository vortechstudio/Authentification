<div x-data="{form_add_reward: false}">
    <div class="card shadow-lg">
        <div class="card-header">
            <div class="card-title">Liste des récompenses</div>
            <div class="card-toolbar">
                <div class="d-flex align-items-center gap-3">
                    <select class="form-select form-select-lg w-125px me-2" wire:model.change="search">
                        <option value=""></option>
                        <option value="argent">Argent</option>
                        <option value="tpoint">T Point</option>
                        <option value="engine">Matériel Roulant</option>
                        <option value="hubs">Hubs & Connexes</option>
                        <option value="boost">Boost de recherche</option>
                    </select>
                    <select class="form-select form-select-lg w-125px me-2" wire:model.change="perPage">
                        <option class="5">5</option>
                        <option class="10">10</option>
                        <option class="25">25</option>
                        <option class="50">50</option>
                    </select>
                    <button x-on:click="form_add_reward = ! form_add_reward" class="btn btn-sm btn-outline btn-outline-info">
                        <i class="fa-solid fa-plus-circle me-2"></i> Nouvelle récompense
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div x-show="form_add_reward" class="mb-10 w-50 mx-auto justify-content-center">
                <form action="" wire:submit.prevent="adding">
                    @csrf
                    <x-form.select
                        select-type="select2"
                        :options="\App\Models\Railway\RailwayBadgeReward::selectorType()"
                        name="type"
                        label="Type de récompense"
                        required="true" />

                    <x-form.input
                        name="value"
                        label="Valeur"
                        required="true" />

                    <x-form.button />

                </form>
            </div>
            @if($rewards->count() != 0)
                <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                    <div class="table-loading-message">
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                    </div>
                    <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                        <thead>
                        <tr>
                            <x-base.table-header :direction="$orderDirection" name="type" :field="$orderField">Type</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="value" :field="$orderField">Valeur</x-base.table-header>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rewards as $reward)
                            <tr>
                                <td>{{ $reward->type_string }}</td>
                                <td>{{ number_format($reward->value, 0, ',', ' ') }}</td>
                                <td>
                                    <x-base.button-trash
                                        function="delete({{ $reward->id }})"
                                        tooltip="Supprimer la récompense"
                                        confirm="Voulez-vous supprimer la récompense ?" />
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

        </div>
    </div>
</div>
