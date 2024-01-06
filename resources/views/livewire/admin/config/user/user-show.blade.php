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
        <div class="card shadow-lg mb-10">
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
        <div class="tab-content">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 mb-5">
                    <div class="d-flex align-items-center p-5 border-2 border-dotted border-primary">
                        <i class="fa-solid fa-comment-dots fs-3x text-primary me-3"></i>
                        <span class="fs-3x fw-bolder text-primary me-3">{{ $user->social->nb_posts }}</span>
                        <div class="d-flex flex-column">
                            <span class="fs-2 text-primary fw-bold">Articles / Feeds</span>
                            <span class="fs-6 text-muted">A ce jour</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center p-5 border-2 border-dotted border-primary">
                        <i class="fa-solid fa-comment-dots fs-3x text-primary me-3"></i>
                        <span class="fs-3x fw-bolder text-primary me-3">{{ $user->social->nb_followers }}</span>
                        <div class="d-flex flex-column">
                            <span class="fs-2 text-primary fw-bold">Followers</span>
                            <span class="fs-6 text-muted">A ce jour</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center p-5 border-2 border-dotted border-primary">
                        <i class="fa-solid fa-comment-dots fs-3x text-primary me-3"></i>
                        <span class="fs-3x fw-bolder text-primary me-3">{{ $user->social->nb_followeds }}</span>
                        <div class="d-flex flex-column">
                            <span class="fs-2 text-primary fw-bold">Suivies</span>
                            <span class="fs-6 text-muted">A ce jour</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center p-5 border-2 border-dotted border-primary">
                        <i class="fa-solid fa-comment-dots fs-3x text-primary me-3"></i>
                        <span class="fs-3x fw-bolder text-primary me-3">{{ $user->social->nb_views }}</span>
                        <div class="d-flex flex-column">
                            <span class="fs-2 text-primary fw-bold">Nombre de vues</span>
                            <span class="fs-6 text-muted">A ce jour</span>
                        </div>
                    </div>
                </div>
                <div class="row g-5 mb-xxl-8">
                    <div class="col-sm-12 col-lg-6">
                        @if($user->comments()->count() > 0)
                            @foreach($user->comments as $comment)
                                <div class="card shadow-lg mb-5 mx-xxl-8">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="{{ $comment->post->user->avatar }}" alt="">
                                                </div>
                                                <!--end::Avatar-->

                                                <!--begin::Info-->
                                                <div class="d-flex flex-column">
                                                    <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold">{{ $comment->post->user->name }}</a>

                                                    <span class="text-gray-500 fw-bold">{{ $comment->post->user->social->signature ?? $comment->post->user->email }}</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <div class="mb-5">
                                            <div class="fs-3 fw-bolder mb-3">{{ $comment->post->title }}</div>
                                            {!! $comment->post->content !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <x-base.is-null
                                text="Aucun commentaire de l'utilisateur" />
                        @endif
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex flex-column mb-5">
                                    <span class="fs-1 fw-bolder">Activités Récentes</span>
                                    <span class="text-muted fs-6">Journalier</span>
                                </div>
                                @if(count($logs) > 0)
                                <div class="timeline-label">
                                    @foreach($user->logs()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->orderBy('created_at', 'desc')->get() as $log)
                                        <div class="timeline-item align-items-center">
                                            <div class="timeline-label fw-bold text-gray-800 fs-6">08:42</div>
                                            <div class="timeline-badge">
                                                <i class="fa fa-genderless text-warning fs-1"></i>
                                            </div>
                                            <div class="fw-normal timeline-content ps-3">
                                                Ceci est un texte
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                    <x-base.is-null
                                        text="Aucune activité récente" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="services" role="tabpanel">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="fa-solid fa-check-circle text-success fs-1 me-3"></i> Liste des services inactifs
                                </div>
                                <div class="card-toolbar"></div>
                            </div>
                            @if($activeServices->count() > 0)
                                <div class="card-body">
                                    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                                        <div class="table-loading-message">
                                            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                                        </div>
                                        <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                                            <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Premium</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($activeServices as $service)
                                                <tr>
                                                    <td class="d-flex align-items-center">
                                                        <div class="symbol symbol-50px me-3">
                                                            <img src="{{ $service->service->image_src }}" alt="">
                                                        </div>
                                                        <span class="fw-bold text-hover-primary fs-2">{{ $service->service->name }}</span>
                                                    </td>
                                                    <td>{!! $service->premium_icon !!}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-icon btn-danger" wire:click="setInactiveService({{ $service->id }})" wire:loading.attr="disabled" data-bs-toggle="tooltip" data-bs-original-title="Désactiver l'accès au service">
                                                            <i class="fa-solid fa-sign-out" wire:loading.class="d-none"></i>
                                                            <i class="fa-solid fa-spin fa-spinner d-none" wire:loading.class.remove="d-none"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{ $activeServices->links() }}
                                </div>
                            @else
                                <div class="card-body">
                                    <x-base.is-null
                                        text="Aucun service actif" />
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-header align-items-center">
                                <div class="card-title">
                                    <i class="fa-solid fa-xmark-circle text-danger fs-1 me-3"></i> Liste des services inactifs
                                </div>
                                <div class="card-toolbar"></div>
                            </div>
                            @if($inactiveServices->count() > 0)
                                <div class="card-body">
                                    <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                                        <div class="table-loading-message">
                                            <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                                        </div>
                                        <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                                            <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($inactiveServices as $service)
                                                <tr>
                                                    <td class="d-flex align-items-center">
                                                        <div class="symbol symbol-50px me-3">
                                                            <img src="{{ $service->service->image_src }}" alt="">
                                                        </div>
                                                        <span class="fw-bold text-hover-primary fs-2">{{ $service->service->name }}</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-icon btn-success" wire:click="setActiveService({{ $service->id }})" wire:loading.attr="disabled" data-bs-toggle="tooltip" data-bs-original-title="Activer l'accès au service">
                                                            <i class="fa-solid fa-sign-in" wire:loading.class="d-none"></i>
                                                            <i class="fa-solid fa-spin fa-spinner d-none" wire:loading.class.remove="d-none"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{ $inactiveServices->links() }}
                                </div>
                            @else
                                <div class="card-body">
                                    <x-base.is-null
                                        text="Aucun service inactif" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contribs" role="tabpanel">
                @if($contribs->count() > 0)
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <div class="card-title">Liste des contributions au wiki</div>
                            <div class="card-toolbar"></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                                <div class="table-loading-message">
                                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                                </div>
                                <table class="table gy-5 gs-5 gx-5 gap-5 align-middle">
                                    <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Catégorie</th>
                                        <th>Publication</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contribs as $contrib)
                                        <tr>
                                            <td>{{ $contrib->title }}</td>
                                            <td>{{ $contrib->category->name }}</td>
                                            <td>{{ $contrib->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.wiki.articles.show', $contrib->id) }}" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Fiche du wiki">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                @else
                    <x-base.is-null
                        text="Aucune contribution de l'utilisateur" />
                @endif
            </div>
        </div>
    @endif
</div>
