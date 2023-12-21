<div class="d-flex flex-row justify-content-between align-items-center mb-10 p-5 rounded-3 bg-gray-300">
    <div class="fs-1 fw-bold">Edition de l'évènement: {{ $event->title }}</div>
    <div>
        <button x-on:click="$wire.startEdit(0)" class="btn btn-sm btn-outline btn-icon btn-outline-danger">
            <i class="fa-solid fa-xmark fs-2"></i>
        </button>
    </div>
</div>
