@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-blue-500 text-start text-base font-medium text-blue-100 bg-blue-700
       focus:outline-none focus:text-white focus:bg-blue-800 focus:border-blue-400 transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-300
       hover:text-white hover:bg-blue-600 hover:border-blue-400
       focus:outline-none focus:text-white focus:bg-blue-700 focus:border-blue-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
