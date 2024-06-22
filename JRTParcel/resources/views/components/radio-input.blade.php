@props(['name', 'value', 'label' => '', 'checked' => false])

<div>
    <input class="mr-1" type="radio" id="{{ $name }}_{{ $value }}" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }} {{ $attributes }}>
    <label for="{{ $name }}_{{ $value }}">{{ $label }}</label>
</div>