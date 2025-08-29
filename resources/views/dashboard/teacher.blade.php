@extends('layouts.app')

@section('header', 'শিক্ষক ড্যাশবোর্ড')

@section('content')
<!-- Teacher Profile Card -->
<div class="card mb-6">
    <div class="card-body">
        <div class="flex flex-col md:flex-row">
            <div class="flex-shrink-0 flex items-center justify-center mb-4 md:mb-0">
                @if(Auth::user()->avatar)
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-primary-100 dark:border-primary-900" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                @else
                    <div class="h-32 w-32 rounded-full bg-primary-600 dark:bg-primary-700 flex items-center justify-center text-white text-4xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="md:ml-6 flex-1">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $teacher->designation }} | {{ $teacher->department->name }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">ইমেইল: <span class="text-gray-800 dark:text-gray-200 font-semibold">{{ Auth::user()->email }}</span></p>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">ফোন: <span class="text-gray-800 dark:text-gray-200 font-semibold">{{ $teacher->phone }}</span></p>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">যোগদানের তারিখ: <span class="text-gray-800 dark:text-gray-200 font-semibold">{{ $teacher->joining_date->format('d M, Y') }}</span></p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">শিক্ষাগত যোগ্যতা: <span class="text-gray-800 dark:text-gray-200 font-semibold">{{ $teacher->qualification }}</span></p>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">অবস্থা: 
                            @if($teacher->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">সক্রিয়</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">নিষ্ক্রিয়</span>
                            @endif
                        </p>
                    </div>
                </div>
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
            <a href="{{ route('marks.create') }}" class="flex flex-col items-center justify-center p-4 bg-primary-50 dark:bg-primary-900/30 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 dark:text-primary-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">নম্বর এন্ট্রি</span>
            </a>
            
            <a href="{{ route('attendances.index') }}" class="flex flex-col items-center justify-center p-4 bg-secondary-50 dark:bg-secondary-900/30 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary-600 dark:text-secondary-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">উপস্থিতি নিন</span>
            </a>
            
            <a href="{{ route('lesson-plans.create') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 dark:bg-green-900/30 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">পাঠ পরিকল্পনা</span>
            </a>
            
            <a href="{{ route('study-materials.create') }}" class="flex flex-col items-center justify-center p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 dark:text-yellow-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">শিক্ষা উপকরণ</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Assigned Subjects -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">আমার অধীন বিষয়সমূহ</h2>
            <a href="{{ route('subjects.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">সব দেখুন</a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">বিষয়ের নাম</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">শ্রেণী</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">কোড</th>
                            <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignedSubjects as $subject)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $subject->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $subject->class->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">{{ $subject->code }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex space-x-2">
                                    <a href="{{ route('attendances.create.class', $subject->class_id) }}" class="text-secondary-600 dark:text-secondary-400 hover:text-secondary-800 dark:hover:text-secondary-300">
                                        <span class="sr-only">উপস্থিতি নিন</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('results.create.bulk', ['exam_id' => 0, 'class_id' => $subject->class_id, 'subject_id' => $subject->id]) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">
                                        <span class="sr-only">নম্বর দিন</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('study-materials.create', ['subject_id' => $subject->id]) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300">
                                        <span class="sr-only">শিক্ষা উপকরণ</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 border-b border-gray-200 dark:border-gray-700 text-center text-gray-500 dark:text-gray-400">কোন বিষয় নির্ধারিত নেই</td>
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

<!-- Recent Activities -->
<div class="card mb-6">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">সাম্প্রতিক কার্যক্রম</h2>
    </div>
    <div class="card-body">
        <div class="flow-root">
            <ul role="list" class="-mb-8">
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-primary-500 dark:bg-primary-700 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900 dark:text-gray-100">নবম শ্রেণীর গণিত বিষয়ের নম্বর এন্ট্রি করেছেন</a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">আজ, ১০:৩০ AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-secondary-500 dark:bg-secondary-700 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900 dark:text-gray-100">অষ্টম শ্রেণীর উপস্থিতি নিয়েছেন</a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">গতকাল, ৯:১৫ AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-yellow-500 dark:bg-yellow-700 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900 dark:text-gray-100">দশম শ্রেণীর জন্য নতুন শিক্ষা উপকরণ আপলোড করেছেন</a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">২ দিন আগে</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-green-500 dark:bg-green-700 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900 dark:text-gray-100">নবম শ্রেণীর জন্য পাঠ পরিকল্পনা তৈরি করেছেন</a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">৩ দিন আগে</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Recent Notices -->
<div class="card">
    <div class="card-header flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">সাম্প্রতিক নোটিশ</h2>
        <a href="{{ route('notices.public') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">সব দেখুন</a>
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
@endsection