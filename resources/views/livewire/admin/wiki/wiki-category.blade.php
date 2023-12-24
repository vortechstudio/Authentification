<div x-data="{form_add_category: false, default_view: true}">
    @include("components.layouts.include.alert")
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <button x-on:click="form_add_category = ! form_add_category" class="btn btn-sm btn-primary">
            <div x-show="! form_add_category">
                <i class="fa fa-plus"></i>
                <span>Nouvelle catégorie</span>
            </div>
            <div x-show="form_add_category">
                <i class="fa fa-minus"></i>
                <span>Nouvelle catégorie</span>
            </div>
        </button>
    </div>
    <div class="rounded bg-white mb-10">
        <div x-show="form_add_category" class="mb-10">
            <form action="" class="rounded-3 bg-white p-5" wire:submit="addCategory">
                <x-form.input
                    name="name"
                    label="Désignation" />

                <x-form.select
                    name="cercle_id"
                    label="Appartient au cercle"
                    :options="\App\Models\Social\Cercle::selector()" />

                <x-form.button />
            </form>
        </div>
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-boxes fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des catégories</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher une catégorie" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($categories->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr>
                        <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="cercle_id" :field="$orderField">Cercle</x-base.table-header>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-40px me-3">
                                        <img src="{{ $category->icon_path }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-3">{{ $category->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <img src="{{ $category->cercle->image }}" alt="">
                                    </div>
                                    <span>Railway Manager</span>
                                </div>
                            </td>
                            <td>
                                <a wire:click="showSubcategory({{ $category->id }})" class="btn btn-sm btn-icon btn-outline btn-outline-primary"><i class="fa-solid fa-plus"></i> </a>
                                <a wire:click="startEditCategory({{ $category->id }})" class="btn btn-sm btn-icon btn-outline btn-outline-info"><i class="fa-solid fa-edit"></i> </a>
                                <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteCategory({{ $category->id }})" wire:loading.attr="disabled">
                                    <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                    <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                                </button>
                            </td>
                        </tr>
                        @if($category_id == $category->id)
                            <tr>
                                <td colspan="3">
                                    <x-admin.wiki.wiki-subcategory :category="$category" />
                                </td>
                            </tr>
                        @endif
                        @if($edit_cat == $category->id)
                            <tr>
                                <td colspan="3">
                                    <x-admin.wiki.wiki-edit-category :category="$category" />
                                </td>
                            </tr>
                        @endif
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
        {{ $categories->links() }}
    </div>
</div>
