<div>
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="{{ route('admin.social.services.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
            <span>Nouveau Service</span>
        </a>
    </div>
    <div class="rounded bg-white mb-10">
        <div class="d-flex flex-row justify-content-between p-5 mb-5">
            <div class="d-flex align-items-center">
                <span class="iconify fs-2x me-2" data-icon="fluent:news-20-regular"></span>
                <span class="fs-1 fw-semibold">Liste des Services</span>
            </div>
            <div class="d-flex flex-row">
                <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un service" wire:model.live.debounce.500ms="search" />
                <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                    <option class="5">5</option>
                    <option class="10">10</option>
                    <option class="25">25</option>
                    <option class="50">50</option>
                </select>
            </div>
        </div>
        @if($services->count() != 0)
            <table class="table gy-5 gs-5 gx-5 gap-5">
                <thead>
                <tr>
                    <th></th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{!! $service->type_label !!}</td>
                        <td>
                            {!! $service->status_label !!}<br>
                            @if($service->latest_version)
                                <strong>Dernière Version:</strong> {{ $service->latest_version }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.social.services.view', $service->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-info">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.social.services.edit', $service->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-primary">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteService({{ $service->id }})" wire:loading.attr="disabled">
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
        {{ $services->links() }}
    </div>
</div>
