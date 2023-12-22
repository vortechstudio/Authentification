<div class="d-flex flex-row justify-content-between align-items-center mb-10 p-5 rounded-3 bg-gray-300">
    <div class="fs-1 fw-bold">{{ $event->title }}</div>
    <div>
        @if($event->status == 'progress')
            <button x-on:click="$wire.nextStep({{ $event->id }})" class="btn btn-sm btn-icon btn-outline btn-outline-info me-2" data-bs-toggle="tooltip" title="Passer à l'étape suivante">
                <i class="fa-solid fa-angle-double-right fs-2"></i>
            </button>
        @endif
        <button x-on:click="$wire.startShow(0)" class="btn btn-sm btn-outline btn-icon btn-outline-danger" data-bs-toggle="tooltip" title="Fermer">
            <i class="fa-solid fa-xmark fs-2"></i>
        </button>
    </div>
</div>
<div class="rounded-3 bg-gray-300">
    <div class="row">
        <div class="col-md-4 col-sm-12 p-10">
            <div class="card shadow-lg">
                <img src="{{ App\Models\Social\Event::getSrcImage($event->id, 'wall') }}" alt="" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type:</span>
                            <span>{{ $event->type_event_string }}</span>
                        </div>
                        <div class="separator separator-2 border-gray-500 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Date de début:</span>
                            <span>{{ $event->start_at->format("d/m/Y") }}</span>
                        </div>
                        <div class="separator separator-2 border-gray-500 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Date de fin:</span>
                            <span>{{ $event->end_at->format("d/m/Y") }} <span class="text-muted">({{ $event->end_at->shortRelativeDiffForHumans() }})</span></span>
                        </div>
                        <div class="separator separator-2 border-gray-500 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Etat Actuel:</span>
                            <span>{!! $event->status_label !!}</span>
                        </div>
                        <div class="separator separator-2 border-gray-500 my-3"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Nombre de participant:</span>
                            <span class="badge badge-primary">{{ $event->participants()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12 p-10">
            <div class="rounded-3 bg-white p-5">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 mb-5">
                    <li class="nav-item">
                        <a href="#apercu" class="nav-link active" data-bs-toggle="tab">Aperçu de l'évènement</a>
                    </li>
                    @if($event->type_event == 'poll')
                        <li class="nav-item">
                            <a href="#poll" class="nav-link" data-bs-toggle="tab">Sondage</a>
                        </li>
                    @endif
                    @if($event->type_event == 'graphic')
                        <li class="nav-item">
                            <a href="#graphic" class="nav-link" data-bs-toggle="tab">Concours Graphique</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="apercu" role="tabpanel">
                        <img src="{{ App\Models\Social\Event::getSrcImage($event->id, 'header') }}" alt="" class="img-fluid w-100 h-auto rounded-3 mb-5">
                        <div class="fst-italic mb-2">{!! $event->synopsis !!}</div>
                        {!! $event->content !!}
                    </div>
                    @if($event->type_event == 'poll')
                        <div class="tab-pane fade" id="poll" role="tabpanel">
                            @if(!$event->poll()->exists())
                            <form action="" class="mb-5" x-on:submit="$wire.addPoll({{ $event }})">
                                <div class="card shadow-lg">
                                    <div class="card-header">
                                        <div class="card-title">Sondage de l'évènement</div>
                                        <div class="card-toolbar">
                                            <x-form.button />
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <x-form.input
                                            name="question"
                                            label=""
                                            no-label="true"
                                            placeholder="La question du sondage"
                                            :value="$event->poll->question"
                                            required="true" />
                                    </div>
                                </div>
                            </form>
                            @endif
                            @if($event->poll()->exists())
                                <livewire:admin.social.event-poll-response :poll="$event->poll" />
                            @endif
                        </div>
                    @endif
                    @if($event->type_event == 'graphic')
                        <div class="tab-pane fade" id="graphic" role="tabpanel">
                            ...
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
