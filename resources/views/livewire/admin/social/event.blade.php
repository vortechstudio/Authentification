<div x-data="{form_add_event: false, default_view: true}">
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <button x-on:click="form_add_event = ! form_add_event" class="btn btn-sm btn-primary">
            <div x-show="! form_add_event">
                <i class="fa fa-plus"></i>
                <span>Nouvelle événement</span>
            </div>
            <div x-show="form_add_event">
                <i class="fa fa-minus"></i>
                <span>Nouvelle événement</span>
            </div>
        </button>
    </div>
    <div class="rounded bg-white mb-10">
        <div x-show="form_add_event" class="my-5">
            <form action="" wire:submit.prevent="createEvent">
                @csrf
                <div class="card shadow-lg">
                    <div class="card-header">
                        <div class="card-title">Nouvelle évènement</div>
                        <div class="card-toolbar">
                            <x-form.button />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-9">
                                <x-form.input
                                    name="title"
                                    label=""
                                    no-label="true"
                                    required="true"
                                    placeholder="Titre de l'évènement" />

                                <div class="row">
                                    <div class="col-6">
                                        <x-form.input
                                            type="date"
                                            name="start_at"
                                            required="true"
                                            label="Date de début de l'évènement"/>
                                    </div>
                                    <div class="col-6">
                                        <x-form.input
                                            type="date"
                                            name="end_at"
                                            required="true"
                                            label="Date de fin de l'évènement" />
                                    </div>
                                </div>

                                <x-form.textarea
                                    type="ckeditor"
                                    name="synopsis"
                                    label=""
                                    no-label="true"
                                    required="true"
                                    placeholder="Rapide description de l'évènement" />

                                <x-form.textarea
                                    type="ckeditor"
                                    name="contenue"
                                    label=""
                                    no-label="true"
                                    required="true"
                                    placeholder="Description de l'évènement" />
                            </div>
                            <div class="col-sm-12 col-lg-3">

                                <x-form.select
                                    name="type_event"
                                    :options="\App\Models\Social\Event::typeSelector()"
                                    required="true"
                                    label="Type d'évènement" />

                                <x-form.select
                                    name="cercle_id"
                                    :options="\App\Models\Social\Cercle::selector()"
                                    required="true"
                                    label="Cercle" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div x-show="default_view">
            <div class="d-flex flex-row justify-content-between p-5 mb-5">
                <div class="d-flex align-items-center">
                    <span class='iconify fs-2x me-2' data-icon='mdi:event-star'></span>
                    <span class="fs-1 fw-semibold">Liste des évènements</span>
                </div>
                <div class="d-flex flex-row">
                    <input type="text" class="form-control form-control-lg me-2" placeholder="Rechercher un évènement" wire:model.live.debounce.500ms="search" />
                    <select class="form-select form-select-lg w-125px selectpicker me-2" wire:model.change="perPage">
                        <option class="5">5</option>
                        <option class="10">10</option>
                        <option class="25">25</option>
                        <option class="50">50</option>
                    </select>
                </div>
            </div>
            @if($events->count() != 0)
                <div class="" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                    <div class="table-loading-message">
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                    </div>
                    <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                        <thead>
                        <tr>
                            <th></th>
                            <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="cercle_id" :field="$orderField">Cercle</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="start_at" :field="$orderField">Horodatage</x-base.table-header>
                            <x-base.table-header :direction="$orderDirection" name="status" :field="$orderField">Etat</x-base.table-header>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <div class="symbol symbol-90px symbol-2by3 me-3">
                                            <img src="{{ \App\Models\Social\Event::getSrcImage($event->id, 'wall') }}" alt="">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold fs-3">{{ $event->title }}</span>
                                            <span class="fst-italic text-muted">{{ $event->type_event_string }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <img src="{{ $event->cercles()->first()->image }}" alt="">
                                        </div>
                                        <span>Railway Manager</span>
                                    </div>
                                </td>
                                <td>
                            <span class="badge badge-light-success">
                                <i class="fa-solid fa-clock-four me-2 text-success"></i>
                                <span class="text-success me-5">{{ $event->start_at->format("d.m.Y") }} - {{ $event->end_at->format("d.m.Y") }}</span>
                                @if($event->end_at->startOfDay() > now()->startOfDay())
                                    <span class="badge badge-sm badge-danger">Date dépassé</span>
                                @endif
                            </span>
                                </td>
                                <td>
                                    {!! $event->status_label !!}
                                </td>
                                <td>
                                    <a wire:click="startShow({{ $event->id }})" class="btn btn-sm btn-icon btn-outline btn-outline-primary"><i class="fa-solid fa-eye"></i> </a>
                                    <a wire:click="startEdit({{ $event->id }})" class="btn btn-sm btn-icon btn-outline btn-outline-info"><i class="fa-solid fa-edit"></i> </a>
                                    <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteEvent({{ $event->id }})" wire:loading.attr="disabled">
                                        <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                        <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                                    </button>
                                </td>
                            </tr>
                            @if($showId == $event->id)
                                <tr>
                                    <td colspan="6">
                                        <x-admin.social.event-show :event="$event" />
                                    </td>
                                </tr>
                            @endif
                            @if($editId == $event->id)
                                <tr>
                                    <td colspan="6">
                                        <x-admin.social.event-edit :event="$event" />
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
            {{ $events->links() }}
        </div>
    </div>
</div>
