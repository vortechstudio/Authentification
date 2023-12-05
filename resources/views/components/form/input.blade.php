<div class="mb-10">
    @if(!$noLabel)
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" wire:model="{{ $name }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}" class="form-control {{ $class }}" value="{{ $value }}" {{ $required ? 'required': '' }}>
    @error("$name")
        <span class="text-danger error">{{ $message }}</span>
    @enderror
</div>
