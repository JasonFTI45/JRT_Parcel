    @props(['name', 'value' => '', 'min' => '', 'max' => '', 'step' => ''])

<input type="number" name="{{ $name }}" value="{{ $value }}" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>