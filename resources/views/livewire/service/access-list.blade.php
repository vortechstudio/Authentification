<div class="my-10">
    <div class="card shadow-lg w-75 mx-auto">
        <div class="card-header bg-dark">
            <div class="card-title">
                <span class="bullet bullet-vertical bg-red-300 w-7px h-45px me-5"></span>
                <span class="text-white">État des services et options</span>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <p class="fw-semibold fs-3">Vous pouvez consulter ici les détails des services actuellement enregistrés ou résiliés.</p>
            <x-base.title
                title='<i class="fa-solid fa-check-circle text-success fs-2 me-3"></i>Services Actifs' />

            <table class="table table-row-bordered table-striped table-inverse gap-5 gy-5 gs-5 gx-5">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Date d'enregistrement</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(auth()->user()->services()->where('status', 'active')->get() as $service)
                        <tr>
                            <td>{{ $service->service->name }}</td>
                            <td>{{ $service->created_at->format("d/m/Y") }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-10"></div>
            <x-base.title
                title='<i class="fa-solid fa-xmark-circle text-danger fs-2 me-3"></i>Services Inactifs' />
            <table class="table table-row-bordered table-striped table-inverse gap-5 gy-5 gs-5 gx-5">
                <thead>
                <tr>
                    <th>Service</th>
                    <th>Date de résiliation</th>
                </tr>
                </thead>
                <tbody>
                @foreach(auth()->user()->services()->where('status', 'inactive')->get() as $service)
                    <tr>
                        <td>{{ $service->service->name }}</td>
                        <td>{{ $service->updated_at->format("d/m/Y") }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
