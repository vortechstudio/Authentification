<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="#addCercle" class="btn btn-sm btn-primary" data-bs-toggle="modal">
            <i class="fa fa-plus"></i>
            <span>Nouveau cercle</span>
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class="iconify fs-2x me-2" data-icon="fluent:news-20-regular"></span>
                <span class="fs-1 fw-semibold">Liste des cercles</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un cercle" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($cercles->count() != 0)
            <table class="table gy-5 gs-5 gx-5 gap-5">
                <thead>
                <tr>
                    <th></th>
                    <th>Titre</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cercles as $cercle)
                    <tr>
                        <td>{{ $cercle->id }}</td>
                        <td>{{ $cercle->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteCercle({{ $cercle->id }})" wire:loading.attr="disabled">
                                <span wire:loading.class="d-none"><i class="fa-solid fa-trash"></i> </span>
                                <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="d-flex flex-row justify-content-center align-items-center rounded bg-gray-300 p-5 m-5">
                <i class="fa-solid fa-exclamation-triangle text-warning fs-1 me-2"></i>
                <span class="fs-2x">Aucunes données disponibles !</span>
            </div>
        @endif
        {{ $cercles->links() }}
    </div>
    <div class="modal fade" tabindex="-1" id="addCercle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouveau cercle</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" wire:submit="store">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            wire:model="name"
                            label="Nom du cercle"
                            required="true" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
