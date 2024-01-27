<div>
    <form wire:submit="store">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa-solid fa-file-text fs-1 me-3"></i>
                    <span>Création d'une page</span>
                </div>
                <div class="card-toolbar">
                    <button class="btn btn-primary" wire:loading.attr="data-kt-indicator" wire:loading.attr="disabled">
                        <span class="indicator-label">
                            Créer la page
                        </span>
                        <span class="indicator-progress">
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
                            no-label="true"
                            class="form-control-lg"
                            required="true" />
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select class="form-select" wire:model="parent_id">
                            @foreach(\App\Models\Cms::all() as $page)
                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <x-form.checkbox
                            name="published"
                            label="Publié la page" />
                    </div>
                </div>
                <div class="mb-10">
                    <button type="button" class="btn btn-light mr-2 save-draft disabled">Save Draft</button>
                    <textarea
                        class="form-control"
                        id="content"
                        wire:model="content"
                        name="content"
                        placeholder="Contenue de la page"
                        required>{{ $content }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script src="{{ asset('/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#content',
            menubar : false,
            visual: false,
            height:560,
            inline_styles : true,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table directionality emoticons template paste fullpage code legacyoutput"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage | forecolor backcolor emoticons | preview | code",
            fullpage_default_encoding: "UTF-8",
            fullpage_default_doctype: "<!DOCTYPE html>",
            init_instance_callback: function (editor)
            {
                editor.on('Change', function (e) {
                    if ($('.save-draft').hasClass('disabled')){
                        $('.save-draft').removeClass('disabled').text('Save Draft');
                    }
                });

                if (localStorage.getItem(templateID) !== null) {
                    editor.setContent(localStorage.getItem(templateID));
                }

                setTimeout(function(){
                    editor.execCommand("mceRepaint");
                }, 2000);
            }
        })
    </script>

@endpush
