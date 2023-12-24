<div>
    @include("components.layouts.include.alert")
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="{{ route('admin.wiki.articles.create') }}" class="btn btn-sm btn-outline btn-outline-primary">
            <i class="fa-solid fa-plus-circle me-2"></i> Nouvelle Article
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class='fa-solid fa-file fs-2x me-2'></span>
                <span class="fs-1 fw-semibold">Liste des Articles</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un article" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($articles->count() != 0)
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                    <thead>
                    <tr>
                        <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="wiki_category_id" :field="$orderField">Catégorie</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="posted" :field="$orderField">Publié</x-base.table-header>
                        <th>Participants</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-40px me-3">
                                        <img src="{{ $article->category->icon_path }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-3">{{ $article->category->name }}</span>
                                        <div class="text-muted">{{ $article->subcategory->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{!! $article->status_label !!}</td>
                            <td>
                                <div class="symbol-group symbol-hover flex-nowrap">
                                    @if($article->contributors()->count() != 0)
                                        @foreach($article->contributors as $contributor)
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="{{ $contributor->name }}" data-kt-initialized="1">
                                                <img alt="Pic" src="{{ $contributor->avatar }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="d-flex flex-center rounded-3 bg-grey-300 p-2">
                                            <span>Aucun participants</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="gap-3">
                                <a href="{{ route('admin.wiki.articles.show', $article->id) }}" class="btn btn-icon btn-sm btn-outline btn-outline-primary" data-bs-toggle="tooltip" data-bs-original-title="Voir l'article" data-kt-initialized="1" wire:navigate>
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.wiki.articles.edit', $article->id) }}" class="btn btn-icon btn-sm btn-outline btn-outline-info" data-bs-toggle="tooltip" data-bs-original-title="Editer l'article" data-kt-initialized="1" wire:navigate>
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <button wire:click="deleteArticle({{ $article->id }})" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer l'article" data-kt-initialized="1" wire:loading.attr="disabled" wire:confirm="Etes-vous sur de vouloir supprimer cette article ?">
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
        {{ $articles->links() }}
    </div>
</div>
