<div>
    <div class="d-flex flex-end align-items-center p-5 mb-10 rounded-3 bg-white gap-3 mb-5">
        <a href="{{ route('admin.wiki.articles') }}" class="btn btn-sm btn-outline btn-outline-dark">
            <i class="fa-solid fa-arrow-circle-left me-2"></i>
            <span>Retour</span>
        </a>
        @if($wiki->posted)
            <button wire:click="unpublish" class="btn btn-sm btn-outline btn-outline-danger">
                <i class="fa-solid fa-xmark-circle me-2"></i>
                <span class="">Dépublier l'article</span>
            </button>
        @else
            <button wire:click="publish" class="btn btn-sm btn-outline btn-outline-success">
                <i class="fa-solid fa-check-circle me-2"></i>
                <span class="">Publier l'article</span>
            </button>
        @endif
        <div class="vr"></div>
        <a href="" class="btn btn-sm btn-icon btn-outline btn-outline-info" data-bs-toggle="tooltip" data-bs-original-title="Editer" data-kt-initialized="1">
            <i class="fa-solid fa-edit me-2"></i>
        </a>
        <button wire:confirm="Voulez-vous supprimer cette article ?" wire:click="delete" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer" data-kt-initialized="1">
            <i class="fa-solid fa-trash me-2"></i>
        </button>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-4 mb-10">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="fw-bolder">Catégorie</div>
                        <div>
                            <div class="symbol symbol-30px me-3">
                                <img src="{{ $wiki->category->icon_path }}" alt="">
                            </div>
                            <span>{{ $wiki->category->name }}</span>
                        </div>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="fw-bolder">Sous catégorie</div>
                        <span>{{ $wiki->subcategory->name }}</span>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="fw-bolder">Status</div>
                        <div>
                            {!! $wiki->status_label !!}
                        </div>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-2"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="fw-bolder">Contributeurs</div>
                        <div class="symbol-group symbol-hover flex-nowrap">
                            @if($wiki->contributors()->count() != 0)
                                @foreach($wiki->contributors()->limit(5)->get() as $contributor)
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="{{ $contributor->name }}" data-kt-initialized="1">
                                        <img alt="Pic" src="{{ $contributor->avatar }}">
                                    </div>
                                @endforeach
                                @if($wiki->contributors()->count() > 5)
                                    <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                        <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+ {{ $wiki->contributors()->count() - 5 }}</span>
                                    </a>
                                @endif
                            @else
                                <div class="d-flex flex-center rounded-3 bg-grey-300 p-2">
                                    <span>Aucun participants</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8 mb-10">
            <div class="card shadow-lg" x-data="{card_title: 'Description'}">
                <div class="card-header">
                    <div class="card-title">
                        <span x-text="card_title"></span>
                    </div>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#description" x-on:click="card_title = 'Description'">Contenue de la page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#logs" x-on:click="card_title = 'Logs du wiki'">Logs</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <i>{!! $wiki->synopsis !!}</i>
                            <div class="separator separator-content border-gray-300 my-15">
                                <i class="ki-duotone ki-chart-pie-4 fs-2 text-grey-300"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </div>
                            {!! $wiki->content !!}
                        </div>

                        <div class="tab-pane fade" id="logs" role="tabpanel">
                            <div class="timeline">
                                @foreach($wiki->logs()->orderBy('created_at', 'desc')->get() as $log)
                                <!--begin::Timeline item-->
                                <div class="timeline-item">
                                    <!--begin::Timeline line-->
                                    <div class="timeline-line w-40px"></div>
                                    <!--end::Timeline line-->
                                    <!--begin::Timeline icon-->
                                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                        <div class="symbol-label bg-light">
                                            <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <!--end::Timeline icon-->
                                    <!--begin::Timeline content-->
                                    <div class="timeline-content mb-10 mt-n1">
                                        <!--begin::Timeline heading-->
                                        <div class="pe-3 mb-5">
                                            <!--begin::Title-->
                                            <div class="fs-5 fw-semibold mb-2">{{ $log->text }}</div>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="d-flex align-items-center mt-1 fs-6">
                                                <!--begin::Info-->
                                                <div class="text-muted me-2 fs-7">{{ $log->created_at->format("d/m/Y à H:i") }}</div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Timeline heading-->
                                    </div>
                                    <!--end::Timeline content-->
                                </div>
                                <!--end::Timeline item-->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
