@props([
    'text' => '',
    'position' => 'top', // Options: 'top', 'right', 'bottom', 'left'
    'color' => 'dark', // Options: 'dark', 'light', 'primary', 'secondary', 'success', 'danger', 'warning', 'info'
])

@php
    $positionClasses = [
        'top' => 'bottom-full left-1/2 transform -translate-x-1/2 -translate-y-1 mb-1',
        'right' => 'left-full top-1/2 transform translate-x-1 -translate-y-1/2 ml-1',
        'bottom' => 'top-full left-1/2 transform -translate-x-1/2 translate-y-1 mt-1',
        'left' => 'right-full top-1/2 transform -translate-x-1 -translate-y-1/2 mr-1',
    ];
    
    $arrowClasses = [
        'top' => 'bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full',
        'right' => 'left-0 top-1/2 transform -translate-y-1/2 -translate-x-full',
        'bottom' => 'top-0 left-1/2 transform -translate-x-1/2 -translate-y-full',
        'left' => 'right-0 top-1/2 transform -translate-y-1/2 translate-x-full',
    ];
    
    $colorClasses = [
        'dark' => 'bg-gray-900 text-white',
        'light' => 'bg-white text-gray-900 border border-gray-200',
        'primary' => 'bg-primary-600 text-white',
        'secondary' => 'bg-secondary-600 text-white',
        'success' => 'bg-success-600 text-white',
        'danger' => 'bg-danger-600 text-white',
        'warning' => 'bg-warning-600 text-white',
        'info' => 'bg-info-600 text-white',
    ];
    
    $arrowColorClasses = [
        'dark' => 'border-gray-900',
        'light' => 'border-white',
        'primary' => 'border-primary-600',
        'secondary' => 'border-secondary-600',
        'success' => 'border-success-600',
        'danger' => 'border-danger-600',
        'warning' => 'border-warning-600',
        'info' => 'border-info-600',
    ];
    
    $positionClass = $positionClasses[$position] ?? $positionClasses['top'];
    $arrowClass = $arrowClasses[$position] ?? $arrowClasses['top'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['dark'];
    $arrowColorClass = $arrowColorClasses[$color] ?? $arrowColorClasses['dark'];
    
    // Arrow direction classes
    $arrowDirectionClasses = [
        'top' => 'border-t-0 border-r-0',
        'right' => 'border-r-0 border-b-0',
        'bottom' => 'border-b-0 border-l-0',
        'left' => 'border-l-0 border-t-0',
    ];
    $arrowDirectionClass = $arrowDirectionClasses[$position] ?? $arrowDirectionClasses['top'];
@endphp

<div x-data="{ isVisible: false }" @mouseover="isVisible = true" @mouseleave="isVisible = false" class="relative inline-block">
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
    
    <div 
        x-show="isVisible" 
        x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 scale-95" 
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-100" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 px-3 py-2 text-sm font-medium rounded shadow-lg whitespace-nowrap {{ $positionClass }} {{ $colorClass }}"
        style="display: none;"
        role="tooltip"
    >
        {{ $text }}
        <div class="absolute w-2 h-2 transform rotate-45 border {{ $arrowDirectionClass }} {{ $arrowClass }} {{ $arrowColorClass }}"></div>
    </div>
</div>