<div class="mb-10">
    @if(!$noLabel)
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    @if($selectType == 'select2')
        <select id="{{ $name }}" wire:model="{{ $name }}" class="form-select" data-control="select2" data-placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}">
            <option></option>
            @foreach($options as $option)
                <option value="{{ $option['id'] }}">{{ $option['value'] }}</option>
            @endforeach
        </select>
    @elseif($selectType == 'selectpicker')
        <select id="{{ $name }}" wire:model="{{ $name }}" class="form-select selectpicker" data-placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}">
            <option></option>
            @foreach($options as $option)
                <option value="{{ $option['id'] }}">{{ $option['value'] }}</option>
            @endforeach
        </select>
    @else
        <select id="{{ $name }}" wire:model="{{ $name }}" class="form-select">
            <option>{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}</option>
            @foreach($options as $option)
                <option value="{{ $option['id'] }}">{{ $option['value'] }}</option>
            @endforeach
        </select>
    @endif
</div>
