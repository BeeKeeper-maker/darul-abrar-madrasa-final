<!-- Dashboard -->
<a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    <span>ড্যাশবোর্ড</span>
</a>

@if(auth()->user()->isAdmin())
    <!-- User Management -->
    <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('users.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span>ইউজার ম্যানেজমেন্ট</span>
    </a>

    <!-- Department Management -->
    <a href="{{ route('departments.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('departments.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <span>বিভাগ ব্যবস্থাপনা</span>
    </a>

    <!-- Class Management -->
    <a href="{{ route('classes.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('classes.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        <span>শ্রেণী ব্যবস্থাপনা</span>
    </a>

    <!-- Teacher Management -->
    <a href="{{ route('teachers.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('teachers.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span>শিক্ষক ব্যবস্থাপনা</span>
    </a>

    <!-- Student Management -->
    <a href="{{ route('students.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('students.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 14l9-5-9-5-9 5 9 5z" />
            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
        </svg>
        <span>ছাত্র ব্যবস্থাপনা</span>
    </a>

    <!-- Guardian Management -->
    <a href="{{ route('guardians.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('guardians.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span>অভিভাবক ব্যবস্থাপনা</span>
    </a>

    <!-- Subject Management -->
    <a href="{{ route('subjects.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('subjects.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span>বিষয় ব্যবস্থাপনা</span>
    </a>

    <!-- Exam Management -->
    <a href="{{ route('exams.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('exams.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        <span>পরীক্ষা ব্যবস্থাপনা</span>
    </a>

    <!-- Fee Management -->
    <a href="{{ route('fees.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('fees.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>ফি ব্যবস্থাপনা</span>
    </a>

    <!-- Notice Management -->
    <a href="{{ route('notices.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('notices.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span>নোটিশ ব্যবস্থাপনা</span>
    </a>

    <!-- Grading Scale -->
    <a href="{{ route('grading-scales.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('grading-scales.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
        </svg>
        <span>গ্রেডিং স্কেল</span>
    </a>

    <!-- Reports -->
    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('reports.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span>রিপোর্টস</span>
    </a>

    <!-- Settings -->
    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('settings.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>সেটিংস</span>
    </a>
@endif

@if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
    <!-- Attendance Management -->
    <a href="{{ route('attendances.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('attendances.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span>উপস্থিতি</span>
    </a>

    <!-- Result Management -->
    <a href="{{ route('results.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('results.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        <span>ফলাফল</span>
    </a>
    
    <!-- Marks Entry -->
    <a href="{{ route('marks.create') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('marks.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span>নম্বর এন্ট্রি</span>
    </a>

    <!-- Lesson Plans -->
    <a href="{{ route('lesson-plans.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('lesson-plans.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span>পাঠ পরিকল্পনা</span>
    </a>

    <!-- Study Materials -->
    <a href="{{ route('study-materials.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('study-materials.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span>শিক্ষা উপকরণ</span>
    </a>
@endif

@if(auth()->user()->isStudent())
    <!-- My Attendance -->
    <a href="{{ route('my.attendance') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('my.attendance') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span>আমার উপস্থিতি</span>
    </a>

    <!-- My Results -->
    <a href="{{ route('my.results') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('my.results') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        <span>আমার ফলাফল</span>
    </a>
    
    <!-- Study Materials -->
    <a href="{{ route('my.materials') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('my.materials') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span>শিক্ষা উপকরণ</span>
    </a>

    <!-- My Fees -->
    <a href="{{ route('my.fees') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('my.fees') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>আমার ফি</span>
    </a>

    <!-- Class Routine -->
    <a href="{{ route('routines.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('routines.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>ক্লাস রুটিন</span>
    </a>
@endif

@if(auth()->user()->isGuardian())
    <!-- Children's Attendance -->
    <a href="{{ route('guardian.attendances') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('guardian.attendances') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span>সন্তানের উপস্থিতি</span>
    </a>

    <!-- Children's Results -->
    <a href="{{ route('guardian.results') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('guardian.results') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        <span>সন্তানের ফলাফল</span>
    </a>

    <!-- Children's Fees -->
    <a href="{{ route('guardian.fees') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('guardian.fees') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>সন্তানের ফি</span>
    </a>
@endif

<!-- Notices -->
<a href="{{ route('notices.public') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('notices.public') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
    </svg>
    <span>নোটিশ</span>
</a>

<!-- Notifications -->
<a href="{{ route('notifications.index') }}" class="flex items-center px-4 py-2 {{ request()->routeIs('notifications.*') ? 'bg-primary-600 dark:bg-gray-700 text-white' : 'text-gray-100 hover:bg-primary-600 dark:hover:bg-gray-700 hover:text-white' }} rounded-md transition-all">
    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
    </svg>
    <span>নোটিফিকেশন</span>
</a>