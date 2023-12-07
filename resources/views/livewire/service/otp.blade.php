<div class="my-10">
    <div class="card shadow-lg w-75 mx-auto">
        <div class="card-header bg-dark">
            <div class="card-title">
                <span class="bullet bullet-vertical bg-red-300 w-7px h-45px me-5"></span>
                <span class="text-white">Mot de passe à usage unique (OTP)</span>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <p>Réglez les paramètres de sécurité de votre compte Vortech Studio. Pour pouvoir utiliser le système de mot de passe à usage unique et augmenter la sécurité de votre compte, vous devez être en possession d'un identificateur tiers (Google Authenticator, Microsoft Authenticator ou autres).</p>
            @if (session('status') == 'two-factor-authentication-enabled')
                <form action="{{ route('two-factor.confirm') }}" method="POST">
                    @csrf
                    <div class="mx-auto">
                        {!! request()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                    <x-form.input
                        name="code"
                        label=""
                        placeholder="Code de validation"
                        required="true"
                        no-label="true" />
                </form>
            @endif
            @if (session('status') == 'two-factor-authentication-confirmed')
                <x-base.alert
                    type="success"
                    icon="fa-solid fa-check-circle"
                    title="Mot de passe Unique (OTP)"
                    content="Mot de passe à usage unique activé !" />
            @endif
            <x-base.title
                title="Status de l'authentification Forte (OTP)" />
            <table class="table table-bordered align-middle">
                <tbody>
                <tr>
                    <td class="bg-bluegrey-400 text-white fw-semibold fs-3">Code d'identification</td>
                    <td class="fs-3">{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <td class="bg-bluegrey-400 text-white fw-semibold fs-3">Status de l'authentificateur</td>
                    <td class="d-flex flex-row align-items-center">
                        <div class="d-flex flex-grow-1 align-items-center">
                            @if(auth()->user()->two_factor_secret)
                                <i class="fa-solid fa-circle-check text-success fs-2x me-5"></i> <span>Actif</span>
                            @else
                                <i class="fa-solid fa-circle-xmark text-danger fs-2x me-5"></i> <span>Inactif</span>
                            @endif
                        </div>
                        <div class="">
                            @if(auth()->user()->two_factor_secret)
                                <form action="{{ route('two-factor.disable') }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger mb-2">Désactiver l'authentificateur</button>
                                </form>
                                <button wire:click.prevent="showRecorveryCode" class="btn btn-sm btn-primary">Code de récupération</button>
                            @else
                                <form action="{{ route('two-factor.enable') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Activer l'authentificateur</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            @if($recorveryCode)
                <x-base.title
                title="Code de récupération" />
                <ul>
                    @foreach(request()->user()->recoveryCodes() as $code)
                    <li>{{ $code }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
