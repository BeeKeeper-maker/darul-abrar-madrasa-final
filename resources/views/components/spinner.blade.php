@props([
    'size' => 'md',
    'variant' => 'primary',
    'type' => 'border', // Options: 'border', 'dots', 'grow'
    'label' => 'Loading...',
    'showLabel' => false,
])

@php
    $sizeClasses = [
        'xs' => 'h-3 w-3',
        'sm' => 'h-4 w-4',
        'md' => 'h-6 w-6',
        'lg' => 'h-8 w-8',
        'xl' => 'h-10 w-10',
        '2xl' => 'h-12 w-12',
    ];
    
    $variantClasses = [
        'primary' => 'text-primary-600 dark:text-primary-500',
        'secondary' => 'text-secondary-600 dark:text-secondary-500',
        'success' => 'text-success-600 dark:text-success-500',
        'danger' => 'text-danger-600 dark:text-danger-500',
        'warning' => 'text-warning-600 dark:text-warning-500',
        'info' => 'text-info-600 dark:text-info-500',
        'light' => 'text-gray-200 dark:text-gray-300',
        'dark' => 'text-gray-800 dark:text-gray-600',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center']) }} role="status">
    @if ($type === 'border')
        <div class="{{ $sizeClass }} {{ $variantClass }} animate-spin">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    @elseif ($type === 'dots')
        <div class="flex space-x-1 {{ $variantClass }}">
            <div class="animate-bounce delay-0 {{ $sizeClasses['xs'] }} rounded-full bg-current"></div>
            <div class="animate-bounce delay-150 {{ $sizeClasses['xs'] }} rounded-full bg-current"></div>
            <div class="animate-bounce delay-300 {{ $sizeClasses['xs'] }} rounded-full bg-current"></div>
        </div>
    @elseif ($type === 'grow')
        <div class="flex space-x-1 {{ $variantClass }}">
            <div class="animate-pulse {{ $sizeClass }} rounded-full bg-current"></div>
        </div>
    @endif
    
    @if ($showLabel)
        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
    @else
        <span class="sr-only">{{ $label }}</span>
    @endif
</div>

<style>
    .delay-0 {
        animation-delay: 0ms;
    }
    .delay-150 {
        animation-delay: 150ms;
    }
    .delay-300 {
        animation-delay: 300ms;
    }
</style>