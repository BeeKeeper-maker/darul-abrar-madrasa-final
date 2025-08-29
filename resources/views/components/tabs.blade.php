@props([
    'tabs' => [],
    'activeTab' => 0,
    'variant' => 'underline', // Options: 'underline', 'pills', 'bordered'
])

@php
    $baseTabClasses = 'inline-block px-4 py-2 text-sm font-medium focus:outline-none';
    
    $variantClasses = [
        'underline' => [
            'tabs' => 'flex border-b border-gray-200 dark:border-gray-700',
            'tab' => 'border-b-2 border-transparent',
            'active' => 'text-primary-600 border-primary-600 dark:text-primary-500 dark:border-primary-500',
            'inactive' => 'text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600',
        ],
        'pills' => [
            'tabs' => 'flex space-x-2',
            'tab' => 'rounded-md',
            'active' => 'text-white bg-primary-600 dark:bg-primary-700',
            'inactive' => 'text-gray-500 bg-gray-100 hover:text-gray-700 hover:bg-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:text-gray-300 dark:hover:bg-gray-700',
        ],
        'bordered' => [
            'tabs' => 'flex',
            'tab' => 'border-t border-l border-r rounded-t-md',
            'active' => 'text-primary-600 bg-white border-gray-200 dark:text-primary-500 dark:bg-gray-800 dark:border-gray-700',
            'inactive' => 'text-gray-500 bg-gray-50 border-gray-100 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-900 dark:border-gray-800 dark:hover:text-gray-300 dark:hover:bg-gray-800',
        ],
    ];
    
    $tabsClass = $variantClasses[$variant]['tabs'] ?? $variantClasses['underline']['tabs'];
    $tabClass = $variantClasses[$variant]['tab'] ?? $variantClasses['underline']['tab'];
    $activeClass = $variantClasses[$variant]['active'] ?? $variantClasses['underline']['active'];
    $inactiveClass = $variantClasses[$variant]['inactive'] ?? $variantClasses['underline']['inactive'];
@endphp

<div x-data="{ activeTab: {{ $activeTab }} }">
    <div class="{{ $tabsClass }}" role="tablist">
        @foreach ($tabs as $index => $tab)
            <button 
                @click="activeTab = {{ $index }}" 
                :class="{ '{{ $activeClass }}': activeTab === {{ $index }}, '{{ $inactiveClass }}': activeTab !== {{ $index }} }"
                class="{{ $baseTabClasses }} {{ $tabClass }}"
                id="tab-{{ $index }}" 
                role="tab"
                aria-selected="activeTab === {{ $index }}"
                aria-controls="tabpanel-{{ $index }}"
            >
                {{ $tab }}
            </button>
        @endforeach
    </div>
    
    <div class="mt-4">
        @foreach ($tabs as $index => $tab)
            <div 
                x-show="activeTab === {{ $index }}"
                id="tabpanel-{{ $index }}"
                role="tabpanel"
                aria-labelledby="tab-{{ $index }}"
                x-transition:enter="transition ease-in-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            >
                {{ ${"tab{$index}Content"} ?? '' }}
            </div>
        @endforeach
    </div>
</div>