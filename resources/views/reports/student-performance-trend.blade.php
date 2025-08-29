@extends('layouts.app')

@section('title', 'Student Performance Trend')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Student Performance Trend</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active">Student Performance Trend</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Select Student
        </div>
        <div class="card-body">
            <form action="{{ route('reports.student-performance-trend') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <label for="student_id" class="form-label">Student</label>
                    <select class="form-select" id="student_id" name="student_id" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $selectedStudentId == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->student_id }}) - {{ $student->class->name ?? 'No Class' }}
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
                    Performance Trend Analysis
                </div>
                <div>
                    <form action="{{ route('reports.export-pdf') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="student_performance_trend">
                        <input type="hidden" name="student_id" value="{{ $selectedStudentId }}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export as PDF
                        </button>
                    </form>
                    <form action="{{ route('reports.export-excel') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="student_performance_trend">
                        <input type="hidden" name="student_id" value="{{ $selectedStudentId }}">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel me-1"></i> Export as Excel
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Student: {{ $performanceData['student']->name }}</h5>
                        <h5>Student ID: {{ $performanceData['student']->student_id }}</h5>
                        <h5>Class: {{ $performanceData['student']->class->name ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <p class="mb-0">This report shows the performance trend of the student across multiple exams.</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <canvas id="performanceTrendChart" width="100%" height="300"></canvas>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <canvas id="gpaChart" width="100%" height="200"></canvas>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Exam</th>
                                <th>Total Marks</th>
                                <th>Average GPA</th>
                                <th>Subjects</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($performanceData['overall_performance'] as $performance)
                                <tr>
                                    <td>{{ $performance['exam'] }}</td>
                                    <td>{{ $performance['total_marks'] }}</td>
                                    <td>{{ $performance['average_gpa'] }}</td>
                                    <td>{{ $performance['subjects'] }}</td>
                                    <td>
                                        @php
                                            $gpa = $performance['average_gpa'];
                                            $badgeClass = 'bg-danger';
                                            
                                            if ($gpa >= 4.5) {
                                                $badgeClass = 'bg-success';
                                            } elseif ($gpa >= 3.5) {
                                                $badgeClass = 'bg-primary';
                                            } elseif ($gpa >= 2.5) {
                                                $badgeClass = 'bg-info';
                                            } elseif ($gpa >= 1.0) {
                                                $badgeClass = 'bg-warning';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            @if($gpa >= 4.5)
                                                Excellent
                                            @elseif($gpa >= 3.5)
                                                Very Good
                                            @elseif($gpa >= 2.5)
                                                Good
                                            @elseif($gpa >= 1.0)
                                                Average
                                            @else
                                                Poor
                                            @endif
                                        </span>
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
                Subject-wise Performance Trend
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($performanceData['datasets'] as $index => $dataset)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    {{ $dataset['label'] }}
                                </div>
                                <div class="card-body">
                                    <canvas id="subjectChart{{ $index }}" width="100%" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-pie me-1"></i>
                Performance Analysis
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                Strengths and Weaknesses
                            </div>
                            <div class="card-body">
                                @php
                                    // Calculate average marks for each subject across all exams
                                    $subjectAverages = [];
                                    foreach($performanceData['datasets'] as $dataset) {
                                        $subjectAverages[$dataset['label']] = array_sum($dataset['data']) / count($dataset['data']);
                                    }
                                    
                                    // Sort subjects by average marks
                                    arsort($subjectAverages);
                                    
                                    // Get top 3 and bottom 3 subjects
                                    $strengths = array_slice($subjectAverages, 0, 3, true);
                                    $weaknesses = array_slice($subjectAverages, -3, 3, true);
                                @endphp

                                <h5>Strengths</h5>
                                <ul class="list-group mb-3">
                                    @foreach($strengths as $subject => $average)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $subject }}
                                            <span class="badge bg-success rounded-pill">{{ round($average, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <h5>Areas for Improvement</h5>
                                <ul class="list-group">
                                    @foreach($weaknesses as $subject => $average)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $subject }}
                                            <span class="badge bg-warning rounded-pill">{{ round($average, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                Performance Consistency
                            </div>
                            <div class="card-body">
                                @php
                                    // Calculate consistency score for each subject
                                    $consistencyScores = [];
                                    foreach($performanceData['datasets'] as $dataset) {
                                        $marks = $dataset['data'];
                                        $mean = array_sum($marks) / count($marks);
                                        
                                        // Calculate standard deviation
                                        $variance = 0;
                                        foreach($marks as $mark) {
                                            $variance += pow($mark - $mean, 2);
                                        }
                                        $stdDev = sqrt($variance / count($marks));
                                        
                                        // Calculate coefficient of variation (lower is more consistent)
                                        $cv = $mean > 0 ? ($stdDev / $mean) * 100 : 0;
                                        
                                        // Convert to consistency score (100 - CV, higher is more consistent)
                                        $consistencyScores[$dataset['label']] = max(0, min(100, 100 - $cv));
                                    }
                                    
                                    // Sort by consistency
                                    arsort($consistencyScores);
                                    
                                    // Overall consistency
                                    $overallConsistency = array_sum($consistencyScores) / count($consistencyScores);
                                @endphp

                                <div class="text-center mb-3">
                                    <h5>Overall Consistency</h5>
                                    <div class="progress" style="height: 25px;">
                                        @php
                                            $consistencyClass = 'bg-danger';
                                            if ($overallConsistency >= 80) {
                                                $consistencyClass = 'bg-success';
                                            } elseif ($overallConsistency >= 60) {
                                                $consistencyClass = 'bg-primary';
                                            } elseif ($overallConsistency >= 40) {
                                                $consistencyClass = 'bg-warning';
                                            }
                                        @endphp
                                        <div class="progress-bar {{ $consistencyClass }}" role="progressbar" style="width: {{ $overallConsistency }}%;" aria-valuenow="{{ $overallConsistency }}" aria-valuemin="0" aria-valuemax="100">{{ round($overallConsistency, 2) }}%</div>
                                    </div>
                                </div>

                                <h5>Subject Consistency</h5>
                                <ul class="list-group">
                                    @foreach($consistencyScores as $subject => $score)
                                        <li class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $subject }}</h6>
                                                <small>{{ round($score, 2) }}%</small>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                @php
                                                    $scoreClass = 'bg-danger';
                                                    if ($score >= 80) {
                                                        $scoreClass = 'bg-success';
                                                    } elseif ($score >= 60) {
                                                        $scoreClass = 'bg-primary';
                                                    } elseif ($score >= 40) {
                                                        $scoreClass = 'bg-warning';
                                                    }
                                                @endphp
                                                <div class="progress-bar {{ $scoreClass }}" role="progressbar" style="width: {{ $score }}%;" aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i>
            Please select a student to generate the performance trend report.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if($performanceData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Performance Trend Chart
    var labels = @json($performanceData['labels']);
    var datasets = @json($performanceData['datasets']);
    
    // Assign colors to datasets
    var colors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(199, 199, 199, 0.7)',
        'rgba(83, 102, 255, 0.7)',
        'rgba(40, 159, 64, 0.7)',
        'rgba(210, 199, 199, 0.7)'
    ];
    
    for (var i = 0; i < datasets.length; i++) {
        datasets[i].backgroundColor = colors[i % colors.length];
        datasets[i].borderColor = colors[i % colors.length].replace('0.7', '1');
        datasets[i].borderWidth = 2;
        datasets[i].tension = 0.3;
    }
    
    var performanceCtx = document.getElementById('performanceTrendChart');
    var performanceChart = new Chart(performanceCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Subject-wise Performance Across Exams'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Marks'
                    }
                }
            }
        }
    });
    
    // GPA Chart
    var gpaData = @json(array_column($performanceData['overall_performance'], 'average_gpa'));
    var gpaLabels = @json(array_column($performanceData['overall_performance'], 'exam'));
    
    var gpaCtx = document.getElementById('gpaChart');
    var gpaChart = new Chart(gpaCtx, {
        type: 'bar',
        data: {
            labels: gpaLabels,
            datasets: [{
                label: 'GPA',
                data: gpaData,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
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
                    text: 'GPA Trend Across Exams'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    title: {
                        display: true,
                        text: 'GPA'
                    }
                }
            }
        }
    });
    
    // Individual Subject Charts
    @foreach($performanceData['datasets'] as $index => $dataset)
        var subjectCtx{{ $index }} = document.getElementById('subjectChart{{ $index }}');
        var subjectChart{{ $index }} = new Chart(subjectCtx{{ $index }}, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '{{ $dataset['label'] }}',
                    data: @json($dataset['data']),
                    backgroundColor: '{{ $colors[$index % count($colors)] }}',
                    borderColor: '{{ str_replace('0.7', '1', $colors[$index % count($colors)]) }}',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    @endforeach
</script>
@endif
@endsection