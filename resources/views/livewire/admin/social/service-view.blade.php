<div>
    <div class="d-flex flex-row justify-content-end">
        <a href="{{ route('admin.social.services') }}" class="btn btn-sm btn-outline btn-outline-dark me-3">
            <i class="fa-solid fa-arrow-circle-left"></i> Retour
        </a>
        <a href="#addNote" data-bs-toggle="modal" class="btn btn-sm btn-outline btn-outline-success">
            <i class="fa-solid fa-code-fork"></i> Nouvelle version
        </a>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <img src="{{ $service->image_src }}" alt="" class="card-img-top">
                </div>
                <div class="card-body">
                    <div class="text-center fs-2 fw-bold mb-10">{{ $service->name }}</div>
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                            <span class="fs-1 fw-bolder">Détail</span>
                            <div>
                                <button class="btn btn-link btn-color-primary fw-bold rotate fs-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="30px, 30px">
                                    Menu <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true" id="menu_action">
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.social.services.edit', $service->id) }}" class="menu-link px-3">
                                            Editer le service
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.social.services.editor', $service->id) }}" class="menu-link px-3">
                                            Editer la page du service
                                        </a>
                                    </div>
                                    @if($service->status == 'idea')
                                        <div class="menu-item px-3">
                                            <a wire:click="changeStatus" class="menu-link text-primary px-3 fw-bolder">
                                                Passer en développement
                                            </a>
                                        </div>
                                    @endif
                                    @if($service->status == 'develop')
                                        <div class="menu-item px-3">
                                            <a wire:click="changeStatus" class="menu-link text-deeppurple-800 px-3 fw-bolder">
                                                Passer en production
                                            </a>
                                        </div>
                                    @endif
                                    <div class="menu-item px-3">
                                        <a wire:click="delete" wire:loading.attr="disabled" wire:confirm="La suppression d'un service est définitive, etes-vous sur ?" class="menu-link text-red-500 fw-bold px-3">
                                            Supprimer le service
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center px-3">
                            <span class="fw-bold">Type</span>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid {{ \App\Models\Service::getTypeFormat($service->type, 'icon') }} text-{{ \App\Models\Service::getTypeFormat($service->type, 'color') }} fs-3 me-2"></i>
                                <span class="text-{{ \App\Models\Service::getTypeFormat($service->type, 'color') }}">{{ \App\Models\Service::getTypeFormat($service->type, 'text') }}</span>
                            </div>
                        </div>
                        <div class="separator border border-gray-300 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center px-3">
                            <span class="fw-bold">Status</span>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid {{ \App\Models\Service::getStatusFormat($service->status, 'icon') }} text-{{ \App\Models\Service::getStatusFormat($service->status, 'color') }} fs-3 me-2"></i>
                                <span class="text-{{ \App\Models\Service::getStatusFormat($service->status, 'color') }}">{{ \App\Models\Service::getStatusFormat($service->status, 'text') }}</span>
                            </div>
                        </div>
                        <div class="separator border border-gray-300 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center px-3">
                            <span class="fw-bold">Dernière version</span>
                            <div class="d-flex align-items-center">
                                {{ $service->latest_version }}
                            </div>
                        </div>
                        <div class="separator border border-gray-300 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center px-3">
                            <span class="fw-bold">Url D'accès</span>
                            <div class="d-flex align-items-center">
                                <a href="{{ $service->url_site }}">Accès immédiat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="rounded bg-white p-5">
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 mb-10">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#content">Description & contenues</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#release">Note de mise à jours</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="content" role="tabpanel">
                        <div class="container-fluid">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-column justify-content-end align-items-end bgi-no-repeat bgi-size-contain bgi-position-center h-250px w-100 rounded-3 mb-5" style="background-image: url('{{ $service->image_header }}')">
                                    <div class="d-flex flex-row align-items-center h-70px w-100 bg-black p-5 shadow">
                                        <div class="symbol symbol-45px me-3">
                                            <img src="{{ $service->image_icon }}" alt="">
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1">
                                            <span class="opacity-100 text-white fw-bold fs-2">{{ $service->name }}</span>
                                            <div class="text-muted">{{ $service->latest_version }}</div>
                                        </div>
                                        <div class="me-5">{!! $service->type_label !!}</div>
                                        <div class="me-5">{!! $service->status_label !!}</div>
                                    </div>
                                </div>
                                <x-base.underline
                                    title="Dernières Actualité" />
                                @if(\App\Models\Blog::where('category', 'like', '%'.Str::slug($service->cercle_reference).'%')->orderBy('published_at', 'desc')->count() != 0)
                                    <div class="tns tns-default my-10" style="direction: ltr">
                                        <div
                                            data-tns="true"
                                            data-tns-loop="true"
                                            data-tns-swipe-angle="false"
                                            data-tns-speed="2000"
                                            data-tns-autoplay="true"
                                            data-tns-autoplay-timeout="18000"
                                            data-tns-items="3"
                                            data-tns-center="true"
                                            data-tns-slide-by="true"
                                            data-tns-nav-container="#kt_slider_thumbnails"
                                            data-tns-nav-as-thumbnails="true"
                                            data-tns-prev-button="#kt_slider_prev"
                                            data-tns-next-button="#kt_slider_next"
                                        >
                                            @foreach(\App\Models\Blog::where('category', 'like', '%'.Str::slug($service->cercle_reference).'%')->orderBy('published_at', 'desc')->limit(5)->get() as $article)
                                                <div class="card shadow-lg me-5">
                                                    <img src="{{ $article->image_full }}" alt="" class="card-img-top">
                                                    <div class="card-body">
                                                        <a href="{{ $article->url_to_blog_article }}" class="btn btn-link fw-bold">{{ $article->title }}</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="btn btn-icon btn-active-color-primary" id="kt_slider_prev">
                                            <i class="fa-solid fa-caret-left fs-3tx"></i>
                                        </button>
                                        <button class="btn btn-icon btn-active-color-primary" id="kt_slider_next">
                                            <i class="fa-solid fa-caret-right fs-3tx"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex flex-center">
                                        <ul class="d-flex align-items-center list-unstyled gap-5 cursor-pointer">
                                            <li class="d-flex gap-3" id="kt_slider_thumbnails">
                                                @foreach(\App\Models\Blog::where('category', 'like', '%'.Str::slug($service->cercle_reference).'%')->orderBy('published_at', 'desc')->limit(5)->get() as $article)
                                                    <img src="{{ $article->image_heading }}" class="w-50px rounded" alt=""/>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="d-flex flex-center p-5">
                                        <i class="fa-solid fa-exclamation-triangle text-warning fs-1 me-3"></i>
                                        <span class="fs-1">Aucune nouvelle pour ce service</span>
                                    </div>
                                @endif
                                <div class="mt-10">
                                    <div class="fst-italic">{!! $service->description !!}</div>
                                    <div class="separator border border-2 border-dotted border-gray-300 my-10"></div>
                                    {!! $service->page_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="release" role="tabpanel">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <div class="card-title">Liste des mises à jours</div>
                                <div class="card-toolbar"></div>
                            </div>
                            <div class="card-body">
                                <table class="table table-dark table-striped gap-3 gs-5 gx-5 gy-5 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Version</th>
                                            <th>Titre</th>
                                            <th>Publié</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($notes as $note)
                                            <tr>
                                                <td>{{ $note->version }}</td>
                                                <td>{{ $note->title }}</td>
                                                <td>{!! $note->status_label !!}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-icon btn-danger" x-on:click="$wire.deleteNote({{ $note->id }})" wire:loading.attr="disabled">
                                                        <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
                                                        <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" data-bs-focus="false" id="addNote">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Nouvelle Note de mise à jour</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="" method="POST" id="formaddNote" wire:submit="postNote">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-9">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        <x-form.input
                                            name="version"
                                            label=""
                                            no-label="true"
                                            placeholder="Version" />
                                    </div>
                                    <div class="col-md-12 col-lg-9">
                                        <x-form.input
                                            name="title"
                                            label=""
                                            no-label="true"
                                            placeholder="Titre de la version" />
                                    </div>
                                </div>
                                <x-form.textarea
                                    name="description"
                                    label=""
                                    no-label="true"
                                    placeholder="Description rapide de la mise à jour"
                                    type="ckeditor" />

                                <x-form.textarea
                                    name="contenue"
                                    label=""
                                    no-label="true"
                                    placeholder="Contenue de la mise à jour"
                                    type="ckeditor" />
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <div x-data="{expanded: false}">
                                    <x-form.switches
                                        name="published"
                                        label="Publié la note ?"
                                        value="1"
                                        class-check="success"
                                        :size="[40,25]"
                                        alpine="true"
                                        fun-alpine="expanded = ! expanded" />

                                    <div x-show="expanded" class="mt-10">
                                        <x-form.input
                                            name="published_at"
                                            label=""
                                            no-label="true"
                                            type="text" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push("scripts")
        <script type="text/javascript">
            new tempusDominus.TempusDominus(document.querySelector('[name="published_at"]'), {
                localization: {
                    locale: "fr",
                    startOfTheWeek: 1,
                    format: "dd/MM/yyyy"
                }
            })
        </script>
    @endpush
</div>
