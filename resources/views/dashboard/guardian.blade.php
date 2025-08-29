<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guardian Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Guardian Profile Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                            @if ($guardian->profile_photo)
                                <img src="{{ Storage::url($guardian->profile_photo) }}" alt="{{ $guardian->name }}" class="h-24 w-24 object-cover rounded-full">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-3xl text-gray-600">{{ substr($guardian->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Welcome, {{ $guardian->name }}</h3>
                            <p class="text-gray-600">{{ $guardian->relation }}</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $students->count() }} {{ Str::plural('Child', $students->count()) }}
                                </span>
                                @if ($guardian->is_emergency_contact)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Emergency Contact
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <a href="{{ route('guardian.attendances') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Attendance</h3>
                                <p class="text-sm text-gray-500">View children's attendance records</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('guardian.results') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Results</h3>
                                <p class="text-sm text-gray-500">View children's academic results</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('guardian.fees') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Fees</h3>
                                <p class="text-sm text-gray-500">View children's fee details</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('notices.public') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Notices</h3>
                                <p class="text-sm text-gray-500">View school notices and announcements</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Children Overview -->
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Children Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($students as $student)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                                    <span class="text-xl text-indigo-600">{{ substr($student->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">{{ $student->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $student->class->name }} | Roll: {{ $student->roll_number }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <!-- Attendance Summary -->
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Attendance</h5>
                                    @php
                                        $totalDays = $student->attendances->count();
                                        $presentDays = $student->attendances->where('status', 'present')->count();
                                        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $attendancePercentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 ml-2">{{ $attendancePercentage }}%</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $presentDays }} present out of {{ $totalDays }} days</p>
                                </div>

                                <!-- Fee Summary -->
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Fees</h5>
                                    @php
                                        $totalFees = $student->fees->sum('amount');
                                        $paidFees = $student->fees->sum('paid_amount');
                                        $duePercentage = $totalFees > 0 ? round(($paidFees / $totalFees) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $duePercentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 ml-2">{{ $duePercentage }}%</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ number_format($paidFees, 2) }} paid out of {{ number_format($totalFees, 2) }}</p>
                                </div>

                                <!-- Results Summary -->
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Results</h5>
                                    @php
                                        $latestResult = $student->results->sortByDesc('created_at')->first();
                                    @endphp
                                    @if ($latestResult)
                                        <p class="text-sm font-medium text-gray-900">{{ $latestResult->exam->name }}</p>
                                        <p class="text-xs text-gray-500">Grade: {{ $latestResult->grade }} | GPA: {{ $latestResult->gpa }}</p>
                                    @else
                                        <p class="text-xs text-gray-500">No results available</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('students.show', $student) }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Full Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>