@props([
    'name',
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'help' => null,
    'error' => null,
    'id' => null,
    'inline' => false,
])

@php
    $inputId = $id ?? $name . '_' . uniqid();
    $hasError = $error || (isset($errors) && $errors->has($name));
    $errorMessage = $error ?? (isset($errors) ? $errors->first($name) : null);
    
    $isChecked = old($name, $checked);
    
    $baseClasses = 'h-4 w-4 rounded focus:ring-2 focus:ring-offset-0';
    
    $stateClasses = $hasError
        ? 'border-danger-300 text-danger-600 focus:border-danger-500 focus:ring-danger-500'
        : 'border-gray-300 text-primary-600 focus:border-primary-500 focus:ring-primary-500';
        
    $disabledClasses = $disabled ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '';
    
    $classes = $baseClasses . ' ' . $stateClasses . ' ' . $disabledClasses;
    
    $containerClasses = $inline ? 'inline-flex items-center mr-4' : 'flex items-center';
@endphp

<div class="mb-4">
    <div class="{{ $containerClasses }}">
        <input 
            type="checkbox" 
            id="{{ $inputId }}" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            {{ $isChecked ? 'checked' : '' }} 
            {{ $disabled ? 'disabled' : '' }} 
            {{ $attributes->merge(['class' => $classes]) }}
        >
        
        @if ($label)
            <label for="{{ $inputId }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 {{ $disabled ? 'text-gray-500' : '' }}">
                {{ $label }}
            </label>
        @endif
    </div>
    
    @if ($hasError)
        <p class="mt-1 text-sm text-danger-600">{{ $errorMessage }}</p>
    @elseif ($help)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>