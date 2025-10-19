<a {{ $attributes->merge([
    'class' => 'block w-full px-4 py-2 text-start text-sm text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 rounded-md'
]) }}>
    {{ $slot }}
</a>
