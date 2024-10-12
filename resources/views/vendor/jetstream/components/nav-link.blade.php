@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex dark:text-gray-300 items-center px-1 pt-1 border-indigo-400 text-base font-medium leading-5 text-slate-700 focus:outline-none focus:border-indigo-700 transition font-bold hover:border-4 border-b'
            : 'inline-flex dark:text-gray-100 items-center px-1 pt-1 border-transparent text-base font-medium leading-5 text-slate-700 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition font-bold hover:border-4 border-b';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
