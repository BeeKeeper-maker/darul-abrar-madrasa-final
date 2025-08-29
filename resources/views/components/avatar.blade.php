@props([
    'src' => null,
    'alt' => '',
    'size' => 'md',
    'rounded' => 'full',
    'status' => null, // Options: 'online', 'offline', 'busy', 'away', null
    'statusPosition' => 'bottom-right', // Options: 'top-right', 'top-left', 'bottom-right', 'bottom-left'
    'initials' => null,
    'icon' => null,
])

@php
    $sizeClasses = [
        'xs' => 'h-6 w-6 text-xs',
        'sm' => 'h-8 w-8 text-sm',
        'md' => 'h-10 w-10 text-base',
        'lg' => 'h-12 w-12 text-lg',
        'xl' => 'h-16 w-16 text-xl',
        '2xl' => 'h-20 w-20 text-2xl',
    ];
    
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        'full' => 'rounded-full',
    ];
    
    $statusClasses = [
        'online' => 'bg-success-500',
        'offline' => 'bg-gray-500',
        'busy' => 'bg-danger-500',
        'away' => 'bg-warning-500',
    ];
    
    $statusPositionClasses = [
        'top-right' => 'top-0 right-0',
        'top-left' => 'top-0 left-0',
        'bottom-right' => 'bottom-0 right-0',
        'bottom-left' => 'bottom-0 left-0',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $roundedClass = $roundedClasses[$rounded] ?? $roundedClasses['full'];
    $statusClass = $statusClasses[$status] ?? '';
    $statusPositionClass = $statusPositionClasses[$statusPosition] ?? $statusPositionClasses['bottom-right'];
    
    // Status indicator size based on avatar size
    $statusSizeClasses = [
        'xs' => 'h-1.5 w-1.5',
        'sm' => 'h-2 w-2',
        'md' => 'h-2.5 w-2.5',
        'lg' => 'h-3 w-3',
        'xl' => 'h-4 w-4',
        '2xl' => 'h-5 w-5',
    ];
    $statusSizeClass = $statusSizeClasses[$size] ?? $statusSizeClasses['md'];
    
    // Calculate initials if provided
    $displayInitials = '';
    if ($initials) {
        $displayInitials = $initials;
    } elseif ($alt) {
        $words = explode(' ', $alt);
        if (count($words) >= 2) {
            $displayInitials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } elseif (count($words) === 1) {
            $displayInitials = strtoupper(substr($words[0], 0, 1));
        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'relative inline-block']) }}>
    @if ($src)
        <img 
            src="{{ $src }}" 
            alt="{{ $alt }}" 
            class="{{ $sizeClass }} {{ $roundedClass }} object-cover"
        >
    @elseif ($icon)
        <div class="{{ $sizeClass }} {{ $roundedClass }} flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            <x-dynamic-component :component="$icon" class="h-1/2 w-1/2" />
        </div>
    @else
        <div class="{{ $sizeClass }} {{ $roundedClass }} flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            {{ $displayInitials }}
        </div>
    @endif
    
    @if ($status)
        <span class="absolute {{ $statusPositionClass }} block {{ $statusSizeClass }} {{ $roundedClasses['full'] }} {{ $statusClass }} ring-2 ring-white dark:ring-gray-800"></span>
    @endif
</div>