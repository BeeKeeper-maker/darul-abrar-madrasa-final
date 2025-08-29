@props([
    'href' => '#',
    'icon' => null,
    'destructive' => false,
])

@php
    $baseClasses = 'block w-full px-4 py-2 text-left text-sm leading-5 focus:outline-none transition duration-150 ease-in-out';
    
    $variantClasses = $destructive
        ? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900 dark:hover:bg-opacity-20 focus:bg-red-50 dark:focus:bg-red-900 dark:focus:bg-opacity-20'
        : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:bg-gray-100 dark:focus:bg-gray-700';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}>
    <div class="flex items-center">
        @if ($icon)
            <x-dynamic-component :component="$icon" class="mr-2 h-4 w-4" />
        @endif
        {{ $slot }}
    </div>
</a>