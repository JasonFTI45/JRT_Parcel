@props(['messages'])

@if ($messages->any())
<ul {{ $attributes->merge(['class' => 'w-2/4 text-sm text-red-500 bg-red-100 border-l-4 border-red-400 hover:border-red-700 hover:text-red-700 p-4']) }}>
        @foreach ($messages->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif