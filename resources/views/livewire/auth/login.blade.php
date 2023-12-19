<div class="my-10">
    <div class="w-50 rounded-3 shadow-lg border border-2 border-primary bg-grey-100 d-flex flex-column justify-content-center align-items-center mb-10 p-5 mx-auto">
        <div class="py-5">
            <x-base.underline
                title="Connexion"
                color="primary"
                style-text="fs-2tx fw-bold" />
        </div>

        <form wire:submit="login" class="form w-75 mb-10">
            @csrf
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
            <x-form.input
                name="email"
                type="email"
                label="Adresse Mail"
                placeholder="Entrez votre adresse mail"
                required="true"
                class="bg-white"
                wire:model="email"
                no-label="true" />

            <x-form.input
                name="password"
                type="password"
                label="Mot de passe"
                placeholder="Entrez votre mot de passe"
                required="true"
                class="bg-white"
                wire:model="password"
                no-label="true" />
            <div class="d-flex flex-row justify-content-between mb-2">
                <x-form.checkbox
                    name="remember"
                    label="Se souvenir de moi"
                    checked="true"
                    value="true"
                    checkbox-size="sm"
                    wire:model="remember"
                    checkbox-color="primary" />
                <a href="{{ route('password.email') }}" class="fs-base fw-bold link-primary">Mot de passe oublier ?</a>
            </div>
            <div class="d-flex flex-center">
                <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-right-to-bracket fs-2x text-white me-2"></i> Se connecter</button>
            </div>
            <div class="separator border border-2 border-gray-300 rounded-2 w-100 my-14"></div>
            <a href="{{ route('register') }}" class="btn btn-flex btn-primary text-white fw-bolder w-100 mb-2">
                <i class="fa-regular fa-circle-user fs-2x text-white me-2"></i>
                <span>Créer un compte</span>
            </a>
            <a href="https://support.{{ config('app.domain') }}" class="btn btn-flex btn-secondary fw-bolder w-100">
                <i class="fa-solid fa-cogs fs-2x text-grey-600 me-2"></i>
                <span>Support vortech studio</span>
            </a>
        </form>
    </div>
    <div class="card shadow-lg w-50 mx-auto">
        <div class="card-header bg-dark">
            <div class="card-title">
                <span class="bullet bullet-vertical bg-red-300 w-7px h-45px me-5"></span>
                <span class="text-white">Avis & Actualités</span>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <livewire:blog.actualities
                type="VORTECH"
                sub="AUTH"
                limit="5" />
        </div>
    </div>
</div>
