<div class="my-10">
    <div class="card shadow-lg w-75 mx-auto">
        <div class="card-header bg-grey-700">
            <div class="card-title  text-white">Historique de connexion</div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <p class="fw-bold fs-3">Le tableau suivant indique les différentes actions effectuées en relation avec votre compte Vortech Studio.</p>
            <table class="table table-bordered table-striped gap-2 gs-7 gx-7 gy-5">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(auth()->user()->logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format("d/m/Y à H:i") }}</td>
                            <td>{{ $log->action }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
