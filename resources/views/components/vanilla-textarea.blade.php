@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['rows' => '1', 'class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>{{ isset($attributes['value']) ? $attributes['value'] : $slot }}</textarea>
