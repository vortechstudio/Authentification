<div x-data="{form_add_response: false}">
    <div class="card shadow-lg">
        <div class="card-header">
            <div class="card-title">Liste des réponses</div>
            <div class="card-toolbar">
                <button x-on:click="form_add_response = ! form_add_response" class="btn btn-sm btn-primary">
                    <div x-show="! form_add_response">
                        <i class="fa-solid fa-plus"></i>
                        Nouvelle réponse
                    </div>
                    <div x-show="form_add_response">
                        <i class="fa-solid fa-minus"></i>
                        Nouvelle réponse
                    </div>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="" x-show="form_add_response" wire:submit.prevent="addResponse" class="mb-5 bg-gray-400 p-5 rounded-2">
                @csrf
                <x-form.input
                    name="name"
                    label="Réponse"
                    required="true" />
                <div class="d-flex flex-end">
                    <x-form.button text-submit="Ajouter la réponse" />
                </div>
            </form>
            <span class="fw-bolder">Question:</span> {{ $poll->question }}
            <div class="d-flex flex-column">
                @foreach($poll->responses as $response)
                    <div class="d-flex align-items-center py-2">
                        <div class="d-flex align-items-center w-50">
                            <span class="bullet me-5"></span> {{ $response->name }}
                        </div>
                        <div class="flex-grow-1 h-8px mx-3 w-100 bg-gray-800 bg-opacity-50 rounded">
                            <div class="bg-primary rounded h-8px" role="progressbar" style="width: {{ $response->percent_with_count }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <button x-on:click="$wire.deleteResponse({{ $response->id }})" class="btn btn-flush btn-text-danger"><i class="fa-solid fa-trash text-danger"></i> </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
