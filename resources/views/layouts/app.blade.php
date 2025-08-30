<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
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
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Livewire -->
    @livewireStyles
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
     <!-- Page Loader Component -->
    <x-page-loader />
    
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col">
        <!-- Sidebar for mobile -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" x-cloak>
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80"
                 @click="sidebarOpen = false"
                 aria-hidden="true">
            </div>
            
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex-1 flex flex-col max-w-xs w-full bg-primary-700 dark:bg-gray-800">
                
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto mr-2">
                        <span class="text-white text-xl font-bold">দারুল আবরার</span>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        @include('layouts.navigation-links')
                    </nav>
                </div>
                
                @auth
                <div class="flex-shrink-0 flex border-t border-primary-800 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div>
                            @if(Auth::user()->avatar)
                                <img class="inline-block h-10 w-10 rounded-full" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-primary-600 dark:bg-gray-700">
                                    <span class="text-xl font-medium leading-none text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm font-medium text-primary-200 dark:text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
            
            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-primary-700 dark:bg-gray-800">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto mr-2">
                        <span class="text-white text-xl font-bold">দারুল আবরার</span>
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        @include('layouts.navigation-links')
                    </nav>
                </div>
                @auth
                <div class="flex-shrink-0 flex border-t border-primary-800 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div>
                            @if(Auth::user()->avatar)
                                <img class="inline-block h-10 w-10 rounded-full" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-primary-600 dark:bg-gray-700">
                                    <span class="text-xl font-medium leading-none text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm font-medium text-primary-200 dark:text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>

        <!-- Main content -->
        <div class="lg:pl-64 flex flex-col flex-1">
            <!-- Top navigation -->
            <div class="sticky top-0 z-10 bg-white dark:bg-gray-800 shadow-sm">
                <div class="flex-1 px-4 flex justify-between h-16">
                    <div class="flex">
                        <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        <div class="flex-1 flex items-center px-4 lg:px-0">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                @yield('header', 'Dashboard')
                            </h2>
                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6 space-x-4">
                        <!-- Dark mode toggle -->
                        <button @click="darkMode = !darkMode" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <span x-show="!darkMode">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="darkMode">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                        </button>
                        
                        <!-- Notifications -->
                        <x-notification-dropdown />
                        
                        <!-- Profile dropdown -->
                        @auth
                        <div x-data="{ open: false }" class="relative">
                            <div>
                                <button @click="open = !open" class="max-w-xs bg-white dark:bg-gray-800 flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    @if(Auth::user()->avatar)
                                        <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                    @else
                                        <div class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-600 dark:bg-gray-700">
                                            <span class="text-sm font-medium leading-none text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </button>
                            </div>
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100" 
                                 x-transition:enter-start="transform opacity-0 scale-95" 
                                 x-transition:enter-end="transform opacity-100 scale-100" 
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="transform opacity-100 scale-100" 
                                 x-transition:leave-end="transform opacity-0 scale-95" 
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none" 
                                 role="menu" 
                                 aria-orientation="vertical" 
                                 aria-labelledby="user-menu-button" 
                                 tabindex="-1"
                                 @click.away="open = false"
                                 x-cloak>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Your Profile</a>
                                <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Notifications</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Sign out</button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>

            <main class="flex-1">
                <!-- Toast Notification Component -->
                <x-toast />
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <x-alert type="success" dismissible>
                            <strong>Success!</strong> {{ session('success') }}
                        </x-alert>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            window.showToast("{{ session('success') }}", "success");
                        });
                    </script>
                @endif

                @if(session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <x-alert type="error" dismissible>
                            <strong>Error!</strong> {{ session('error') }}
                        </x-alert>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            window.showToast("{{ session('error') }}", "error");
                        });
                    </script>
                @endif

                @if(session('info'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <x-alert type="info" dismissible>
                            <strong>Info!</strong> {{ session('info') }}
                        </x-alert>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            window.showToast("{{ session('info') }}", "info");
                        });
                    </script>
                @endif

                @if(session('warning'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <x-alert type="warning" dismissible>
                            <strong>Warning!</strong> {{ session('warning') }}
                        </x-alert>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            window.showToast("{{ session('warning') }}", "warning");
                        });
                    </script>
                @endif

                <!-- Page Content -->
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow mt-auto py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Darul Abrar Model Kamil Madrasa') }}. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    @stack('scripts')
</body>
</html>