@extends('layouts.app')

@section('title', 'Academic Performance Report')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Academic Performance Report</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active">Academic Performance</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter Options
        </div>
        <div class="card-body">
            <form action="{{ route('reports.academic-performance') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="class_id" class="form-label">Class</label>
                    <select class="form-select" id="class_id" name="class_id" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} ({{ $class->department->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="exam_id" class="form-label">Exam</label>
                    <select class="form-select" id="exam_id" name="exam_id" required>
                        <option value="">Select Exam</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }} ({{ $exam->start_date->format('M Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    @if($performanceData)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-chart-line me-1"></i>
                    Class Performance Summary
                </div>
                <div>
                    <form action="{{ route('reports.export-pdf') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="academic_performance">
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="exam_id" value="{{ $selectedExamId }}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export as PDF
                        </button>
                    </form>
                    <form action="{{ route('reports.export-excel') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="academic_performance">
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="exam_id" value="{{ $selectedExamId }}">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel me-1"></i> Export as Excel
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Exam: {{ $exams->find($selectedExamId)->name }}</h5>
                        <h5>Class: {{ $classes->find($selectedClassId)->name }}</h5>
                        <h5>Department: {{ $classes->find($selectedClassId)->department->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <h6 class="text-muted">Total Students</h6>
                                <h3>{{ count($performanceData) }}</h3>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 class="text-muted">Passed</h6>
                                <h3 class="text-success">
                                    {{ count(array_filter($performanceData, function($item) { return $item['final_result'] === 'PASSED'; })) }}
                                </h3>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 class="text-muted">Failed</h6>
                                <h3 class="text-danger">
                                    {{ count(array_filter($performanceData, function($item) { return $item['final_result'] === 'FAILED'; })) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <canvas id="gradeDistributionChart" width="100%" height="300"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="passFailChart" width="100%" height="300"></canvas>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                @foreach($subjects as $subject)
                                    <th>{{ $subject->name }}</th>
                                @endforeach
                                <th>Total</th>
                                <th>Average</th>
                                <th>GPA</th>
                                <th>Grade</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($performanceData as $studentId => $data)
                                <tr>
                                    <td>{{ $data['rank'] }}</td>
                                    <td>{{ $data['student']->student_id }}</td>
                                    <td>{{ $data['student']->name }}</td>
                                    @foreach($subjects as $subject)
                                        @php
                                            $result = $data['results']->firstWhere('subject_id', $subject->id);
                                        @endphp
                                        <td class="{{ $result && !$result->is_passed ? 'text-danger' : '' }}">
                                            @if($result)
                                                {{ $result->marks_obtained }} ({{ $result->grade }})
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>{{ $data['total_marks'] }}</td>
                                    <td>{{ round($data['total_marks'] / $data['total_subjects'], 2) }}</td>
                                    <td>{{ $data['average_gpa'] }}</td>
                                    <td>{{ $data['overall_grade'] }}</td>
                                    <td>
                                        @if($data['final_result'] === 'PASSED')
                                            <span class="badge bg-success">Passed</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Subject-wise Performance
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <canvas id="subjectPerformanceChart" width="100%" height="300"></canvas>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Highest Mark</th>
                                <th>Lowest Mark</th>
                                <th>Average Mark</th>
                                <th>Pass Rate</th>
                                <th>Fail Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                                @php
                                    $subjectResults = [];
                                    foreach($performanceData as $studentId => $data) {
                                        $result = $data['results']->firstWhere('subject_id', $subject->id);
                                        if($result) {
                                            $subjectResults[] = $result;
                                        }
                                    }
                                    
                                    $totalResults = count($subjectResults);
                                    $highestMark = $totalResults > 0 ? max(array_column($subjectResults, 'marks_obtained')) : 0;
                                    $lowestMark = $totalResults > 0 ? min(array_column($subjectResults, 'marks_obtained')) : 0;
                                    $averageMark = $totalResults > 0 ? array_sum(array_column($subjectResults, 'marks_obtained')) / $totalResults : 0;
                                    $passedCount = count(array_filter($subjectResults, function($result) { return $result->is_passed; }));
                                    $passRate = $totalResults > 0 ? ($passedCount / $totalResults) * 100 : 0;
                                    $failRate = 100 - $passRate;
                                @endphp
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $highestMark }}</td>
                                    <td>{{ $lowestMark }}</td>
                                    <td>{{ round($averageMark, 2) }}</td>
                                    <td>{{ round($passRate, 2) }}%</td>
                                    <td>{{ round($failRate, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i>
            Please select a class and exam to generate the academic performance report.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if($performanceData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grade Distribution Chart
    var gradeDistribution = {
        'A+': 0, 'A': 0, 'A-': 0,
        'B+': 0, 'B': 0, 'B-': 0,
        'C+': 0, 'C': 0, 'C-': 0,
        'D+': 0, 'D': 0, 'F': 0
    };

    @foreach($performanceData as $studentId => $data)
        var grade = '{{ $data['overall_grade'] }}';
        if(gradeDistribution.hasOwnProperty(grade)) {
            gradeDistribution[grade]++;
        }
    @endforeach

    var gradeCtx = document.getElementById('gradeDistributionChart');
    var gradeChart = new Chart(gradeCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(gradeDistribution),
            datasets: [{
                label: 'Number of Students',
                data: Object.values(gradeDistribution),
                backgroundColor: [
                    '#4caf50', '#66bb6a', '#81c784',
                    '#2196f3', '#42a5f5', '#64b5f6',
                    '#ff9800', '#ffa726', '#ffb74d',
                    '#f44336', '#ef5350', '#e57373'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Grade Distribution'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Pass/Fail Chart
    var passCount = {{ count(array_filter($performanceData, function($item) { return $item['final_result'] === 'PASSED'; })) }};
    var failCount = {{ count(array_filter($performanceData, function($item) { return $item['final_result'] === 'FAILED'; })) }};

    var passFailCtx = document.getElementById('passFailChart');
    var passFailChart = new Chart(passFailCtx, {
        type: 'pie',
        data: {
            labels: ['Passed', 'Failed'],
            datasets: [{
                data: [passCount, failCount],
                backgroundColor: ['#4caf50', '#f44336'],
                hoverBackgroundColor: ['#388e3c', '#d32f2f'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Pass/Fail Distribution'
                }
            }
        }
    });

    // Subject Performance Chart
    var subjects = [];
    var averageMarks = [];
    var passRates = [];

    @foreach($subjects as $subject)
        @php
            $subjectResults = [];
            foreach($performanceData as $studentId => $data) {
                $result = $data['results']->firstWhere('subject_id', $subject->id);
                if($result) {
                    $subjectResults[] = $result;
                }
            }
            
            $totalResults = count($subjectResults);
            $averageMark = $totalResults > 0 ? array_sum(array_column($subjectResults, 'marks_obtained')) / $totalResults : 0;
            $passedCount = count(array_filter($subjectResults, function($result) { return $result->is_passed; }));
            $passRate = $totalResults > 0 ? ($passedCount / $totalResults) * 100 : 0;
        @endphp

        subjects.push('{{ $subject->name }}');
        averageMarks.push({{ round($averageMark, 2) }});
        passRates.push({{ round($passRate, 2) }});
    @endforeach

    var subjectCtx = document.getElementById('subjectPerformanceChart');
    var subjectChart = new Chart(subjectCtx, {
        type: 'bar',
        data: {
            labels: subjects,
            datasets: [
                {
                    label: 'Average Mark',
                    data: averageMarks,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Pass Rate (%)',
                    data: passRates,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Subject-wise Performance'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Average Mark'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    max: 100,
                    title: {
                        display: true,
                        text: 'Pass Rate (%)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
</script>
@endif
@endsection