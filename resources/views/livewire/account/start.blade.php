<div>
    <div class="card shadow-lg w-75 mx-auto mb-10">
        <div class="card-header bg-dark">
            <div class="card-title">
                <span class="bullet bullet-vertical bg-red-300 w-7px h-45px me-5"></span>
                <span class="text-white">Compte Vortech Studio</span>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <div class="card shadow-lg">
                <div class="card-header bg-grey-400">
                    <div class="card-title">Status de l'authentification</div>
                    <div class="card-toolbar"></div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="bg-bluegrey-400 text-white fw-semibold fs-3">Code d'identification</td>
                                <td class="fs-3">{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="bg-bluegrey-400 text-white fw-semibold fs-3">Status de l'authentificateur</td>
                                <td class="fs-3">Non Activé</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-lg w-75 mx-auto mb-10">
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
