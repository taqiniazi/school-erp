﻿@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-body'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'dropdown-menu-start';
        break;
    case 'top':
        $alignmentClasses = 'dropup'; // Not exact mapping but close
        break;
    case 'right':
    default:
        $alignmentClasses = 'dropdown-menu-end';
        break;
}
@endphp

<div class="dropdown">
    <div data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu {{ $alignmentClasses }} {{ $contentClasses }}">
        {{ $content }}
    </div>
</div>

