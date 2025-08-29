@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'rounded' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
    'fullWidth' => false,
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variantClasses = [
        'primary' => 'bg-primary-600 hover:bg-primary-700 text-white focus:ring-primary-500',
        'secondary' => 'bg-secondary-600 hover:bg-secondary-700 text-white focus:ring-secondary-500',
        'success' => 'bg-success-600 hover:bg-success-700 text-white focus:ring-success-500',
        'danger' => 'bg-danger-600 hover:bg-danger-700 text-white focus:ring-danger-500',
        'warning' => 'bg-warning-600 hover:bg-warning-700 text-white focus:ring-warning-500',
        'info' => 'bg-info-600 hover:bg-info-700 text-white focus:ring-info-500',
        'light' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-300',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white focus:ring-gray-700',
        'outline-primary' => 'border border-primary-600 text-primary-600 hover:bg-primary-50 focus:ring-primary-500',
        'outline-secondary' => 'border border-secondary-600 text-secondary-600 hover:bg-secondary-50 focus:ring-secondary-500',
        'outline-success' => 'border border-success-600 text-success-600 hover:bg-success-50 focus:ring-success-500',
        'outline-danger' => 'border border-danger-600 text-danger-600 hover:bg-danger-50 focus:ring-danger-500',
        'outline-warning' => 'border border-warning-600 text-warning-600 hover:bg-warning-50 focus:ring-warning-500',
        'outline-info' => 'border border-info-600 text-info-600 hover:bg-info-50 focus:ring-info-500',
        'outline-light' => 'border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-gray-300',
        'outline-dark' => 'border border-gray-800 text-gray-800 hover:bg-gray-100 focus:ring-gray-700',
        'link' => 'text-primary-600 hover:text-primary-700 underline hover:no-underline focus:ring-primary-500',
    ];
    
    $sizeClasses = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];
    
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        'full' => 'rounded-full',
    ];
    
    $disabledClasses = 'opacity-50 cursor-not-allowed';
    $fullWidthClasses = 'w-full';
    
    $classes = $baseClasses . ' ' . 
               ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . 
               ($sizeClasses[$size] ?? $sizeClasses['md']) . ' ' . 
               ($roundedClasses[$rounded] ?? $roundedClasses['md']) . ' ' . 
               ($disabled ? $disabledClasses : '') . ' ' . 
               ($fullWidth ? $fullWidthClasses : '');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <span class="mr-2">
                <x-dynamic-component :component="$icon" class="h-5 w-5" />
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="ml-2">
                <x-dynamic-component :component="$icon" class="h-5 w-5" />
            </span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes, 'disabled' => $disabled]) }}>
        @if ($icon && $iconPosition === 'left')
            <span class="mr-2">
                <x-dynamic-component :component="$icon" class="h-5 w-5" />
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="ml-2">
                <x-dynamic-component :component="$icon" class="h-5 w-5" />
            </span>
        @endif
    </button>
@endif