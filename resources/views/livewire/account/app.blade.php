<div class="my-10">
    <div class="card shadow-lg w-75 mx-auto mb-10">
        <div class="card-header bg-dark">
            <div class="card-title">
                <span class="bullet bullet-vertical bg-red-300 w-7px h-45px me-5"></span>
                <span class="text-white">Information de compte</span>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            @if(session()->has('error'))
                <x-base.alert
                    type="danger"
                    icon="fa-solid fa-times-circle"
                    title="Erreur"
                    :content="session('error')" />
            @endif
            @if(session()->has('message'))
                <x-base.alert
                    type="success"
                    icon="fa-solid fa-check-circle"
                    title="Création de compte"
                    :content="session('message')" />
            @endif
            <table class="table table-bordered gap-5">
                <tbody>
                    <tr>
                        <td class="bg-bluegrey-400">Pays / Région d'enregistrement</td>
                        <td>{{ geoip(request()->getClientIp())->country }}</td>
                    </tr>
                    <tr>
                        <td class="bg-bluegrey-400">Région enregistré</td>
                        <td>{{ geoip(request()->getClientIp())->continent }}</td>
                    </tr>
                    <tr>
                        <td class="bg-bluegrey-400">Adresse Email</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex mx-auto justify-content-center">
                <button wire:click.prevent="selectEditing" class="btn btn-primary w-50">Editer les informations de compte</button>
            </div>
        </div>
    </div>
    @if($showSelectEditingForm)
        <div class="card shadow-lg w-75 mx-auto mb-10">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <button wire:click.prevent="selectPasswordForm" class="btn btn-lg btn-primary">Editer le mot de passe</button>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <button wire:click.prevent="selectEmailForm" class="btn btn-lg btn-primary">Editer l'adresse Mail</button>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <button wire:click="deleteUser" wire:confirm="Etes-vous sur de vouloir supprimer votre compte ?" class="btn btn-lg btn-danger">Supprimer le compte</button>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <button wire:click="selectAvatarForm" class="btn btn-lg btn-primary">Changer votre avatar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($emailForm)
        <div class="card shadow-lg w-75 mx-auto mb-10">
            <div class="card-header">
                <h3 class="card-title">Edition de l'adresse mail</h3>
            </div>
            <div class="card-body">
                <form wire:submit="changeEmail" action="">
                    @csrf
                    <x-base.alert
                        type="info"
                        icon="fa-solid fa-info-circle"
                        title="Information"
                        content="En changant d'adresse mail, vous devez confirmer votre nouvelle adresse mail." />
                    <x-form.input
                        type="email"
                        name="email"
                        label=''
                        placeholder="Nouvelle adresse mail"
                        required="true"
                        no-label="true" />

                    <div class="d-flex flex-end">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($passwordForm)
        <div class="card shadow-lg w-75 mx-auto mb-10">
            <div class="card-header">
                <h3 class="card-title">Edition du mot de passe</h3>
            </div>
            <div class="card-body">
                <form wire:submit="changePassword" action="">
                    @csrf
                    <x-base.alert
                        type="info"
                        icon="fa-solid fa-info-circle"
                        title="Information"
                        content="En changant votre mot de passe, vous devrez vous reconnecter avec ce nouveau mot de passe." />
                    <x-form.input
                        type="password"
                        name="password"
                        label=''
                        placeholder="Nouveau mot de passe"
                        required="true"
                        no-label="true" />

                    <x-form.input
                        type="password"
                        name="password_confirmation"
                        label=''
                        placeholder="Confirmation du mot de passe"
                        required="true"
                        no-label="true" />

                    <div class="d-flex flex-end">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($avatarForm)
        <div class="card w-75 mx-auto shadow-lg mb-10" wire:transition.scale.origin.top.delay.2s>
            <div class="card-header">
                <div class="card-title"></div>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">
                @if(\Creativeorange\Gravatar\Facades\Gravatar::exists(auth()->user()->email))
                    <div class="bg-green-600 rounded-3 p-5">
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-130px symbol-circle me-5">
                                <img src="{{ \Creativeorange\Gravatar\Facades\Gravatar::get(auth()->user()->email) }}" alt="">
                            </div>
                            <span class="fw-bolder fs-1 flex-grow-1 text-white">Votre avatar a été définie sur GRAVATAR avec succès</span>
                            <a href="https://gravatar.com/profile" target="_blank" class="btn btn-primary">Gérer mon avatar</a>
                        </div>
                    </div>
                @else
                    <div class="bg-red-600 rounded-3 p-5">
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-130px symbol-circle me-5">
                                <img src="{{ \Creativeorange\Gravatar\Facades\Gravatar::get(auth()->user()->email) }}" alt="">
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                                <span class="fw-bolder fs-1 text-white">Avatar non définie</span>
                                <p>Nos systèmes utilise un provider de gestion d'avatar "Gravatar" afin de définir et de gérer de manière externe les avatars des utilisateurs.<br>Afin de définir et gérer votre avatar pour Vortect Studio, veuillez cliquer sur le bouton ci-contre.</p>
                            </div>
                            <a href="https://gravatar.com/" target="_blank" class="btn btn-primary">Créer mon avatar</a>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    @endif
</div>
