<div x-data="{form_add_station: false}" class="w-100">
    @include("components.layouts.include.alert")
    <div class="d-flex flex-end mb-5">
        <button x-on:click="form_add_station = ! form_add_station" class="btn btn-outline btn-outline-inverse">
            <i class="fa-solid fa-plus-circle me-2"></i> Ajouter une station
        </button>
    </div>
    <div x-show="form_add_station" class="mb-10 w-50 mx-auto justify-content-center">
        <form wire:submit="adding" action="">
            @csrf
            <x-form.select
                select-type="select2"
                :options="\App\Models\Railway\Gare::selector()"
                name="gare_id"
                label="Gare déservie"
                placeholder="-- Selectionner une gare --" />

            <x-form.button />
        </form>
    </div>
    <table class="table table-rounded border border-gray-300 gy-5 gs-5 gx-5 gap-5 align-middle">
        <thead>
            <tr>
                <th>Arrêt</th>
                <th>Temps</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(count($stations) != 0)
                @foreach($stations as $station)
                    <tr class="border-bottom border-gray-300">
                        <td>{{ $station->gare->name }}</td>
                        <td>{{ $station->time }} min</td>
                        <td>
                            <button wire:click="delete({{ $station->id }})" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer l'arrêt" data-kt-initialized="1" wire:loading.attr="disabled" wire:confirm="Etes-vous sur de vouloir supprimer cette arrêt ?">
                                <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">
                        <x-base.is-null />
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
