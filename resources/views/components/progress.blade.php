@props([
    'value' => 0,
    'max' => 100,
    'height' => 'md',
    'variant' => 'primary',
    'striped' => false,
    'animated' => false,
    'showLabel' => false,
    'labelPosition' => 'inside', // Options: 'inside', 'outside'
])

@php
    $percentage = min(100, max(0, ($value / $max) * 100));
    
    $heightClasses = [
        'xs' => 'h-1',
        'sm' => 'h-1.5',
        'md' => 'h-2.5',
        'lg' => 'h-4',
        'xl' => 'h-6',
    ];
    
    $variantClasses = [
        'primary' => 'bg-primary-600 dark:bg-primary-500',
        'secondary' => 'bg-secondary-600 dark:bg-secondary-500',
        'success' => 'bg-success-600 dark:bg-success-500',
        'danger' => 'bg-danger-600 dark:bg-danger-500',
        'warning' => 'bg-warning-600 dark:bg-warning-500',
        'info' => 'bg-info-600 dark:bg-info-500',
    ];
    
    $stripedClass = $striped ? 'bg-gradient-to-r from-transparent via-white/20 to-transparent bg-[length:1rem_1rem]' : '';
    $animatedClass = $animated && $striped ? 'animate-progress-stripes' : '';
    
    $heightClass = $heightClasses[$height] ?? $heightClasses['md'];
    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
    
    $labelClass = $labelPosition === 'inside' 
        ? 'absolute inset-0 flex items-center justify-center text-xs font-medium text-white'
        : 'text-xs font-medium text-gray-700 dark:text-gray-300 mt-1';
@endphp

<div {{ $attributes->merge(['class' => 'w-full bg-gray-200 rounded-full dark:bg-gray-700']) }}>
    <div class="relative">
        <div 
            class="rounded-full {{ $heightClass }} {{ $variantClass }} {{ $stripedClass }} {{ $animatedClass }}"
            style="width: {{ $percentage }}%"
            role="progressbar" 
            aria-valuenow="{{ $value }}" 
            aria-valuemin="0" 
            aria-valuemax="{{ $max }}"
        ></div>
        
        @if ($showLabel && $labelPosition === 'inside' && $percentage >= 25)
            <div class="{{ $labelClass }}">
                {{ $percentage }}%
            </div>
        @endif
    </div>
    
    @if ($showLabel && $labelPosition === 'outside')
        <div class="{{ $labelClass }}">
            {{ $percentage }}%
        </div>
    @endif
</div>

@if ($animated && $striped)
    <style>
        @keyframes progress-stripes {
            0% { background-position: 1rem 0; }
            100% { background-position: 0 0; }
        }
        .animate-progress-stripes {
            animation: progress-stripes 1s linear infinite;
        }
    </style>
@endif