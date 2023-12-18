<div id="kt_app_header" class="app-header">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('admin.dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('/storage/logos/logo.png') }}" class="h-30px" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            @if(Route::is('log-viewer::*'))
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch">
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-10 align-items-stretch fw-semibold px-2 px-lg-0" data-kt-menu="true">
                    <div class="menu-item {{ Route::is('log-viewer::dashboard') ? 'menu-here' : '' }} me-0 me-lg-2">
                        <a href="{{ route('log-viewer::dashboard') }}" class="menu-link">
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </div>
                    <div class="menu-item {{ Route::is('log-viewer::logs.list') ? 'menu-here' : '' }} me-0 me-lg-2">
                        <a href="{{ route('log-viewer::logs.list') }}" class="menu-link">
                            <span class="menu-title">@lang('Logs')</span>
                        </a>
                    </div>
                </div>
            </div>
            @else
                <div></div>
            @endif
            @if(!Route::is('log-viewer::*'))
                    <div class="app-navbar flex-shrink-0">
                        <div class="app-navbar-item align-items-stretch ms-1 ms-md-3">
                            <div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                                <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
                                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px">
                                        <i class="ki-duotone ki-magnifier fs-2 fs-lg-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
                                    <div data-kt-search-element="wrapper">
                                        <form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
                                            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" class="search-input form-control form-control-flush ps-10" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
                                            <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
										<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
									</span>
                                            <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
										<i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
									</span>
                                            <div class="position-absolute top-50 end-0 translate-middle-y" data-kt-search-element="toolbar">
                                                <div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1" data-bs-toggle="tooltip" title="Show search preferences">
                                                    <i class="ki-duotone ki-setting-2 fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                                <div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary" data-bs-toggle="tooltip" title="Show more search options">
                                                    <i class="ki-duotone ki-down fs-2"></i>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="separator border-gray-200 mb-6"></div>
                                        <div data-kt-search-element="results" class="d-none">
                                            <div class="scroll-y mh-200px mh-lg-350px">

                                            </div>
                                        </div>
                                        <div data-kt-search-element="empty" class="text-center d-none">
                                            <div class="pt-10 pb-10">
                                                <i class="ki-duotone ki-search-list fs-4x opacity-50">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <div class="pb-15 fw-semibold">
                                                <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                                                <div class="text-muted fs-7">Please try again with a different query</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="app-navbar-item ms-1 ms-md-3">
                            <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
                                <i class="ki-duotone ki-abstract-4 fs-2 fs-lg-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                                <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('/assets/media/misc/menu-header-bg.jpg')">
                                    <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications <span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
                                </div>
                                <div class="scroll-y mh-325px my-5 px-8">
                                    <div class="d-flex flex-stack py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-4">
										<span class="symbol-label bg-light-primary">
											<i class="ki-duotone ki-abstract-28 fs-2 text-primary">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
										</span>
                                            </div>
                                            <div class="mb-0 me-2">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Alice</a>
                                                <div class="text-gray-400 fs-7">Phase 1 development</div>
                                            </div>
                                        </div>
                                        <span class="badge badge-light fs-8">1 hr</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <img src="" alt="user" />
                            </div>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="" />
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">
                                                <span>{{ auth()->user()->name }}</span>
                                                @if(auth()->user()->admin)
                                                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Admin</span>
                                                @endif
                                            </div>
                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-2"></div>
                                <div class="menu-item px-5">
                                    <a href="{{ route('home') }}" class="menu-link px-5">Retour au site</a>
                                </div>
                                <div class="menu-item px-5">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-flush menu-link px-5"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                            <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                                <i class="ki-duotone ki-element-4 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                    </div>
            @endif
        </div>
    </div>
</div>
