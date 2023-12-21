<div class="d-flex flex-row justify-content-between align-items-center mb-10 p-5 rounded-3 bg-gray-300">
    <div class="fs-1 fw-bold">{{ $event->title }}</div>
    <div>
        <button x-on:click="$wire.startShow(0)" class="btn btn-sm btn-outline btn-icon btn-outline-danger">
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
                            <span >Type:</span>
                            <span>{{ $event->type_event_string }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12"></div>
    </div>
</div>
