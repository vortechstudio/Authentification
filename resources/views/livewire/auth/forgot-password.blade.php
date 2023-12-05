<div class="my-10">
    <div class="w-50 rounded-3 shadow-lg border border-2 border-primary bg-grey-100 d-flex flex-column justify-content-center align-items-center mb-10 p-5 mx-auto">
        <div class="py-5">
            <x-base.underline
                title="Mot de passe perdu ?"
                color="primary"
                style-text="fs-2tx fw-bold" />
        </div>

        <form wire:submit="send" class="form w-75 mb-10">
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
            <p>Si vous avez perdu votre mot de passe, pas de panique, veuillez nous renseigner votre adresse mail dans le champs ci-dessous.<br>
            Si votre email est dans notre base de donnée, un email contenant un lien permettant sa réinitialisation va vous être transmis.
            </p>
            <x-form.input
                name="email"
                type="email"
                label="Adresse Mail"
                placeholder="Entrez votre adresse mail"
                required="true"
                class="bg-white"
                no-label="true" />


            <div class="d-flex flex-center">
                <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-check-circle fs-2x text-white me-2"></i> Envoyer le lien de réinitialisation</button>
            </div>
            <div class="separator border border-2 border-gray-300 rounded-2 w-100 my-14"></div>
            <a href="{{ route('login') }}" class="btn btn-flex btn-primary text-white fw-bolder w-100 mb-2">
                <i class="fa-solid fa-sign-in fs-2x text-white me-2"></i>
                <span>Je m'en souvient</span>
            </a>
            <a href="{{ route('register') }}" class="btn btn-flex btn-primary text-white fw-bolder w-100 mb-2">
                <i class="fa-regular fa-circle-user fs-2x text-white me-2"></i>
                <span>Je souhaite m'inscrire</span>
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
