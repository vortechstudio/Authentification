<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a data-bs-toggle="modal" href="#addcategory" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouvelle catégorie
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="row">
            @if($categories->count() != 0)
                @foreach($categories as $category)
                    <div class="col-sm-12 col-lg-6 mb-10">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <div class="card-title d-flex flex-column">
                                    <span class="fs-2 fw-bold">{{ $category->name }}</span>
                                    <span class="text-muted">{{ $category->description }}</span>
                                </div>
                                <div class="card-toolbar gap-2">
                                    <button class="btn btn-sm btn-outline btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addResearch">
                                        <i class="fa-solid fa-plus-circle"></i> Ajouter une recherche
                                    </button>
                                    <x-base.button-trash
                                        function="deleteCategory({{ $category->id }})"
                                        tooltip="Supprimer cette catégorie"
                                        confirm="Etes-vous sur de vouloir supprimer cette catégorie ?" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column">
                                    @foreach($category->projects as $project)
                                        <div class="d-flex flex-row justify-content-between align-items-center rounded-2 shadow-lg bg-grey-200 gap-5 p-5">
                                            <div class="d-flex flex-row w-50">
                                                <div class="symbol symbol-50px me-2">
                                                    <img src="{{ $project->icon }}" alt="">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">{{ $project->name }}</span>
                                                    <span class="text-muted">{{ $project->description }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column fs-7">
                                                <div class="d-flex flex-row justify-content-between mb-1">
                                                    <i class="fa-solid fa-clock fs-6 me-2"></i>
                                                    <span>{{ now()->startOfDay()->addMinutes($project->duration_base)->format("H:i:s") }}</span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-between flex-grow-1 mb-1">
                                                    <i class="fa-solid fa-euro-sign fs-6 me-2"></i>
                                                    <span>{{ eur($project->coast_base) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <x-base.button-trash
                                                    function="deleteResearch({{ $project->id }})"
                                                    tooltip="Supprimer cette recherche"
                                                    confirm="Etes-vous sur de vouloir supprimer cette recherche ?" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <x-base.is-null />
            @endif
        </div>
    </div>
    <div class="modal fade" wire:ignore.self tabindex="-1" id="addcategory">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouvelle Catégorie</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" method="POST" id="formaddcategory" wire:submit.prevent="addingCategory">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            label="Nom de la catégorie"
                            required="true" />

                        <x-form.input
                            name="description"
                            label="Description de la catégorie" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self tabindex="-1" id="addResearch">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouvelle Recherche</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" method="POST" id="formaddResearch" wire:submit.prevent="addingResearch">
                    @csrf
                    <div class="modal-body">
                        <x-form.select
                            select-type="select2"
                            name="research_category_id"
                            label="Catégorie de la recherche"
                            required="true"
                            :options="\App\Models\Railway\ResearchCategory::selector()" />

                        <x-form.input
                            name="name_research"
                            label="Nom de la recherche"
                            required="true" />

                        <x-form.input
                            name="description_research"
                            label="Description de la recherche" />

                        <x-form.input
                            name="coast_base"
                            label="Prix de la recherche"
                            required="true" />

                        <x-form.input
                            name="duration_base"
                            label="Durée de la recherche"
                            required="true"
                            hint="En minute" />

                        <x-form.input
                            name="logo"
                            label="Logo de la recherche"
                            type="file" />

                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
