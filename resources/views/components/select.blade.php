@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'value' => null,
    'placeholder' => 'Select an option',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
    'error' => null,
    'id' => null,
    'multiple' => false,
    'size' => null,
])

@php
    $inputId = $id ?? $name . '_' . uniqid();
    $hasError = $error || (isset($errors) && $errors->has($name));
    $errorMessage = $error ?? (isset($errors) ? $errors->first($name) : null);
    
    // Support both 'selected' and 'value' props for backward compatibility
    $selectedValue = $value ?? $selected;
    
    $baseClasses = 'block w-full rounded-md shadow-sm focus:ring-2 focus:ring-offset-0 sm:text-sm';
    
    $stateClasses = $hasError
        ? 'border-danger-300 text-danger-900 focus:border-danger-500 focus:ring-danger-500'
        : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500';
        
    $disabledClasses = $disabled ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '';
    $readonlyClasses = $readonly ? 'bg-gray-50' : '';
    
    $classes = $baseClasses . ' ' . $stateClasses . ' ' . $disabledClasses . ' ' . $readonlyClasses;
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
    
    <select 
        id="{{ $inputId }}" 
        name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
        {{ $disabled ? 'disabled' : '' }} 
        {{ $readonly ? 'readonly' : '' }} 
        {{ $required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
        {{ $size ? 'size='.$size : '' }}
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($placeholder && !$multiple)
            <option value="" {{ is_null($selectedValue) ? 'selected' : '' }} {{ $required ? 'disabled' : '' }}>{{ $placeholder }}</option>
        @endif
        
        @foreach ($options as $optionValue => $optionLabel)
            @if (is_array($optionLabel))
                <optgroup label="{{ $optionValue }}">
                    @foreach ($optionLabel as $groupOptionValue => $groupOptionLabel)
                        <option 
                            value="{{ $groupOptionValue }}" 
                            {{ $multiple 
                                ? (is_array($selectedValue) && in_array($groupOptionValue, $selectedValue) ? 'selected' : '') 
                                : (old($name, $selectedValue) == $groupOptionValue ? 'selected' : '') }}
                        >
                            {{ $groupOptionLabel }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option 
                    value="{{ $optionValue }}" 
                    {{ $multiple 
                        ? (is_array($selectedValue) && in_array($optionValue, $selectedValue) ? 'selected' : '') 
                        : (old($name, $selectedValue) == $optionValue ? 'selected' : '') }}
                >
                    {{ $optionLabel }}
                </option>
            @endif
        @endforeach
    </select>
    
    @if ($hasError)
        <p class="mt-1 text-sm text-danger-600">{{ $errorMessage }}</p>
    @elseif ($help)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>