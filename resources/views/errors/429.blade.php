@extends("components.layouts.app")

@section("content")
    <div class="rounded-3 bg-white p-5 my-10">
        <div class="d-flex flex-column justify-content-center align-items-center w-75 h-300px mx-auto">
            <span class="iconify text-danger mb-5 fs-5qx" data-icon="game-icons:hammer-break"></span>
            <span class="fw-bolder fs-2qx mb-1">Trop de requêtes</span>
            <span class="fs-1 mb-5">On va y allez doucement, d'accord, vous avez effectué trop de requête en même temps.</span>
            <a onclick="local.history.back(-1)" class="btn btn-primary"><i class="fa-solid fa-arrow-circle-left me-2"></i> Retour</a>
        </div>
    </div>
@endsection



