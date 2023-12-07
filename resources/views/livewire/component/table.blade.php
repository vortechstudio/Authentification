<div>
    <div class="card shadow-lg w-75 mx-auto">
        <div class="card-header bg-grey-700 align-items-center gap-2 gap-md-5">
            <div class="card-title text-white">
                {{ $tableName }}
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped gap-2 gs-7 gx-7 gy-5">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y à H:i') }}</td>
                            <td>{{ $log->action }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
