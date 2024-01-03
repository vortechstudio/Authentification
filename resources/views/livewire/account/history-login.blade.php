<div class="my-10">
    <div class="card shadow-lg w-75 mx-auto">
        <div class="card-header bg-grey-700">
            <div class="card-title  text-white">Historique des connexions</div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <p class="fw-bold fs-3">Le tableau suivant indique les différentes actions effectuées en relation avec votre compte Vortech Studio.</p>
            <div class="row">
                @foreach(\IvanoMatteo\LaravelDeviceTracking\Models\DeviceUser::where('user_id', auth()->user()->id)->get() as $device)
                <div class="col-sm-12 col-lg-6">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="{{ \App\Service\Models\DeviceInfoService::getIconByDevice($device->device->device_type) }} fs-1 me-2"></i>
                                <span>{{ $device->device->device_type }}</span>
                            </div>
                            <div class="card-toolbar">
                                @if(\App\Service\Models\DeviceInfoService::isCurrentDevice($device->device->data['user_agent'], $device->device->ip))
                                    <span class="badge badge-outline badge-primary uppercase">Appareil Actuel</span>
                                @else
                                    <button class="btn btn-sm btn-outline btn-outline-primary">
                                        Se deconnecter
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row mb-1 text-muted">
                                <i class="fa-solid fa-network-wired fs-3 me-2"></i>
                                <span>{{ $device->device->ip }}</span>
                            </div>
                            <div class="d-flex flex-row mb-1 text-muted">
                                <i class="fa-solid fa-clock-four fs-3 me-2"></i>
                                <span>{{ $device->updated_at->format("d/m/Y à H:i") }}</span>
                            </div>
                            <div class="d-flex flex-row mb-1 text-muted">
                                <i class="fa-solid fa-user-secret fs-3 me-2"></i>
                                @if(\App\Service\Models\DeviceInfoService::deviceIsHijack($device->device->device_hijacked_at))
                                    <span class="text-danger">Votre appareil a été piraté le {{ $device->device->device_hijacked_at->format("d/m/Y à H:i") }}</span>
                                @else
                                    <span class="text-success">Votre appareil n'a pas été piraté</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
