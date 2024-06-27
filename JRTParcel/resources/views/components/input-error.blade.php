@props(['messages'])

@php
    $messages = is_array($messages) ? new \Illuminate\Support\MessageBag($messages) : $messages;
@endphp

@if ($messages->any())
<ul {{ $attributes->merge(['class' => 'w-2/4 text-sm text-red-500 bg-red-100 border-l-4 border-red-400 hover:border-red-700 hover:text-red-700 p-2']) }}>
        @foreach ($messages->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif