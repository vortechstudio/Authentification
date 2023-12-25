<div>
    <div class="row">
        <div class="col-sm-12 col-lg-3">
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="card-title">&nbsp;</div>
                    <div class="card-toolbar gap-2">
                        <a href="{{ route('admin.railway.engines') }}" class="btn btn-sm btn-icon btn-outline btn-outline-primary" data-bs-toggle="tooltip" data-bs-original-title="Retour">
                            <i class="fa-solid fa-arrow-circle-left"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-icon btn-outline btn-outline-dark" data-bs-toggle="tooltip" data-bs-original-title="Editer">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        @if($engine->active)
                        <button class="btn btn-sm btn-icon btn-outline btn-outline-danger" wire:click="inactive" data-bs-toggle="tooltip" data-bs-original-title="Désactiver">
                            <i class="fa-solid fa-xmark-circle"></i>
                        </button>
                        @else
                            <button class="btn btn-sm btn-icon btn-outline btn-outline-success" wire:click="active" data-bs-toggle="tooltip" data-bs-original-title="Activer">
                                <i class="fa-solid fa-check-circle"></i>
                            </button>
                        @endif
                        @if($engine->visual == 'beta')
                            <button class="btn btn-sm btn-icon btn-outline btn-outline-info" wire:click="production" data-bs-toggle="tooltip" data-bs-original-title="Passer en production">
                                <i class="fa-solid fa-boxes"></i>
                            </button>
                        @endif
                        <button wire:click="delete" wire:confirm="Voulez-vous supprimer ce matériel roulant ?" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-original-title="Supprimer">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type de Transport</span>
                            <span>{!! $engine->type_transport_string !!}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type de Matériel</span>
                            <span>{!! $engine->type_train_string !!}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Energie utilisé</span>
                            <span>{!! $engine->type_energy_string !!}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Status</span>
                            <span>{!! $engine->active_label !!}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Disponible dans le jeux</span>
                            <span>{!! $engine->in_game_label !!}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Disponible dans la boutique</span>
                            <span>{!! $engine->in_shop_label !!}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Disponibilité</span>
                            <span>{!! $engine->visual_label !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9">
            <div class="rounded-3 shadow-lg bg-white p-5 mb-10">
                <div class="d-flex flex-wrap justify-content-center align-items-baseline w-1200px scroll scroll-x">
                    @if($engine->type_train == 'automotrice')
                        @for($i=0; $i <= $engine->technical->nb_wagon -1; $i++)
                            <img src="{{ asset("/storage/engines/automotrice/{$engine->slug}-{$i}.gif") }}" alt="">
                        @endfor
                    @else
                        <img src="{{ asset("/storage/engines/{$engine->type_train}/{$engine->slug}.gif") }}" alt="">
                    @endif
                </div>
            </div>
            <div class="card shadow-lg" x-data="{card_title: 'Technique'}">
                <div class="card-header bg-bluegrey-600">
                    <div class="card-title text-white fs-2 fw-semibold" x-text="card_title"></div>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#technical" x-on:click="card_title = 'Technique'">Information Technique</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#gestion" x-on:click="card_title = 'Gestion & Tarifs'">Gestion & Tarifs</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="technical" role="tabpanel">
                            <table class="table table-rounded border border-gray-300 gap-5 gy-5 gs-5">
                                <tbody>
                                    <tr class="border-bottom border-gray-300">
                                        <td class="border-right-1">Essieux</td>
                                        <td>{{ $engine->technical->essieux }}</td>
                                    </tr>
                                    <tr class="border-bottom border-gray-300">
                                        <td class="border-right-1">Vitesse Maximal</td>
                                        <td>{{ $engine->technical->velocity }} Km/h</td>
                                    </tr>
                                    <tr class="border-bottom border-gray-300">
                                        <td class="border-right-1">Durée de la maintenance</td>
                                        <td>{{ $engine->duration_maintenance->format("H:i:s") }}</td>
                                    </tr>
                                    @if($engine->type_train == 'automotrice')
                                    <tr class="border-bottom border-gray-300">
                                        <td class="border-right-1">Nombre de voitures</td>
                                        <td>{{ $engine->technical->nb_wagon }}</td>
                                    </tr>
                                    @endif
                                    <tr class="border-bottom border-gray-300">
                                        <td class="border-right-1">Type de motorisation</td>
                                        <td>{{ \App\Models\Railway\Engine::selectorTypeMotor($engine->technical->type_motor) }}</td>
                                    </tr>
                                    <tr class="border-bottom border-gray-300">
                                        <td class="border-right-1">Type de marchandises</td>
                                        <td>{{ \App\Models\Railway\Engine::selectorTypeMarchandise($engine->technical->type_marchandise) }}</td>
                                    </tr>
                                    @if($engine->technical->type_marchandise)
                                        <tr class="border-bottom border-gray-300">
                                            <td class="border-right-1">Capacité</td>
                                            <td>{{ $engine->technical->nb_marchandise }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="gestion" role="tabpanel">
                            <table class="table table-rounded border border-gray-300 gap-5 gy-5 gs-5">
                                <tbody>
                                    @if($engine->in_shop)
                                        <tr class="border-bottom border-gray-300">
                                            <td class="border-right-1">Type de Monnaie</td>
                                            <td>{{ \App\Models\Railway\Engine::selectorMoneyShop($engine->money_shop) }}</td>
                                        </tr>
                                        <tr class="border-bottom border-gray-300">
                                            <td class="border-right-1">Prix en boutique</td>
                                            <td>{{ $engine->price_shop }}</td>
                                        </tr>
                                    @endif
                                        <tr class="border-bottom border-gray-300">
                                            <td class="border-right-1">Prix à l'achat</td>
                                            <td>{{ eur($engine->tarif->price_achat) }}</td>
                                        </tr>
                                        <tr class="border-bottom border-gray-300">
                                            <td class="border-right-1">Prix de la maintenance</td>
                                            <td>{{ eur($engine->tarif->price_maintenance) }} / par heure</td>
                                        </tr>
                                        <tr class="border-bottom border-gray-300">
                                            <td class="border-right-1">Prix à la location</td>
                                            <td>{{ eur($engine->tarif->price_location) }} / par jour</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
