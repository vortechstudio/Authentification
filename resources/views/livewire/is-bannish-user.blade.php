<div class="rounded-3 bg-red-100 p-5 w-75 d-flex flex-column justify-content-center align-items-center mx-auto my-15">
    <i class="fa-solid fa-xmark-square fs-5tx text-danger"></i>
    <span class="text-danger fw-bold fs-3x">Votre compte a été bannie des services de Vortech Studio.</span>
    <span class="fs-1">Votre compte à été suspendu pour une durée de {{ \Carbon\Carbon::createFromTimestamp(strtotime(auth()->user()->social->banned_for))->longAbsoluteDiffForHumans() }}</span>
    <form action="/logout" method="post">
        @csrf
        <button type="submit" class="btn btn-lg btn-danger">Déconnexion</button>
    </form>
</div>
