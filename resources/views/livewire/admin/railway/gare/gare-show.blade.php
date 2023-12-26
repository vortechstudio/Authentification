<div>
    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="card-title">
                        @if($gare->is_hub)
                            <span class="me-2" data-bs-toggle="tooltip" data-bs-original-title="Est un hub">
                                <i class="fa-solid fa-building-circle-check text-success fs-2x"></i>
                            </span>
                            {!! $gare->hub->is_active_label !!}
                        @endif
                    </div>
                    <div class="card-toolbar gap-3">
                        <a href="{{ route('admin.railway.gares') }}" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Retour">
                            <i class="fa-solid fa-arrow-circle-left"></i>
                        </a>
                        @if($gare->is_hub)
                            @if($gare->hub->visual == 'beta')
                                <button wire:click="production" class="btn btn-sm btn-icon btn-outline btn-outline-info" data-bs-toggle="tooltip" data-bs-original-title="Passer en production">
                                    <i class="fa-solid fa-boxes"></i>
                                </button>
                            @endif
                            @if($gare->hub->active)
                                <button wire:click="desactive" class="btn btn-sm btn-icon btn-outline btn-outline-danger" data-bs-toggle="tooltip" data-bs-original-title="Désactiver le hub">
                                    <i class="fa-solid fa-times-circle"></i>
                                </button>
                            @else
                                <button wire:click="active" class="btn btn-sm btn-icon btn-outline btn-outline-success" data-bs-toggle="tooltip" data-bs-original-title="Activer le hub">
                                    <i class="fa-solid fa-check-circle"></i>
                                </button>
                            @endif
                        @endif
                        <button wire:click="delete" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer la gare">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Nom</span>
                            <span>{{ $gare->name }}</span>
                        </div>
                        <div class="separator separator-2 border-gray-300 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type de gare</span>
                            <span>{{ $gare->type_gare_string }}</span>
                        </div>
                        <div class="separator separator-2 border-gray-300 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Coordonnées</span>
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <i class="fa-solid fa-map-marker me-1"></i>
                                    <span>{{ $gare->city }},</span>
                                    <span>{{ $gare->pays }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-2 border-gray-300 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Fréquence de base</span>
                            <span>{{ number_format(intval($gare->freq_base / 365), 0, ',', ' ') }} / par jour</span>
                        </div>
                        <div class="separator separator-2 border-gray-300 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">NB Habitant</span>
                            <span>{{ number_format($gare->habitant_city, 0, ',', ' ') }} </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer gap-2">
                    @foreach(json_decode($gare->equipements, true) as $equipement)
                        <i class="fa-solid {{ $gare->getTypeEquipementIconAttribute($equipement)  }} fs-2x text-success" data-bs-toggle="tooltip" data-bs-original-title="{{ $gare->getTypeEquipementStringAttribute($equipement) }}"></i>
                    @endforeach
                    <div class="separator separator-2 border-gray-300 my-3"></div>
                    @foreach(json_decode($gare->transports, true) as $transport)
                        <div class="symbol symbol-50px symbol-2by3 me-2">
                            <img src="{{ asset('/storage/icons/railway/transport/logo_'.$transport.'.svg') }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-lg" x-data="{card_title: 'Informations'}">
                <div class="card-header">
                    <div class="card-title" x-text="card_title"></div>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#info" x-on:click="card_title = 'Informations'">Informations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#map" x-on:click="card_title = 'Localisation'">Localisation</a>
                            </li>
                            @if($gare->is_hub)
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#lignes" x-on:click="card_title = 'Liste des lignes'">Liste des lignes</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">

                        </div>
                        <div class="tab-pane fade" id="map" role="tabpanel">

                        </div>
                        @if($gare->is_hub)
                        <div class="tab-pane fade" id="lignes" role="tabpanel">

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
