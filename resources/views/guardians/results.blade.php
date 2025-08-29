<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Children\'s Results') }}
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
                        
                        <!-- Results by Exam -->
                        @php
                            $examResults = $student->results->groupBy('exam_id');
                        @endphp
                        
                        @if ($examResults->count() > 0)
                            <div class="space-y-8">
                                @foreach ($examResults as $examId => $results)
                                    @php
                                        $exam = $results->first()->exam;
                                        $totalMarks = $results->sum('marks');
                                        $totalOutOf = $results->sum('out_of');
                                        $percentage = $totalOutOf > 0 ? round(($totalMarks / $totalOutOf) * 100, 2) : 0;
                                        
                                        // Calculate average GPA
                                        $totalGpa = $results->sum('gpa');
                                        $avgGpa = $results->count() > 0 ? round($totalGpa / $results->count(), 2) : 0;
                                        
                                        // Determine overall grade
                                        $overallGrade = '';
                                        if ($avgGpa >= 4.0) $overallGrade = 'A+';
                                        elseif ($avgGpa >= 3.7) $overallGrade = 'A';
                                        elseif ($avgGpa >= 3.3) $overallGrade = 'A-';
                                        elseif ($avgGpa >= 3.0) $overallGrade = 'B+';
                                        elseif ($avgGpa >= 2.7) $overallGrade = 'B';
                                        elseif ($avgGpa >= 2.3) $overallGrade = 'B-';
                                        elseif ($avgGpa >= 2.0) $overallGrade = 'C+';
                                        elseif ($avgGpa >= 1.7) $overallGrade = 'C';
                                        elseif ($avgGpa >= 1.3) $overallGrade = 'C-';
                                        elseif ($avgGpa >= 1.0) $overallGrade = 'D';
                                        else $overallGrade = 'F';
                                    @endphp
                                    
                                    <div class="bg-gray-50 p-6 rounded-lg">
                                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $exam->name }}</h4>
                                                <p class="text-sm text-gray-600">{{ $exam->start_date->format('d M, Y') }} - {{ $exam->end_date->format('d M, Y') }}</p>
                                            </div>
                                            <div class="mt-4 md:mt-0 flex items-center">
                                                <a href="{{ route('results.download', $exam->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Download Result
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- Result Summary -->
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                                <h5 class="text-sm font-medium text-gray-500 mb-1">Total Marks</h5>
                                                <p class="text-2xl font-bold text-gray-900">{{ $totalMarks }}/{{ $totalOutOf }}</p>
                                            </div>
                                            
                                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                                <h5 class="text-sm font-medium text-gray-500 mb-1">Percentage</h5>
                                                <p class="text-2xl font-bold text-gray-900">{{ $percentage }}%</p>
                                            </div>
                                            
                                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                                <h5 class="text-sm font-medium text-gray-500 mb-1">GPA</h5>
                                                <p class="text-2xl font-bold text-gray-900">{{ $avgGpa }}</p>
                                            </div>
                                            
                                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                                <h5 class="text-sm font-medium text-gray-500 mb-1">Grade</h5>
                                                <p class="text-2xl font-bold text-gray-900">{{ $overallGrade }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Subject-wise Results -->
                                        <h5 class="text-md font-medium text-gray-800 mb-3">Subject-wise Results</h5>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full bg-white">
                                                <thead>
                                                    <tr>
                                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Subject
                                                        </th>
                                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Marks
                                                        </th>
                                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Grade
                                                        </th>
                                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            GPA
                                                        </th>
                                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Remarks
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($results->sortBy('subject.name') as $result)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                                {{ $result->subject->name }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                                {{ $result->marks }}/{{ $result->out_of }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                                {{ $result->grade }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                                {{ $result->gpa }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                                {{ $result->remarks ?? 'No remarks' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 p-6 rounded-lg text-center">
                                <p class="text-gray-500">No results available for this student.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>