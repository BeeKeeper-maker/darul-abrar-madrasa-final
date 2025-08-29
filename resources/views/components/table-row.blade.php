@props([
    'striped' => true,
    'hover' => true,
])

@php
    $baseClasses = 'bg-white dark:bg-gray-800';
    $stripedClasses = $striped ? 'even:bg-gray-50 dark:even:bg-gray-700' : '';
    $hoverClasses = $hover ? 'hover:bg-gray-100 dark:hover:bg-gray-700' : '';
@endphp

<tr {{ $attributes->merge(['class' => "$baseClasses $stripedClasses $hoverClasses"]) }}>
    {{ $slot }}
</tr>