<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="{{ route('admin.social.articles.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
            <span>Nouvelle article</span>
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class="iconify fs-2x me-2" data-icon="fluent:news-20-regular"></span>
                <span class="fs-1 fw-semibold">Liste des articles</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un article" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker" data-placeholder="-- Selectionner une catégorie" wire:model.change="category">
                    <option selected></option>
                    @foreach(\App\Enum\BlogCategoryEnum::all() as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-lg w-125px selectpicker" data-placeholder="-- Selectionner une Sous catégorie" wire:model.change="subcategory">
                    <option selected></option>
                    @foreach(\App\Enum\BlogSubcategoryEnum::all() as $subcategory)
                        <option value="{{ $subcategory }}">{{ $subcategory }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-lg w-125px selectpicker" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        <table class="table gy-5 gs-5 gx-5 gap-5">
            <thead>
                <tr>
                    <th></th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Publié</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>
                        <div>
                            <span class="fw-bold">Catégorie:</span> {{ $article->category_string }}<br>
                            <span class="fw-bold">Sous-catégorie:</span> {{ $article->subcategory_string }}
                        </div>
                    </td>
                    <td>{{ $article->author_string }}</td>
                    <td>{!! $article->status_label !!}</td>
                    <td>
                        <a href="{{ route('admin.social.articles.edit', $article->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteArticle({{ $article->id }})" wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                            <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $articles->links() }}
    </div>
</div>
