<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Darul Abrar Model Kamil Madrasa') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-16 w-auto mr-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">দারুল আবরার</h1>
                        <p class="text-sm text-gray-600">মডেল কামিল মাদ্রাসা</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Main Content -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    <strong>Info!</strong> {{ session('info') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                    <strong>Warning!</strong> {{ session('warning') }}
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Darul Abrar Model Kamil Madrasa') }}. All rights reserved.
        </div>
    </div>

    @stack('scripts')
</body>
</html>
