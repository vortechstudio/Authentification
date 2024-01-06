<div>
    @if($startEditing === $user->id)
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">
                    Edition des informations de l'utilisateur
                </div>
                <div class="card-toolbar">
                    <button wire:click="startEditingFn(0)" class="btn btn-sm btn-outline btn-outline-dark me-3">
                        <i class="fa-solid fa-arrow-left me-2"></i> Retour
                    </button>
                    <x-form.button
                        title="Sauvegarder"
                        size="sm" />
                </div>
            </div>
            <div wire:ignore.self class="card-body"
                 x-data="{
                     form_edit_info: false,
                     form_edit_mail: false,
                     form_edit_password: false
                     }">
                <div class="d-flex flex-wrap flex-sm-nowrap justify-content-center mx-auto mb-10">
                    <button type="button" x-on:click="form_edit_info = ! form_edit_info" class="btn btn-flex btn-outline btn-outline-primary px-6 me-5">
                        <i class="fa-solid fa-user-edit fs-2x"></i>
                        <div class="d-flex flex-column align-items-start ms-2">
                            <span class="fs-3 fw-bold">Editer les informations</span>
                            <div class="fs-7">Nom,Signature,etc...</div>
                        </div>
                    </button>
                    <button type="button" x-on:click="form_edit_mail = ! form_edit_mail" class="btn btn-flex btn-outline btn-outline-primary px-6 me-5">
                        <i class="fa-solid fa-mail-bulk fs-2x"></i>
                        <div class="d-flex flex-column align-items-start ms-2">
                            <span class="fs-3 fw-bold">Editer l'adresse Mail</span>
                            <div class="fs-7">Changement de l'adresse de l'utilisateur</div>
                        </div>
                    </button>
                    <button type="button" x-on:click="form_edit_password = ! form_edit_password" class="btn btn-flex btn-outline btn-outline-primary px-6">
                        <i class="fa-solid fa-key fs-2x"></i>
                        <div class="d-flex flex-column align-items-start ms-2">
                            <span class="fs-3 fw-bold">Editer le mot de passe</span>
                            <div class="fs-7">Réinitialisation du mot de passe de l'utilisateur</div>
                        </div>
                    </button>
                </div>
                <div class="card shadow-lg" x-show="form_edit_info">
                    <form action="" wire:submit.prevent="updateUser" wire:confirm="Vous allez changer les informations usuel de cette utilisateur, êtes-vous sur ?">
                        @csrf
                        <div class="card-header">
                            <div class="card-title">Edition des informations</div>
                            <div class="card-toolbar">
                                <x-form.button
                                    size="sm"
                                    text-submit="Sauvegarder" />
                            </div>
                        </div>
                        <div class="card-body">
                            <x-form.input
                                name="name"
                                is-model="true"
                                model="form"
                                label="Nom d'utilisateur"
                                required="true" />
                        </div>
                    </form>
                </div>
                <div class="card shadow-lg" x-show="form_edit_mail">
                    <form action="" wire:submit.prevent="updateMail" wire:confirm="Vous allez changer l'adresse mail de l'utilisateur', êtes-vous sur ?">
                        @csrf
                        <div class="card-header">
                            <div class="card-title">Edition des informations</div>
                            <div class="card-toolbar">
                                <x-form.button
                                    size="sm"
                                    text-submit="Sauvegarder" />
                            </div>
                        </div>
                        <div class="card-body">
                            <x-form.input
                                name="email"
                                is-model="true"
                                model="form"
                                label="Adresse Mail"
                                required="true" />
                        </div>
                    </form>
                </div>
                <div class="card shadow-lg" x-show="form_edit_password">
                    <form action="" wire:submit.prevent="updatePassword" wire:confirm="Vous allez réinitialiser le mot de passe de l'utilisateur, êtes-vous sur ?">
                        @csrf
                        <div class="card-header">
                            <div class="card-title">Edition des informations</div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-center mx-auto">
                            <button type="submit" class="btn btn-flex btn-outline btn-outline-danger" wire:confirm="Vous allez réinitialiser le mot de passe de l'utilisateur, ceci entraine un envoie d'un lien à l'utilisateur concerner, êtes vous sur ?">
                                <i class="fa-solid fa-key fs-2x"></i>
                                <div class="d-flex flex-column align-items-start ms-2">
                                    <span class="fs-3 fw-bold">Réinitialisation du mot de passe</span>
                                    <div class="fs-7">Réinitialisation du mot de passe de l'utilisateur</div>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($startReward === $user->id)
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">Envoie de récompense au joueur: {{ $user->name }}</div>
                <div class="card-toolbar">
                    <button wire:click="startRewardFn(0)" class="btn btn-sm btn-outline btn-outline-dark me-3">
                        <i class="fa-solid fa-arrow-left me-2"></i> Retour
                    </button>
                </div>
            </div>
            <form action="" wire:submit.prevent="sendReward">
                <div class="card-body" x-data="{selectedService: @entangle('selectedService')}">
                    <div class="mb-10">
                        <label for="selectedService" class="form-label required">Type de service</label>
                        <select name="services_id" class="form-select" id="selectedService" wire:model="selectedService">
                            <option value=""></option>
                            @foreach($user->services as $service)
                                <option value="{{ $service->id }}">{{ $service->service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row" x-show="rewardTypes.length > 0">
                        <div class="col-sm-12 col-lg-9">
                            <div class="mb-10">
                                <label for="rewardTypes" class="form-label required">Type de service</label>
                                <select name="reward_type" class="form-select" id="rewardTypes" wire:model="reward_type">
                                    <option value=""></option>
                                    @foreach($rewardTypes as $rewardType)
                                        <option value="{{ $rewardType['id'] }}">{{ $rewardType['value'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3">
                            <x-form.input
                                name="quantity"
                                label="Quantité"
                                required="true" />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <x-form.button
                        title="Envoyer la récompense"
                        size="sm" />
                </div>
            </form>
        </div>
    @else
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
                                <a href="{{ route('admin.config.users') }}" class="btn btn-sm btn-outline btn-outline-dark me-5">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Retour
                                </a>
                                <button wire:click="startEditingFn({{ $user->id }})" class="btn btn-sm btn-primary me-3">
                                    <i class="fa-solid fa-user-edit me-2"></i> Modifier l'utilisateur
                                </button>
                                <button wire:click="delete" class="btn btn-sm btn-danger me-3">
                                    <i class="fa-solid fa-trash me-2"></i> Supprimer l'utilisateur
                                </button>
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
                                        @if($user->social->avertissement >= 1)
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a wire:click="reinitAvert" class="menu-link text-yellow-800 px-3" wire:confirm="Êtes-vous sur de vouloir réinitialiser le nombre d'avertissement de cette utilisateur ?">
                                                    Réinitialiser le niveau d'avertissement
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        @endif
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a wire:click="startRewardFn({{ $user->id }})" class="menu-link px-3">
                                                Envoyer une récompense à ce joueurs
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
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#dashboard">Tableau de bord</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#services">Services</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#contribs">Contributions</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#activity">Flux d'activités</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#follows">Followers</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#logs">Logs de l'utilisateur</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#support">Support</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
            </div>
        </div>
    @endif
</div>
