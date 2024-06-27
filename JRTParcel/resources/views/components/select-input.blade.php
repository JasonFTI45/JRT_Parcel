@props(['id', 'name', 'label', 'options' => [], 'required' => false, 'selected' => ''])

<div>
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }} {{ $required ? 'required' : '' }}>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $text }}</option>
        @endforeach
    </select>
</div>