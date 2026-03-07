@props(['active', 'icon' => null])

@php
$classes = ($active ?? false)
            ? 'group flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-200 transition duration-150 ease-in-out'
            : 'group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="{{ $icon }} w-5 h-5 mr-3 text-center {{ ($active ?? false) ? 'text-indigo-600 dark:text-indigo-300' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"></i>
    @endif
    {{ $slot }}
</a>