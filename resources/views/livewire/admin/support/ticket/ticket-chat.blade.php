<div>
    @if($responses->count() > 0)
        <div class="card-body scroll-y me-n5 h-300px h-lg-auto" wire:poll.keep-alive>
            @foreach($responses as $response)
                <div class="d-flex {{ $response->user_id != auth()->id() ? 'justify-content-start' : 'justify-content-end' }} mb-10">
                    <div class="d-flex flex-column align-items-{{ $response->user_id != auth()->id() ? 'start' : 'end' }}">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle">
                                <img alt="Pic" src="{{ $response->user->avatar }}" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Details-->
                            <div class="ms-3">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $response->user->name }}</a>
                                <span class="text-muted fs-7 mb-1">{{ $response->created_at->longRelativeDiffForHumans() }}</span>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::User-->
                        <!--begin::Text-->
                        <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">{!! $response->message !!}</div>
                        @if($response->read_at)
                            <div class="pt-0 fs-8">
                                <i class="fa-solid fa-check fs-8" data-bs-toggle="tooltip" data-bs-original-title="Vu"></i>
                            </div>
                        @endif
                        <!--end::Text-->
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-body">
            <x-base.is-null
                text="Aucune réponse pour le moment" />
        </div>
    @endif
</div>
