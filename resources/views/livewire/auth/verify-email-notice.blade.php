<div class="d-flex flex-column justify-content-center w-75 mx-auto">
    <div class="bg-gray-100 rounded-2 border border-primary">
        <div class="d-flex flex-column justify-content-center align-items-center p-5">
            <img src="{{ asset('/storage/icons/verification-email.png') }}" class="w-250px" alt="">
            <div class="fs-3 text-grey-600">
                <p class="fw-bold">Cher gestionnaire,</p>
                <p>
                    Nos systèmes nous indique que vous n'avez pas valider votre adresse mail.<br>
                    Cette validation permet non seulement de vous authentifier en tant que personne mais également de vous alerter sur la vie de votre compte (Nouvelle, facturation, etc...).<br>
                    Afin de continuer à utiliser ce site, veuillez valider votre adresse mail.<br>
                    Merci de votre collaboration.
                </p>
                <p>L'équipe de Vortech Studio</p>
            </div>
            <button wire:click="VerifyEmailNotice" class="btn btn-primary"><i class="fa-solid fa-envelope-circle-check"></i> Valider mon adresse mail</button>
        </div>
    </div>
</div>
