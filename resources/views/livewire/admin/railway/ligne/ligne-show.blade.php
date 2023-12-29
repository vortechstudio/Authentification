<div>
    <div class="card shadow-lg">
        <div class="card-header">
            <div class="card-title">
                <div class="gap-2">
                    <i class="fa-solid fa-train text-success fs-3"></i>
                    {{ $ligne->name }}
                    <i class="fa-solid fa-train text-danger fs-3"></i>
                </div>
            </div>
            <div class="card-toolbar gap-2">
                <a href="{{ route('admin.railway.lignes') }}" class="btn btn-sm btn-outline btn-outline-dark">
                    <i class="fa-solid fa-arrow-circle-left me-1"></i>
                    <span>Retour</span>
                </a>
                <a wire:click="$refresh" class="btn btn-sm btn-outline btn-outline-primary">
                    <i class="fa-solid fa-refresh me-1"></i>
                    <span>Rafraichir</span>
                </a>
                <button type="button" class="btn btn-sm btn-outline btn-outline-primary rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" >
                    Menu <i class="fa-solid fa-caret-down rotate-180 ms-3 me-0"></i>
                </button>
                <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200px mw-300px" data-kt-menu="true">
                    @if($ligne->active)
                        <div class="menu-item px-3">
                            <a href="#" wire:click="desactivate" class="menu-link text-danger px-3">
                                Désactiver la ligne
                            </a>
                        </div>
                    @else
                        <div class="menu-item px-3">
                            <a href="#" wire:click="activate" class="menu-link text-success px-3">
                                Activer la ligne
                            </a>
                        </div>
                    @endif
                    @if($ligne->visual == 'beta')
                        <div class="menu-item px-3">
                            <a href="#" wire:click="production" wire:confirm="Voulez-vous passer cette ligne en production ?" class="menu-link text-indigo-400 px-3">
                                Passer en production
                            </a>
                        </div>
                    @endif
                    <div class="menu-item px-3">
                        <a href="#" wire:click="calculateDistance" class="menu-link px-3">
                            Calculer la distance de la ligne
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" wire:click="calculatePrice" class="menu-link px-3">
                            Calculer le prix de la ligne
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" wire:click="delete({{ $ligne->id }})" wire:confirm="Voulez-vous supprimer définitivement cette ligne ?" class="menu-link text-danger px-3">
                            Supprimer la ligne
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center rounded-3 bg-white p-5">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row mt-3">
                            <div class="card card-flush bg-primary w-200px  me-3">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-3x">{{ $ligne->nb_station }}</div>
                                        <div class="fw-bold fs-6 text-gray-400">Stations</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-flush bg-info w-200px  me-3">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-3x">{{ $ligne->distance }}</div>
                                        <div class="fw-bold fs-6 text-gray-400">Km de trajet</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-flush bg-warning w-200px  text-inverse me-3">
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder fs-3x">{{ convertMinuteToHours($ligne->time_min) }}</div>
                                        <div class="fw-bold fs-6">Temps de trajet</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="fs-2tx fw-bolder">Prix: </span> <span class="fs-2x fw-bolder text-success">{{ eur($ligne->price) }}</span>
            </div>
            <div class="d-flex flex-column my-10 w-50 align-items-center mx-lg-20">
                @if($ligne->stations()->count() == 0)
                    <x-base.is-null />
                @else
                    @foreach($ligne->stations as $station)
                        <div class="d-flex flex-row align-items-center mb-2">
                            @if($ligne->start->name == $station->gare->name || $ligne->end->name == $station->gare->name)
                                <img src="/storage/icons/hub.png" class="w-45px me-3" alt="" />
                                <span class="fs-1 fw-bold {{ $ligne->start->name == $station->gare->name ? 'text-success' : '' }} {{ $ligne->end->name == $station->gare->name ? 'text-danger' : '' }}">{{ $station->gare->name }}</span>
                            @else
                                <img src="/storage/icons/train-passenger.png" class="w-20px me-3" alt="" />
                                <span class="fs-3 fw-bold">{{ $station->gare->name }}</span>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            <livewire:admin.railway.ligne.ligne-show-station :stations="$ligne->stations" :ligne="$ligne" />
        </div>
    </div>
</div>
