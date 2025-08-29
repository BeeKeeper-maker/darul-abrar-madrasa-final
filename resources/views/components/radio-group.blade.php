@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'required' => false,
    'disabled' => false,
    'help' => null,
    'error' => null,
    'inline' => false,
])

@php
    $hasError = $error || (isset($errors) && $errors->has($name));
    $errorMessage = $error ?? (isset($errors) ? $errors->first($name) : null);
    
    $containerClasses = $inline ? 'flex flex-wrap gap-4' : 'space-y-2';
@endphp

<div class="mb-4">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if ($required)
                <span class="text-danger-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="{{ $containerClasses }}">
        @foreach ($options as $optionValue => $optionLabel)
            <x-radio 
                name="{{ $name }}" 
                value="{{ $optionValue }}" 
                label="{{ $optionLabel }}" 
                :checked="old($name, $value) == $optionValue" 
                :disabled="$disabled" 
                :inline="$inline"
            />
        @endforeach
    </div>
    
    @if ($hasError)
        <p class="mt-1 text-sm text-danger-600">{{ $errorMessage }}</p>
    @elseif ($help)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>