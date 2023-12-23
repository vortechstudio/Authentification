<div class="mb-0" id="home">
    <!--begin::Wrapper-->
    <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url(assets/media/svg/illustrations/landing.svg)">
        <!--begin::Header-->
        <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}" data-kt-sticky-reverse="true">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Wrapper-->
                <div class="d-flex align-items-center justify-content-center">
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center @auth() flex-equal @endauth">
                        <!--begin::Mobile menu toggle-->
                        <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2hx">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                        <!--end::Mobile menu toggle-->
                        <!--begin::Logo image-->
                        @auth()
                            <a href="{{ route('login') }}">
                                <img alt="Logo" src="{{ asset('/storage/logos/logo.png') }}" class="logo-default h-25px h-lg-30px" />
                                <img alt="Logo" src="{{ asset('/storage/logos/logo.png') }}" class="logo-sticky h-20px h-lg-25px" />
                            </a>
                        @else
                            <a href="{{ route('login') }}">
                                <img alt="Logo" src="{{ asset('/storage/logos/logo.png') }}" class="logo-default h-50px h-lg-75px" />
                                <img alt="Logo" src="{{ asset('/storage/logos/logo.png') }}" class="logo-sticky h-35px h-lg-40px" />
                            </a>
                        @endauth
                        <!--end::Logo image-->
                    </div>
                    <!--end::Logo-->
                    @auth()
                        @if(!auth()->user()->social->banned)
                    <!--begin::Menu wrapper-->
                    <div class="d-lg-block flex-grow-1" id="kt_header_nav_wrapper">
                        <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-gray-600 menu-state-bg fw-semibold" data-kt-menu="true">
                                <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="fa-regular fa-circle-user fs-1"></i>
                                        </span>
                                        <span class="menu-title fs-3">Mon Compte</span>
                                    </a>
                                    <div class="menu-sub menu-sub-dropdown p-3 w-auto">
                                        <div class="menu-item">
                                            <a href="{{ route('account.app') }}" class="menu-link px-1 py-3 fs-3">
                                                <span class="menu-icon me-1">
                                                    <i class="fa-regular fa-circle-right fs-2"></i>
                                                </span>
                                                <span class="menu-title">Informations de compte</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a href="{{ route('account.history') }}" class="menu-link px-1 py-3 fs-3">
                                                <span class="menu-icon me-1">
                                                    <i class="fa-regular fa-circle-right fs-2"></i>
                                                </span>
                                                <span class="menu-title">Historique du compte</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a href="{{ route('account.history.login') }}" class="menu-link px-1 py-3 fs-3">
                                                <span class="menu-icon me-1">
                                                    <i class="fa-regular fa-circle-right fs-2"></i>
                                                </span>
                                                <span class="menu-title">Historique des connexions</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a href="" class="menu-link px-1 py-3 fs-3">
                                                <span class="menu-icon me-1">
                                                    <i class="fa-regular fa-circle-right fs-2"></i>
                                                </span>
                                                <span class="menu-title">Informations de connexion rapide</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-cogs fs-1"></i>
                                        </span>
                                        <span class="menu-title fs-3">Services & Options</span>
                                    </a>
                                    <div class="menu-sub menu-sub-dropdown p-3 w-auto">
                                        <div class="menu-item">
                                            <a href="{{ route('service.access') }}" class="menu-link px-1 py-3 fs-3">
                                                <span class="menu-icon me-1">
                                                    <i class="fa-regular fa-circle-right fs-2"></i>
                                                </span>
                                                <span class="menu-title">Etat des services & Options</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a href="{{ route('service.otp') }}" class="menu-link px-1 py-3 fs-3">
                                                <span class="menu-icon me-1">
                                                    <i class="fa-regular fa-circle-right fs-2"></i>
                                                </span>
                                                <span class="menu-title">Mot de passe à usage unique</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-info-circle fs-1"></i>
                                        </span>
                                        <span class="menu-title fs-3">Assistance & Aide</span>
                                    </a>
                                </div>
                                @if(auth()->user()->admin)
                                    <div class="menu-item">
                                        <a href="{{ route('admin.dashboard') }}" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <span class="iconify fs-3" data-icon="wpf:administrator"></span>
                                        </span>
                                            <span class="menu-title fs-3">Administration</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <!--end::Menu-->
                        </div>
                    </div>
                    <!--end::Menu wrapper-->
                    <!--begin::Toolbar-->
                    <div class="flex-equal justify-content-center align-items-center text-end ms-1">
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-30px symbol-circle me-2">
                                <img src="{{ \Creativeorange\Gravatar\Facades\Gravatar::get(auth()->user()->email) }}" alt="">
                            </div>
                            <span class="text-white fw-semibold me-10">{{ auth()->user()->name }}</span>
                            <form action="/logout" method="post">
                                @csrf
                                <button class="btn btn-danger btn-sm"><i class="fa-solid fa-sign-out me-2"></i> Déconnexion</button>
                            </form>
                        </div>
                    </div>
                    <!--end::Toolbar-->
                        @endif
                    @endauth

                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Header-->
    </div>
    <!--end::Wrapper-->
    <!--begin::Curve bottom-->
    <div class="landing-curve landing-dark-color mb-10 mb-lg-20">
        <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
        </svg>
    </div>
    <!--end::Curve bottom-->
</div>
