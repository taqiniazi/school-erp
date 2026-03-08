@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active fw-bold text-primary border-bottom border-2 border-primary'
            : 'nav-link text-secondary';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>