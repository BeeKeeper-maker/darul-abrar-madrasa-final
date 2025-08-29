@extends('layouts.app')

@section('header', 'Application Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Manage Settings</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update your application's general settings.</p>
        </x-slot>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- App Name -->
                <div class="col-span-1">
                    <x-input-label for="app_name" :value="__('Application Name')" />
                    <x-input id="app_name" class="block mt-1 w-full" type="text" name="app_name" :value="old('app_name', $settings['app_name'] ?? '')" required autofocus />
                    <x-input-error :messages="$errors->get('app_name')" class="mt-2" />
                </div>

                <!-- Academic Session -->
                <div class="col-span-1">
                    <x-input-label for="academic_session" :value="__('Academic Session')" />
                    <x-input id="academic_session" class="block mt-1 w-full" type="text" name="academic_session" :value="old('academic_session', $settings['academic_session'] ?? '')" placeholder="e.g., 2024-2025" />
                    <x-input-error :messages="$errors->get('academic_session')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="col-span-2">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-textarea id="address" name="address" class="block mt-1 w-full">{{ old('address', $settings['address'] ?? '') }}</x-textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- App Logo -->
                <div class="col-span-2">
                    <x-input-label for="app_logo" :value="__('Application Logo')" />
                    <div class="mt-2 flex items-center space-x-4">
                        @if(!empty($settings['app_logo']))
                            <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Current Logo" class="h-16 w-16 rounded-md object-cover bg-gray-100 dark:bg-gray-700">
                        @else
                            <div class="h-16 w-16 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 18"></path></svg>
                            </div>
                        @endif
                        <input id="app_logo" name="app_logo" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600"/>
                    </div>
                     <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Leave blank to keep the current logo. Max file size: 2MB.</p>
                    <x-input-error :messages="$errors->get('app_logo')" class="mt-2" />
                </div>

            </div>

            <div class="flex items-center justify-end mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <x-button>
                    {{ __('Save Settings') }}
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
