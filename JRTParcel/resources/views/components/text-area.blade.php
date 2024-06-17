@props(['name', 'value' => '', 'rows' => 3])

<textarea name="{{ $name }}" rows="{{ $rows }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $value }}</textarea>