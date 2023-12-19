@if($type == 'simple')
    <div class="mb-10">
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <textarea
            class="form-control {{ $class }} @error("$name") is-invalid @enderror"
            wire:model="{{ $name }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
            value="{{ $value }}"
            {{ $required ? 'required': '' }}>{{ $value }}</textarea>

    </div>
@endif

@if($type == 'ckeditor')
    <div class="mb-10">
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <div wire:ignore>
            <textarea
                class="form-control {{ $class }} @error("$name") is-invalid @enderror"
                wire:model.prevent="{{ $name }}"
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
                value="{{ $value }}"
            {{ $required ? 'required': '' }}>{{ $value }}</textarea>
        </div>

    </div>
    @push('scripts')
        <script src="{{ asset('/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
        <script type="text/javascript">
            ClassicEditor
                .create(document.querySelector('#{{ $name }}'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set("{{ $name }}", editor.getData())
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>

    @endpush
@endif
