<div x-data="{}">
    @include("components.layouts.include.alert")
    <div class="rounded bg-white mb-10 p-5">
        <div class="nav nav-tabs gap-5 mb-10">
            <div class="nav-item">
                <a href="#all" class="btn btn-outline btn-outline-primary btn-active-primary active" data-bs-toggle="tab">Tous</a>
            </div>
            <div class="nav-item">
                <a href="#railway" class="btn btn-outline btn-outline-primary" data-bs-toggle="tab">Railway Manager</a>
            </div>
            <div class="nav-item">
                <a href="#vortechlab" class="btn btn-outline btn-outline-primary" data-bs-toggle="tab">Vortech Lab</a>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                @if($feeds->count() !== 0)
                    @foreach ($feeds as $feed)
                        <div class="card mb-5 mb-xl-8 @if($feed->is_reject) bg-grey-200 @else bg-grey-100 @endif">
                            <!--begin::Body-->
                            <div class="card-body pb-0">
                                <!--begin::Header-->
                                <div class="d-flex align-items-center mb-3">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-45px me-5">
                                            <img src="{{ $feed->user->avatar }}" alt="">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-row">
                                                <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold me-5">{{ $feed->user->name }}</a>
                                                @if($feed->is_reject)
                                                    <span class="badge badge-danger">Poste rejeter</span>
                                                @endif
                                            </div>
                                            <span class="text-gray-400 fw-bold">
                                            @if($feed->created_at->between(now()->startOfDay(), now()->endOfDay()))
                                                    {{ $feed->created_at->diffForHumans() }}
                                                @else
                                                    {{ $feed->created_at->format("d/m/Y à H:i") }}
                                                @endif
                                        </span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Menu-->
                                    <div class="my-0">
                                        <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 2-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Actions</div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mb-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            @if($feed->is_reject)
                                                <div class="menu-item px-3">
                                                    <a wire:click="acceptPost({{ $feed->id }})" class="menu-link px-3">Accepter le poste</a>
                                                </div>
                                            @else
                                                <div class="menu-item px-3">
                                                    <a wire:click="rejectPost({{ $feed->id }})" class="menu-link px-3">Rejeter le poste</a>
                                                </div>
                                            @endif
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Post-->
                                <div class="mb-7">
                                    <!--begin::Text-->
                                    <div class="text-gray-800 mb-5">
                                        {!! $feed->content !!}
                                    </div>
                                    <!--end::Text-->
                                    <!--begin::Toolbar-->
                                    <div class="d-flex align-items-center mb-5">
                                        <a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-success px-4 py-2 me-4">
                                            <i class="ki-duotone ki-message-text-2 fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>{{ $feed->comments()->count() }}</a>
                                        <a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-danger px-4 py-2">
                                            <i class="ki-duotone ki-heart fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>{{ $feed->likes }}</a>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Post-->
                                <!--begin::Replies-->
                                @if($feed->comments()->count() > 0)
                                    <div class="mb-7">
                                        @foreach($feed->comments as $comment)
                                            <div class="d-flex mb-5 ms-10">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="{{ $comment->user->avatar }}" alt="">
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-column flex-row-fluid">
                                                    <!--begin::Info-->
                                                    <div class="d-flex align-items-center flex-wrap mb-1">
                                                        <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">{{ $comment->user->name }}</a>
                                                        <span class="text-gray-400 fw-semibold fs-7">
                                                            @if($comment->created_at <= now()->endOfDay())
                                                                {{ $comment->created_at->diffForHumans() }}
                                                            @else
                                                                {{ $comment->created_at->format("d/m/Y à H:i") }}
                                                            @endif
                                                        </span>
                                                        @if($comment->is_reject)
                                                            <a href="" wire:click="blockReponse({{ $comment->id }})" class="ms-auto text-gray-400 text-hover-danger fw-semibold fs-7">Rejeter</a>
                                                        @else
                                                            <a href="" wire:click="unblockReponse({{ $comment->id }})" class="ms-auto text-gray-400 text-hover-success fw-semibold fs-7">Débloquer</a>
                                                        @endif

                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Post-->
                                                    <span class="text-gray-800 fs-7 fw-normal pt-1">
                                                        {!! $comment->text !!}
                                                    </span>
                                                    <!--end::Post-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <!--end::Replies-->
                            </div>
                            <!--end::Body-->
                        </div>
                    @endforeach
                @else
                    <x-base.is-null />
                @endif
            </div>
            <div class="tab-pane fade" id="railway" role="tabpanel">
                @foreach ($feeds as $feed)
                    @if($feed->cercles()->first()->name == 'Railway Manager')
                    <div class="card mb-5 mb-xl-8 @if($feed->is_reject) bg-grey-200 @else bg-grey-100 @endif">
                        <!--begin::Body-->
                        <div class="card-body pb-0">
                            <!--begin::Header-->
                            <div class="d-flex align-items-center mb-3">
                                <!--begin::User-->
                                <div class="d-flex align-items-center flex-grow-1">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="{{ $feed->user->avatar }}" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <div class="d-flex flex-row">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold me-5">{{ $feed->user->name }}</a>
                                            @if($feed->is_reject)
                                            <span class="badge badge-danger">Poste rejeter</span>
                                            @endif
                                        </div>
                                        <span class="text-gray-400 fw-bold">
                                            @if($feed->created_at->between(now()->startOfDay(), now()->endOfDay()))
                                                {{ $feed->created_at->diffForHumans() }}
                                            @else
                                                {{ $feed->created_at->format("d/m/Y à H:i") }}
                                            @endif
                                        </span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                                <!--begin::Menu-->
                                <div class="my-0">
                                    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-category fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Actions</div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        @if($feed->is_reject)
                                            <div class="menu-item px-3">
                                                <a wire:click="acceptPost({{ $feed->id }})" class="menu-link px-3">Accepter le poste</a>
                                            </div>
                                        @else
                                            <div class="menu-item px-3">
                                                <a wire:click="rejectPost({{ $feed->id }})" class="menu-link px-3">Rejeter le poste</a>
                                            </div>
                                        @endif
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Post-->
                            <div class="mb-7">
                                <!--begin::Text-->
                                <div class="text-gray-800 mb-5">
                                    {!! $feed->content !!}
                                </div>
                                <!--end::Text-->
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center mb-5">
                                    <a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-success px-4 py-2 me-4">
                                    <i class="ki-duotone ki-message-text-2 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>{{ $feed->comments()->count() }}</a>
                                    <a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-danger px-4 py-2">
                                    <i class="ki-duotone ki-heart fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>{{ $feed->likes }}</a>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Post-->
                            <!--begin::Replies-->
                            @if($feed->comments()->count() > 0)
                            <div class="mb-7">
                                <!--begin::Reply-->
                                <div class="d-flex mb-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="assets/media/avatars/300-14.jpg" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column flex-row-fluid">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center flex-wrap mb-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">Alice Danchik</a>
                                            <span class="text-gray-400 fw-semibold fs-7">1 day</span>
                                            <a href="#" class="ms-auto text-gray-400 text-hover-primary fw-semibold fs-7">Reply</a>
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Post-->
                                        <span class="text-gray-800 fs-7 fw-normal pt-1">Long before you sit dow to put digital pen to paper you need to make sure you have to sit down and write.</span>
                                        <!--end::Post-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Reply-->
                                <!--begin::Reply-->
                                <div class="d-flex">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="assets/media/avatars/300-9.jpg" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column flex-row-fluid">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center flex-wrap mb-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">Harris Bold</a>
                                            <span class="text-gray-400 fw-semibold fs-7">2 days</span>
                                            <a href="#" class="ms-auto text-gray-400 text-hover-primary fw-semibold fs-7">Reply</a>
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Post-->
                                        <span class="text-gray-800 fs-7 fw-normal pt-1">Outlines keep you honest. They stop you from indulging in poorly</span>
                                        <!--end::Post-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Reply-->
                            </div>
                            @endif
                            <!--end::Replies-->
                        </div>
                        <!--end::Body-->
                    </div>
                    @endif
                @endforeach
            </div>
            <div class="tab-pane fade" id="vortechlab" role="tabpanel">
                @foreach ($feeds as $feed)
                    @if($feed->cercles()->first()->name == 'VortechLab')
                    <div class="card mb-5 mb-xl-8 @if($feed->is_reject) bg-grey-200 @else bg-grey-100 @endif">
                        <!--begin::Body-->
                        <div class="card-body pb-0">
                            <!--begin::Header-->
                            <div class="d-flex align-items-center mb-3">
                                <!--begin::User-->
                                <div class="d-flex align-items-center flex-grow-1">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="{{ $feed->user->avatar }}" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <div class="d-flex flex-row">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold me-5">{{ $feed->user->name }}</a>
                                            @if($feed->is_reject)
                                            <span class="badge badge-danger">Poste rejeter</span>
                                            @endif
                                        </div>
                                        <span class="text-gray-400 fw-bold">
                                            @if($feed->created_at->between(now()->startOfDay(), now()->endOfDay()))
                                                {{ $feed->created_at->diffForHumans() }}
                                            @else
                                                {{ $feed->created_at->format("d/m/Y à H:i") }}
                                            @endif
                                        </span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                                <!--begin::Menu-->
                                <div class="my-0">
                                    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-category fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Actions</div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        @if($feed->is_reject)
                                            <div class="menu-item px-3">
                                                <a wire:click="acceptPost({{ $feed->id }})" class="menu-link px-3">Accepter le poste</a>
                                            </div>
                                        @else
                                            <div class="menu-item px-3">
                                                <a wire:click="rejectPost({{ $feed->id }})" class="menu-link px-3">Rejeter le poste</a>
                                            </div>
                                        @endif
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Post-->
                            <div class="mb-7">
                                <!--begin::Text-->
                                <div class="text-gray-800 mb-5">
                                    {!! $feed->content !!}
                                </div>
                                <!--end::Text-->
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center mb-5">
                                    <a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-success px-4 py-2 me-4">
                                    <i class="ki-duotone ki-message-text-2 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>{{ $feed->comments()->count() }}</a>
                                    <a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-danger px-4 py-2">
                                    <i class="ki-duotone ki-heart fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>{{ $feed->likes }}</a>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Post-->
                            <!--begin::Replies-->
                            @if($feed->comments()->count() > 0)
                            <div class="mb-7">
                                <!--begin::Reply-->
                                <div class="d-flex mb-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="assets/media/avatars/300-14.jpg" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column flex-row-fluid">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center flex-wrap mb-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">Alice Danchik</a>
                                            <span class="text-gray-400 fw-semibold fs-7">1 day</span>
                                            <a href="#" class="ms-auto text-gray-400 text-hover-primary fw-semibold fs-7">Reply</a>
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Post-->
                                        <span class="text-gray-800 fs-7 fw-normal pt-1">Long before you sit dow to put digital pen to paper you need to make sure you have to sit down and write.</span>
                                        <!--end::Post-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Reply-->
                                <!--begin::Reply-->
                                <div class="d-flex">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="assets/media/avatars/300-9.jpg" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column flex-row-fluid">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center flex-wrap mb-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">Harris Bold</a>
                                            <span class="text-gray-400 fw-semibold fs-7">2 days</span>
                                            <a href="#" class="ms-auto text-gray-400 text-hover-primary fw-semibold fs-7">Reply</a>
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Post-->
                                        <span class="text-gray-800 fs-7 fw-normal pt-1">Outlines keep you honest. They stop you from indulging in poorly</span>
                                        <!--end::Post-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Reply-->
                            </div>
                            @endif
                            <!--end::Replies-->
                        </div>
                        <!--end::Body-->
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
