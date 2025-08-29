@props([
    'type' => 'line', // Options: 'line', 'circle', 'rectangle', 'card', 'avatar', 'text', 'table'
    'lines' => 3,
    'width' => null,
    'height' => null,
    'rounded' => 'md',
    'animate' => true,
])

@php
    $baseClasses = 'bg-gray-200 dark:bg-gray-700';
    
    $animateClass = $animate ? 'animate-pulse' : '';
    
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        'full' => 'rounded-full',
    ];
    
    $roundedClass = $roundedClasses[$rounded] ?? $roundedClasses['md'];
    
    $widthClass = $width ? "w-{$width}" : 'w-full';
    $heightClass = $height ? "h-{$height}" : '';
@endphp

<div {{ $attributes->merge(['class' => $animateClass]) }}>
    @switch($type)
        @case('circle')
            <div class="{{ $baseClasses }} {{ $roundedClasses['full'] }} {{ $width ? "w-{$width}" : 'w-12' }} {{ $height ? "h-{$height}" : 'h-12' }}"></div>
            @break
            
        @case('rectangle')
            <div class="{{ $baseClasses }} {{ $roundedClass }} {{ $widthClass }} {{ $height ? "h-{$height}" : 'h-24' }}"></div>
            @break
            
        @case('card')
            <div class="{{ $baseClasses }} {{ $roundedClass }} {{ $widthClass }} overflow-hidden">
                <div class="h-48 {{ $baseClasses }}"></div>
                <div class="p-4 space-y-3">
                    <div class="{{ $baseClasses }} h-4 w-3/4 {{ $roundedClass }}"></div>
                    <div class="{{ $baseClasses }} h-3 {{ $roundedClass }}"></div>
                    <div class="{{ $baseClasses }} h-3 w-5/6 {{ $roundedClass }}"></div>
                    <div class="flex justify-between pt-2">
                        <div class="{{ $baseClasses }} h-8 w-20 {{ $roundedClass }}"></div>
                        <div class="{{ $baseClasses }} h-8 w-20 {{ $roundedClass }}"></div>
                    </div>
                </div>
            </div>
            @break
            
        @case('avatar')
            <div class="flex items-center space-x-3">
                <div class="{{ $baseClasses }} {{ $roundedClasses['full'] }} {{ $width ? "w-{$width}" : 'w-12' }} {{ $height ? "h-{$height}" : 'h-12' }}"></div>
                <div class="space-y-2">
                    <div class="{{ $baseClasses }} h-4 w-32 {{ $roundedClass }}"></div>
                    <div class="{{ $baseClasses }} h-3 w-24 {{ $roundedClass }}"></div>
                </div>
            </div>
            @break
            
        @case('text')
            <div class="space-y-2 {{ $widthClass }}">
                <div class="{{ $baseClasses }} h-4 w-full {{ $roundedClass }}"></div>
                <div class="{{ $baseClasses }} h-4 w-11/12 {{ $roundedClass }}"></div>
                <div class="{{ $baseClasses }} h-4 w-4/5 {{ $roundedClass }}"></div>
                <div class="{{ $baseClasses }} h-4 w-full {{ $roundedClass }}"></div>
                <div class="{{ $baseClasses }} h-4 w-9/12 {{ $roundedClass }}"></div>
            </div>
            @break
            
        @case('table')
            <div class="{{ $widthClass }} overflow-hidden {{ $roundedClass }}">
                <div class="flex {{ $baseClasses }} h-10 mb-2">
                    <div class="w-1/4 border-r border-gray-300 dark:border-gray-600"></div>
                    <div class="w-1/4 border-r border-gray-300 dark:border-gray-600"></div>
                    <div class="w-1/4 border-r border-gray-300 dark:border-gray-600"></div>
                    <div class="w-1/4"></div>
                </div>
                @for ($i = 0; $i < 5; $i++)
                    <div class="flex {{ $baseClasses }} h-8 mb-1 opacity-{{ 90 - ($i * 10) }}">
                        <div class="w-1/4 border-r border-gray-300 dark:border-gray-600"></div>
                        <div class="w-1/4 border-r border-gray-300 dark:border-gray-600"></div>
                        <div class="w-1/4 border-r border-gray-300 dark:border-gray-600"></div>
                        <div class="w-1/4"></div>
                    </div>
                @endfor
            </div>
            @break
            
        @default
            <div class="space-y-2 {{ $widthClass }}">
                @for ($i = 0; $i < $lines; $i++)
                    <div class="{{ $baseClasses }} h-4 {{ $roundedClass }} {{ $i === $lines - 1 ? 'w-4/5' : 'w-full' }}"></div>
                @endfor
            </div>
    @endswitch
</div>