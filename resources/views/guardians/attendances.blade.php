<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Children\'s Attendance') }}
            </h2>
            <a href="{{ route('guardian.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($students as $student)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $student->user->name }} - {{ $student->class->name }}</h3>
                        
                        <!-- Attendance Summary -->
                        <div class="mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                @php
                                    $totalDays = $student->attendances->count();
                                    $presentDays = $student->attendances->where('status', 'present')->count();
                                    $absentDays = $student->attendances->where('status', 'absent')->count();
                                    $lateDays = $student->attendances->where('status', 'late')->count();
                                    $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;
                                @endphp
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Attendance Rate</h4>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $attendancePercentage }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $attendancePercentage }}%</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Total Days</h4>
                                        <p class="text-2xl font-bold text-gray-900">{{ $totalDays }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Present Days</h4>
                                        <p class="text-2xl font-bold text-green-600">{{ $presentDays }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Absent Days</h4>
                                        <p class="text-2xl font-bold text-red-600">{{ $absentDays }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Attendance Records -->
                        <h4 class="text-md font-medium text-gray-800 mb-3">Recent Attendance Records</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Remarks
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($student->attendances->sortByDesc('date')->take(10) as $attendance)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ $attendance->date->format('d M, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                @if ($attendance->status == 'present')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Present
                                                    </span>
                                                @elseif ($attendance->status == 'absent')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Absent
                                                    </span>
                                                @elseif ($attendance->status == 'late')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Late
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ $attendance->remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center text-gray-500">
                                                No attendance records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if ($student->attendances->count() > 10)
                            <div class="mt-4 text-right">
                                <p class="text-sm text-gray-500">Showing 10 most recent records out of {{ $student->attendances->count() }} total records.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>