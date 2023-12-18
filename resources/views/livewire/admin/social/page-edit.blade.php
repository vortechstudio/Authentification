<div>
    <form wire:submit.prevent="update">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa-solid fa-file-text fs-1 me-3"></i>
                    <span>Edition de la page: <strong>{{ $page->title }}</strong></span>
                </div>
                <div class="card-toolbar">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.class="d-none">Valider</span>
                        <span class="d-none" wire:loading.class.remove="d-none">
                            Veuillez patienter... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <x-form.input
                            name="title"
                            placeholder="Titre de la page"
                            label=""
                            wire:model.defer="title"
                            :value="$page->title"
                            no-label="true"
                            class="form-control-lg"
                            required="true" />
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select class="form-select" wire:model.defer="parent_id">
                            <option value=""></option>
                            @foreach(\App\Models\Cms::all() as $page)
                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <x-form.checkbox
                            name="published"
                            wire:model.defer="published"
                            label="Publié la page" />
                    </div>
                </div>
                <div class="mb-10">
                    <textarea
                        class="form-control"
                        id="content"
                        wire:model.defer="content"
                        name="content"
                        placeholder="Contenue de la page"
                        required>{{ $page->content }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script src="{{ asset('/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {

            })
            .catch(error => {
                console.error(error);
            });
    </script>

@endpush
