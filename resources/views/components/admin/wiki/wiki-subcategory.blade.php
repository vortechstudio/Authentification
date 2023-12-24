<div x-data="{form_add_sub: false}" class="bg-gray-200 p-5">
    <div class="d-flex flex-row justify-content-end mb-10 p-5 gap-2">
        <button x-on:click="form_add_sub = ! form_add_sub" class="btn btn-sm btn-primary">
            <div x-show="! form_add_sub">
                <i class="fa fa-plus"></i>
                <span>Nouvelle sous catégorie</span>
            </div>
            <div x-show="form_add_sub">
                <i class="fa fa-minus"></i>
                <span>Nouvelle sous catégorie</span>
            </div>
        </button>
        <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.showSubcategory(0)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="rounded bg-white mb-10">
        <div x-show="form_add_sub" class="mb-10">
            <form action="" class="rounded-3 bg-white p-5" wire:submit="addSubCategory">
                <x-form.input
                    name="name"
                    label="Désignation" />

                <x-form.button />
            </form>
        </div>
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-boxes fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des Sous catégorie</span>
            </div>
        </div>
        @if($subcategories->count() != 0)
            <div class="table-responsive">
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Nombre d'article</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subcategories as $subcategory)
                        <tr>
                            <td>{{ $subcategory->name }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $subcategory->articles()->count() }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteSubCategory({{ $subcategory->id }})" wire:loading.attr="disabled">
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
