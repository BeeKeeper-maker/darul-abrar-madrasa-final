@props([
    'small' => false,
    'align' => 'left',
])

@php
    $baseClasses = 'whitespace-nowrap text-sm text-gray-900 dark:text-gray-200';
    $smallClasses = $small ? 'px-4 py-2 text-xs' : 'px-6 py-4';
    
    $alignmentClasses = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ];
    
    $alignClass = $alignmentClasses[$align] ?? $alignmentClasses['left'];
@endphp

<td {{ $attributes->merge(['class' => "$baseClasses $smallClasses $alignClass"]) }}>
    {{ $slot }}
</td>