<div>
    <div class="card shadow-lg">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-120px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ $user->avatar }}" alt="image" />
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $user->getStatusFormat('color') }} rounded-circle border border-4 border-body h-20px w-20px" data-bs-toggle="tooltip" data-bs-original-title="{{ $user->getStatusFormat('text') }}"></div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-row justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="fw-bolder fs-2x">{{ $user->name }}</span>
                                @if($user->markEmailAsVerified())
                                    <i class="ki-duotone ki-verify fs-1 text-success" data-bs-toggle="tooltip" data-bs-original-title="Utilisateur Vérifié">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                @endif
                                @if($user->social->avertissement > 1)
                                    <i class="fa-solid fa-exclamation-triangle text-warning fs-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $user->social->avertissement }} {{ Str::plural('Avertissement', $user->social->avertissement) }}" data-kt-metronic-initialized="1"></i>
                                @elseif($user->social->banned)
                                    <i class="fa-solid fa-ban text-danger fs-1" data-bs-toggle="tooltip" data-bs-original-title="Utilisateur Bannie jusqu'au {{ $user->social->banned_for->format("d/m/y H:i") }}" data-kt-metronic-initialized="1"></i>
                                @endif
                                @if($user->social->wiki_contrib > 0)
                                    <i class="fa-solid fa-book-medical text-primary fs-1" data-bs-toggle="tooltip" data-bs-original-title="{{ $user->social->wiki_contrib }} {{ Str::plural('Contribution', $user->social->wiki_contrib) }}" data-kt-metronic-initialized="1"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-envelope fs-4 me-1"></i>
                                    {{ $user->email }}
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-hashtag fs-4 me-1"></i>
                                    {{ $user->token_tag }}
                                </a>
                            </div>
                        </div>
                        <div class="d-flex my-4">
                            <button class="btn btn-sm btn-primary me-3">
                                <i class="fa-solid fa-user-edit me-2"></i> Modifier l'utilisateur
                            </button>
                            <x-base.button-trash
                                function="deleteUser({{ $user->id }})"
                                tooltip="Supprimer cet utilisateur"
                                confirm="Etes-vous sur de vouloir supprimer cet utilisateur ?" />
                            <div class="me-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                </button>

                                <!--begin::Menu 3-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            Voir le profil sur vortech lab
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link text-yellow-800 px-3">
                                            Réinitialiser le niveau d'avertissement
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    @if($user->social->banned)
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a wire:click="unban" class="menu-link text-success px-3">
                                                Débannir l'utilisateur
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    @else
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a wire:click="ban" class="menu-link text-danger px-3">
                                                Bannir l'utilisateur
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    @endif
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="/metronic8/demo1/../demo1/pages/user-profile/overview.html">
                        Overview                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/metronic8/demo1/../demo1/pages/user-profile/projects.html">
                        Projects                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/metronic8/demo1/../demo1/pages/user-profile/campaigns.html">
                        Campaigns                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/metronic8/demo1/../demo1/pages/user-profile/documents.html">
                        Documents                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/metronic8/demo1/../demo1/pages/user-profile/followers.html">
                        Followers                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/metronic8/demo1/../demo1/pages/user-profile/activity.html">
                        Activity                    </a>
                </li>
                <!--end::Nav item-->
            </ul>
        </div>
    </div>
</div>
