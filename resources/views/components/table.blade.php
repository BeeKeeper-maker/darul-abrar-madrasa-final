@props([
    'headers' => [],
    'striped' => true,
    'hover' => true,
    'bordered' => false,
    'small' => false,
    'responsive' => true,
    'footer' => null,
])

@php
    $baseClasses = 'min-w-full divide-y divide-gray-200 dark:divide-gray-700';
    $borderedClass = $bordered ? 'border border-gray-200 dark:border-gray-700' : '';
    $responsiveClass = $responsive ? 'overflow-x-auto' : '';
    
    $headerClasses = 'px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider';
    $smallHeaderClasses = $small ? 'px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider' : $headerClasses;
    
    $cellClasses = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200';
    $smallCellClasses = $small ? 'px-4 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-gray-200' : $cellClasses;
@endphp

<div {{ $attributes->merge(['class' => $responsiveClass]) }}>
    <table class="{{ $baseClasses }} {{ $borderedClass }}">
        @if (count($headers) > 0)
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="{{ $smallHeaderClasses }}">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif
        
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </tbody>
        
        @if ($footer)
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                {{ $footer }}
            </tfoot>
        @endif
    </table>
</div>