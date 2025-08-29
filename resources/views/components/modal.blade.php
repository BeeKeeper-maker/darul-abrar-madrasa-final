@props([
    'id',
    'title' => null,
    'maxWidth' => 'md',
    'closeButton' => true,
    'staticBackdrop' => false,
    'footer' => null,
    'open' => false
])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
        'full' => 'sm:max-w-full',
    ][$maxWidth] ?? 'sm:max-w-md';
@endphp

<div 
    id="{{ $id }}" 
    x-data="{ open: {{ $open ? 'true' : 'false' }} }"
    x-init="$watch('open', value => {
        if (value) {
            document.body.classList.add('overflow-hidden');
        } else {
            document.body.classList.remove('overflow-hidden');
        }
    })"
    x-show="open"
    x-on:open-modal.window="$event.detail == '{{ $id }}' ? open = true : null"
    x-on:close-modal.window="$event.detail == '{{ $id }}' ? open = false : null"
    x-on:keydown.escape.window="open = false"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto" 
    style="display: none;"
    aria-labelledby="modal-title-{{ $id }}"
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div 
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
            @click="{{ $staticBackdrop ? '' : 'open = false' }}"
            aria-hidden="true"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal -->
        <div 
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block w-full text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl sm:my-8 sm:align-middle {{ $maxWidthClass }} sm:w-full"
            @click.away="{{ $staticBackdrop ? '' : 'open = false' }}"
        >
            @if($title || $closeButton)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    @if($title)
                        <h3 id="modal-title-{{ $id }}" class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                    @endif
                    
                    @if($closeButton)
                        <button @click="open = false" type="button" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <span class="sr-only">Close</span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>
            @endif

            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            @if($footer)
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    window.openModal = function(modalId) {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: modalId }));
    }
    
    window.closeModal = function(modalId) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: modalId }));
    }
</script>