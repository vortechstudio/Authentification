<div class="mb-10">
    @if(!$noLabel)
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? $label }}" class="form-control {{ $class }}" value="{{ $value }}" {{ $required ? 'required': '' }}>
</div>
