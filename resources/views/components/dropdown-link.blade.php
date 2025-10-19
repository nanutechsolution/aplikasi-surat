@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2 text-start text-sm text-white bg-white/20 rounded-md transition'
            : 'block w-full px-4 py-2 text-start text-sm text-white/80 hover:bg-white/10 rounded-md transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
