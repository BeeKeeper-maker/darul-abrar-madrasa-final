@props([
    'title' => null,
    'subtitle' => null,
    'footer' => null,
    'padding' => 'normal',
    'rounded' => 'lg',
    'shadow' => 'md',
    'bordered' => false,
    'headerBg' => false,
    'footerBg' => false,
    'headerBordered' => true,
    'footerBordered' => true,
    'bodyClass' => '',
])

@php
    $baseClasses = 'bg-white dark:bg-gray-800 overflow-hidden';
    
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        '2xl' => 'rounded-2xl',
        '3xl' => 'rounded-3xl',
        'full' => 'rounded-full',
    ];
    
    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
        '2xl' => 'shadow-2xl',
        'soft' => 'shadow-soft',
    ];
    
    $paddingClasses = [
        'none' => '',
        'tight' => 'p-3',
        'normal' => 'p-5',
        'loose' => 'p-6',
        'extra' => 'p-8',
    ];
    
    $borderClasses = $bordered ? 'border border-gray-200 dark:border-gray-700' : '';
    
    $cardClasses = $baseClasses . ' ' . 
                  ($roundedClasses[$rounded] ?? $roundedClasses['lg']) . ' ' . 
                  ($shadowClasses[$shadow] ?? $shadowClasses['md']) . ' ' . 
                  $borderClasses;
                  
    $headerClasses = 'flex justify-between items-center ' . 
                    ($headerBg ? 'bg-gray-50 dark:bg-gray-900 ' : '') . 
                    ($headerBordered ? 'border-b border-gray-200 dark:border-gray-700 ' : '') . 
                    ($paddingClasses[$padding] ?? $paddingClasses['normal']);
                    
    $bodyClasses = ($paddingClasses[$padding] ?? $paddingClasses['normal']) . ' ' . $bodyClass;
    
    $footerClasses = ($footerBg ? 'bg-gray-50 dark:bg-gray-900 ' : '') . 
                    ($footerBordered ? 'border-t border-gray-200 dark:border-gray-700 ' : '') . 
                    ($paddingClasses[$padding] ?? $paddingClasses['normal']);
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    @if ($title || $subtitle)
        <div class="{{ $headerClasses }}">
            <div>
                @if ($title)
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $title }}</h3>
                @endif
                
                @if ($subtitle)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
                @endif
            </div>
            
            @if (isset($headerActions))
                <div class="flex items-center space-x-2">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="{{ $bodyClasses }}">
        {{ $slot }}
    </div>
    
    @if ($footer || isset($footerContent))
        <div class="{{ $footerClasses }}">
            @if ($footer)
                {{ $footer }}
            @else
                {{ $footerContent }}
            @endif
        </div>
    @endif
</div>