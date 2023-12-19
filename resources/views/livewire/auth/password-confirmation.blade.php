<div class="my-10">
    <div class="w-50 rounded-3 shadow-lg border border-2 border-primary bg-grey-100 d-flex flex-column justify-content-center align-items-center mb-10 p-5 mx-auto">
        <div class="py-5">
            <x-base.underline
                title="Vérification de votre accès"
                color="primary"
                style-text="fs-2tx fw-bold" />
        </div>

        <form wire:submit="confirm" class="form w-75 mb-10">
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
                name="password"
                type="password"
                label="Mot de passe"
                placeholder="Entrez votre mot de passe"
                required="true"
                class="bg-white"
                wire:model="password"
                no-label="true" />
            <div class="d-flex flex-center">
                <button class="btn btn-primary w-100" type="submit"><i class="fa-regular fa-circle-right fs-2x text-white me-2"></i> Suivant</button>
            </div>
        </form>
    </div>
</div>
