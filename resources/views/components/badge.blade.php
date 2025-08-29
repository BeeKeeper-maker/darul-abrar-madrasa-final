@props([
    'variant' => 'primary',
    'size' => 'md',
    'rounded' => 'full',
    'icon' => null,
    'iconPosition' => 'left',
    'dot' => false,
])

@php
    $baseClasses = 'inline-flex items-center font-medium';
    
    $variantClasses = [
        'primary' => 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300',
        'secondary' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-900 dark:text-secondary-300',
        'success' => 'bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-300',
        'danger' => 'bg-danger-100 text-danger-800 dark:bg-danger-900 dark:text-danger-300',
        'warning' => 'bg-warning-100 text-warning-800 dark:bg-warning-900 dark:text-warning-300',
        'info' => 'bg-info-100 text-info-800 dark:bg-info-900 dark:text-info-300',
        'light' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'dark' => 'bg-gray-800 text-gray-100 dark:bg-gray-900 dark:text-gray-100',
        'outline-primary' => 'border border-primary-500 text-primary-700 dark:text-primary-400',
        'outline-secondary' => 'border border-secondary-500 text-secondary-700 dark:text-secondary-400',
        'outline-success' => 'border border-success-500 text-success-700 dark:text-success-400',
        'outline-danger' => 'border border-danger-500 text-danger-700 dark:text-danger-400',
        'outline-warning' => 'border border-warning-500 text-warning-700 dark:text-warning-400',
        'outline-info' => 'border border-info-500 text-info-700 dark:text-info-400',
        'outline-light' => 'border border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-400',
        'outline-dark' => 'border border-gray-700 text-gray-800 dark:border-gray-800 dark:text-gray-300',
        // Legacy color mappings for backward compatibility
        'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'red' => 'bg-danger-100 text-danger-800 dark:bg-danger-900 dark:text-danger-300',
        'yellow' => 'bg-warning-100 text-warning-800 dark:bg-warning-900 dark:text-warning-300',
        'green' => 'bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-300',
        'blue' => 'bg-info-100 text-info-800 dark:bg-info-900 dark:text-info-300',
        'indigo' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-900 dark:text-secondary-300',
        'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
        'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
    ];
    
    $sizeClasses = [
        'xs' => 'px-1.5 py-0.5 text-xs',
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-0.5 text-sm',
        'lg' => 'px-3 py-1 text-sm',
    ];
    
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full',
    ];
    
    // Support for both 'variant' and legacy 'color' prop
    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
    if (isset($attributes['color'])) {
        $color = $attributes['color'];
        $variantClass = $variantClasses[$color] ?? $variantClasses['gray'];
        $attributes = $attributes->except(['color']);
    }
    
    $classes = $baseClasses . ' ' . 
               $variantClass . ' ' . 
               ($sizeClasses[$size] ?? $sizeClasses['md']) . ' ' . 
               ($roundedClasses[$rounded] ?? $roundedClasses['full']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if ($dot)
        <span class="w-2 h-2 mr-1.5 rounded-full bg-current"></span>
    @endif
    
    @if ($icon && $iconPosition === 'left')
        <x-dynamic-component :component="$icon" class="w-3.5 h-3.5 mr-1" />
    @endif
    
    {{ $slot }}
    
    @if ($icon && $iconPosition === 'right')
        <x-dynamic-component :component="$icon" class="w-3.5 h-3.5 ml-1" />
    @endif
</span>