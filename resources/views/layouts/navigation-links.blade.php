{{-- Authenticated User Links Start Here --}}
@auth
    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span>ড্যাশবোর্ড</span>
    </a>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('users.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>ইউজার ম্যানেজমেন্ট</span>
        </a>

        <a href="{{ route('departments.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('departments.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span>বিভাগ ব্যবস্থাপনা</span>
        </a>
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'teacher']))
        <a href="{{ route('attendances.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('attendances.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>উপস্থিতি</span>
        </a>
    @endif

    @if(auth()->user()->role === 'student')
        <a href="{{ route('my.attendance') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('my.attendance') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>আমার উপস্থিতি</span>
        </a>
    @endif
@endauth
