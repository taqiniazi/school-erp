@props(['active'])

@php
$classes = ($active ?? false)
            ? 'd-block w-100 ps-3 pe-4 py-2 border-start border-4 border-primary text-primary bg-light text-decoration-none fw-medium'
            : 'd-block w-100 ps-3 pe-4 py-2 border-start border-4 border-transparent text-secondary text-decoration-none fw-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>