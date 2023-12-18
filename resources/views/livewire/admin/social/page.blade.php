<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="{{ route('admin.social.pages.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
            <span>Nouvelle Page</span>
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class="iconify fs-2x me-2" data-icon="fluent:news-20-regular"></span>
                <span class="fs-1 fw-semibold">Liste des Pages</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher une page" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($pages->count() != 0)
            <table class="table gy-5 gs-5 gx-5 gap-5">
                <thead>
                <tr>
                    <th></th>
                    <th>Titre</th>
                    <th>Est une page parente</th>
                    <th>Publié</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td>{{ $page->title }}</td>
                        <td>

                        </td>
                        <td>{!! $article->status_label !!}</td>
                        <td>
                            <a href="{{ route('admin.social.pages.edit', $page->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-info">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deletePage({{ $page->id }})" wire:loading.attr="disabled">
                                <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
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
        {{ $pages->links() }}
    </div>
</div>
