@extends('layouts.app')

@section('header', 'অ্যাডমিন ড্যাশবোর্ড')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="card">
        <div class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm">মোট ছাত্র</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalStudents }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('students.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 text-sm flex items-center">
                    <span>সকল ছাত্র দেখুন</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary-100 text-secondary-600 dark:bg-secondary-900 dark:text-secondary-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm">মোট শিক্ষক</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalTeachers }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('teachers.index') }}" class="text-secondary-600 dark:text-secondary-400 hover:text-secondary-800 dark:hover:text-secondary-300 text-sm flex items-center">
                    <span>সকল শিক্ষক দেখুন</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm">মোট শ্রেণী</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalClasses }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('classes.index') }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 text-sm flex items-center">
                    <span>সকল শ্রেণী দেখুন</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm">আদায়কৃত ফি</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($totalFeesCollected, 2) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('fees.index') }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm flex items-center">
                    <span>সকল ফি দেখুন</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm">বকেয়া ফি</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ number_format($pendingFees, 2) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('fees.index', ['status' => 'unpaid']) }}" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm flex items-center">
                    <span>বকেয়া ফি দেখুন</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm">মোট বিষয়</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalSubjects }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('subjects.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 text-sm flex items-center">
                    <span>সকল বিষয় দেখুন</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-6">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">দ্রুত কার্যক্রম</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('students.create') }}" class="flex flex-col items-center justify-center p-4 bg-primary-50 dark:bg-primary-900/30 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 dark:text-primary-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">নতুন ছাত্র</span>
            </a>
            
            <a href="{{ route('teachers.create') }}" class="flex flex-col items-center justify-center p-4 bg-secondary-50 dark:bg-secondary-900/30 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary-600 dark:text-secondary-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">নতুন শিক্ষক</span>
            </a>
            
            <a href="{{ route('fees.create') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 dark:bg-green-900/30 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">ফি সংগ্রহ</span>
            </a>
            
            <a href="{{ route('notices.create') }}" class="flex flex-col items-center justify-center p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 dark:text-yellow-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">নতুন নোটিশ</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Recent Fees -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">সাম্প্রতিক ফি সংগ্রহ</h2>
            <a href="{{ route('fees.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">সব দেখুন</a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">ছাত্র</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">পরিমাণ</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">তারিখ</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">অবস্থা</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentFees as $fee)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $fee->student->user->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $fee->amount }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $fee->payment_date ?? $fee->due_date }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">
                                @if($fee->status == 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">পরিশোধিত</span>
                                @elseif($fee->status == 'partial')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">আংশিক</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">অপরিশোধিত</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 border-b border-gray-200 dark:border-gray-700 text-center text-gray-500 dark:text-gray-400">কোন সাম্প্রতিক ফি সংগ্রহ নেই</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Exams -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">আসন্ন পরীক্ষা</h2>
            <a href="{{ route('exams.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">সব দেখুন</a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">পরীক্ষার নাম</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">শ্রেণী</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">শুরুর তারিখ</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">শেষের তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingExams as $exam)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $exam->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $exam->class->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $exam->start_date->format('d M, Y') }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $exam->end_date->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 border-b border-gray-200 dark:border-gray-700 text-center text-gray-500 dark:text-gray-400">কোন আসন্ন পরীক্ষা নেই</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Notices -->
<div class="card mb-6">
    <div class="card-header flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">সাম্প্রতিক নোটিশ</h2>
        <a href="{{ route('notices.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">সব দেখুন</a>
    </div>
    <div class="card-body">
        <div class="space-y-4">
            @forelse($recentNotices as $notice)
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $notice->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">প্রকাশিত: {{ $notice->publish_date->format('d M, Y') }} | প্রকাশক: {{ $notice->publishedBy->name }}</p>
                <p class="text-gray-700 dark:text-gray-300">{{ Str::limit($notice->description, 150) }}</p>
                <div class="mt-2">
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($notice->notice_for == 'all') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($notice->notice_for == 'students') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($notice->notice_for == 'teachers') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                        জন্য: {{ $notice->notice_for == 'all' ? 'সকল' : ($notice->notice_for == 'students' ? 'ছাত্র' : 'শিক্ষক') }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">কোন সাম্প্রতিক নোটিশ নেই</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Analytics Section -->
<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">অ্যানালিটিক্স</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">ছাত্র উপস্থিতি</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                    <canvas id="attendanceChart" height="200"></canvas>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">ফি সংগ্রহ</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                    <canvas id="feesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attendance Chart
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন'],
                datasets: [{
                    label: 'উপস্থিতি শতাংশ',
                    data: [85, 88, 92, 87, 90, 93],
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 70,
                        max: 100
                    }
                }
            }
        });
        
        // Fees Chart
        const feesCtx = document.getElementById('feesChart').getContext('2d');
        const feesChart = new Chart(feesCtx, {
            type: 'bar',
            data: {
                labels: ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন'],
                datasets: [{
                    label: 'আদায়কৃত ফি',
                    data: [25000, 32000, 28000, 35000, 30000, 38000],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        
        // Update charts when dark mode changes
        document.addEventListener('dark-mode-changed', function(e) {
            const isDarkMode = e.detail.darkMode;
            
            // Update chart text colors
            const textColor = isDarkMode ? '#e5e7eb' : '#374151';
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            
            attendanceChart.options.scales.x.ticks.color = textColor;
            attendanceChart.options.scales.y.ticks.color = textColor;
            attendanceChart.options.scales.x.grid.color = gridColor;
            attendanceChart.options.scales.y.grid.color = gridColor;
            attendanceChart.options.plugins.legend.labels.color = textColor;
            attendanceChart.update();
            
            feesChart.options.scales.x.ticks.color = textColor;
            feesChart.options.scales.y.ticks.color = textColor;
            feesChart.options.scales.x.grid.color = gridColor;
            feesChart.options.scales.y.grid.color = gridColor;
            feesChart.options.plugins.legend.labels.color = textColor;
            feesChart.update();
        });
    });
</script>
@endpush
@endsection