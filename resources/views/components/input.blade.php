@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
    'error' => null,
    'leadingIcon' => null,
    'trailingIcon' => null,
    'id' => null,
])

@php
    $inputId = $id ?? $name . '_' . uniqid();
    $hasError = $error || (isset($errors) && $errors->has($name));
    $errorMessage = $error ?? (isset($errors) ? $errors->first($name) : null);
    $hasLeadingIcon = $leadingIcon !== null;
    $hasTrailingIcon = $trailingIcon !== null;
    
    $baseClasses = 'block w-full rounded-md shadow-sm focus:ring-2 focus:ring-offset-0 sm:text-sm';
    
    $stateClasses = $hasError
        ? 'border-danger-300 text-danger-900 placeholder-danger-300 focus:border-danger-500 focus:ring-danger-500'
        : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500';
        
    $disabledClasses = $disabled ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '';
    $readonlyClasses = $readonly ? 'bg-gray-50' : '';
    
    $paddingClasses = '';
    if ($hasLeadingIcon && $hasTrailingIcon) {
        $paddingClasses = 'pl-10 pr-10';
    } elseif ($hasLeadingIcon) {
        $paddingClasses = 'pl-10';
    } elseif ($hasTrailingIcon) {
        $paddingClasses = 'pr-10';
    }
    
    $classes = $baseClasses . ' ' . $stateClasses . ' ' . $disabledClasses . ' ' . $readonlyClasses . ' ' . $paddingClasses;
@endphp

<div class="mb-4">
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-danger-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative rounded-md shadow-sm">
        @if ($hasLeadingIcon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-dynamic-component :component="$leadingIcon" class="h-5 w-5 text-gray-400" />
            </div>
        @endif
        
        <input 
            type="{{ $type }}" 
            id="{{ $inputId }}" 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $disabled ? 'disabled' : '' }} 
            {{ $readonly ? 'readonly' : '' }} 
            {{ $required ? 'required' : '' }} 
            {{ $attributes->merge(['class' => $classes]) }}
        />
        
        @if ($hasTrailingIcon)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-dynamic-component :component="$trailingIcon" class="h-5 w-5 text-gray-400" />
            </div>
        @endif
    </div>
    
    @if ($hasError)
        <p class="mt-1 text-sm text-danger-600">{{ $errorMessage }}</p>
    @elseif ($help)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>