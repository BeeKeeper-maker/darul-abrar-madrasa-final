@extends('layouts.app')

@section('title', 'Class Performance Analytics')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Class Performance Analytics</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active">Class Performance Analytics</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter Options
        </div>
        <div class="card-body">
            <form action="{{ route('reports.class-performance-analytics') }}" method="GET" class="row g-3">
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
                    <button type="submit" class="btn btn-primary w-100">Generate Analytics</button>
                </div>
            </form>
        </div>
    </div>

    @if($analyticsData)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-chart-bar me-1"></i>
                    Class Performance Overview
                </div>
                <div>
                    <form action="{{ route('reports.export-pdf') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="class_performance">
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="exam_id" value="{{ $selectedExamId }}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export as PDF
                        </button>
                    </form>
                    <form action="{{ route('reports.export-excel') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="class_performance">
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
                        <h5>Exam: {{ $analyticsData['exam']->name }}</h5>
                        <h5>Class: {{ $analyticsData['class']->name }}</h5>
                        <h5>Department: {{ $analyticsData['class']->department->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <h6 class="text-muted">Total Students</h6>
                                <h3>{{ $analyticsData['total_students'] }}</h3>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 class="text-muted">Pass Rate</h6>
                                <h3 class="text-success">{{ $analyticsData['pass_rate'] }}%</h3>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 class="text-muted">Average GPA</h6>
                                <h3>{{ $analyticsData['average_gpa'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                Pass/Fail Distribution
                            </div>
                            <div class="card-body">
                                <canvas id="passFailChart" width="100%" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                Grade Distribution
                            </div>
                            <div class="card-body">
                                <canvas id="gradeDistributionChart" width="100%" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-line me-1"></i>
                Subject-wise Performance Analysis
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <canvas id="subjectPerformanceChart" width="100%" height="300"></canvas>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Subject</th>
                                <th>Total Students</th>
                                <th>Passed</th>
                                <th>Failed</th>
                                <th>Pass Rate</th>
                                <th>Average Mark</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($analyticsData['subject_performance'] as $performance)
                                <tr>
                                    <td>{{ $performance['subject'] }}</td>
                                    <td>{{ $performance['total_students'] }}</td>
                                    <td class="text-success">{{ $performance['passed_students'] }}</td>
                                    <td class="text-danger">{{ $performance['failed_students'] }}</td>
                                    <td>{{ $performance['pass_rate'] }}%</td>
                                    <td>{{ $performance['average_mark'] }}</td>
                                    <td>
                                        @php
                                            $passRate = $performance['pass_rate'];
                                            $badgeClass = 'bg-danger';
                                            $performanceText = 'Poor';
                                            
                                            if ($passRate >= 90) {
                                                $badgeClass = 'bg-success';
                                                $performanceText = 'Excellent';
                                            } elseif ($passRate >= 75) {
                                                $badgeClass = 'bg-primary';
                                                $performanceText = 'Very Good';
                                            } elseif ($passRate >= 60) {
                                                $badgeClass = 'bg-info';
                                                $performanceText = 'Good';
                                            } elseif ($passRate >= 40) {
                                                $badgeClass = 'bg-warning';
                                                $performanceText = 'Average';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $performanceText }}</span>
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
                <i class="fas fa-chart-pie me-1"></i>
                Performance Insights
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                Performance Distribution
                            </div>
                            <div class="card-body">
                                @php
                                    // Calculate performance distribution
                                    $excellentCount = 0;
                                    $veryGoodCount = 0;
                                    $goodCount = 0;
                                    $averageCount = 0;
                                    $poorCount = 0;
                                    
                                    foreach ($analyticsData['subject_performance'] as $performance) {
                                        $passRate = $performance['pass_rate'];
                                        
                                        if ($passRate >= 90) {
                                            $excellentCount++;
                                        } elseif ($passRate >= 75) {
                                            $veryGoodCount++;
                                        } elseif ($passRate >= 60) {
                                            $goodCount++;
                                        } elseif ($passRate >= 40) {
                                            $averageCount++;
                                        } else {
                                            $poorCount++;
                                        }
                                    }
                                    
                                    $totalSubjects = count($analyticsData['subject_performance']);
                                @endphp

                                <canvas id="performanceDistributionChart" width="100%" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                Key Insights
                            </div>
                            <div class="card-body">
                                @php
                                    // Find best and worst performing subjects
                                    $bestSubject = null;
                                    $worstSubject = null;
                                    $bestPassRate = 0;
                                    $worstPassRate = 100;
                                    
                                    foreach ($analyticsData['subject_performance'] as $performance) {
                                        if ($performance['pass_rate'] > $bestPassRate) {
                                            $bestPassRate = $performance['pass_rate'];
                                            $bestSubject = $performance['subject'];
                                        }
                                        
                                        if ($performance['pass_rate'] < $worstPassRate) {
                                            $worstPassRate = $performance['pass_rate'];
                                            $worstSubject = $performance['subject'];
                                        }
                                    }
                                    
                                    // Calculate overall class performance
                                    $overallPerformance = 'Average';
                                    $overallPassRate = $analyticsData['pass_rate'];
                                    
                                    if ($overallPassRate >= 90) {
                                        $overallPerformance = 'Excellent';
                                    } elseif ($overallPassRate >= 75) {
                                        $overallPerformance = 'Very Good';
                                    } elseif ($overallPassRate >= 60) {
                                        $overallPerformance = 'Good';
                                    } elseif ($overallPassRate < 40) {
                                        $overallPerformance = 'Poor';
                                    }
                                @endphp

                                <div class="alert alert-primary">
                                    <h5 class="alert-heading">Overall Class Performance: {{ $overallPerformance }}</h5>
                                    <p>The class has an overall pass rate of {{ $analyticsData['pass_rate'] }}% with an average GPA of {{ $analyticsData['average_gpa'] }}.</p>
                                </div>

                                <div class="alert alert-success">
                                    <h5 class="alert-heading">Best Performing Subject</h5>
                                    <p>{{ $bestSubject }} with a pass rate of {{ $bestPassRate }}%.</p>
                                </div>

                                <div class="alert alert-danger">
                                    <h5 class="alert-heading">Subject Needing Attention</h5>
                                    <p>{{ $worstSubject }} with a pass rate of {{ $worstPassRate }}%.</p>
                                </div>

                                <div class="alert alert-warning">
                                    <h5 class="alert-heading">Recommendations</h5>
                                    <ul>
                                        @if($worstPassRate < 60)
                                            <li>Consider remedial classes for {{ $worstSubject }}.</li>
                                        @endif
                                        
                                        @if($analyticsData['failed_students'] > 0)
                                            <li>Provide additional support for the {{ $analyticsData['failed_students'] }} students who failed.</li>
                                        @endif
                                        
                                        @if($overallPassRate < 75)
                                            <li>Review teaching methodologies to improve overall class performance.</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i>
            Please select a class and exam to generate the class performance analytics.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if($analyticsData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pass/Fail Chart
    var passFailCtx = document.getElementById('passFailChart');
    var passFailChart = new Chart(passFailCtx, {
        type: 'pie',
        data: {
            labels: ['Passed', 'Failed'],
            datasets: [{
                data: [{{ $analyticsData['passed_students'] }}, {{ $analyticsData['failed_students'] }}],
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
                }
            }
        }
    });

    // Grade Distribution Chart
    var gradeDistributionCtx = document.getElementById('gradeDistributionChart');
    var gradeDistributionChart = new Chart(gradeDistributionCtx, {
        type: 'bar',
        data: {
            labels: ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'],
            datasets: [{
                label: 'Number of Students',
                data: [
                    {{ $analyticsData['grade_distribution']['A+'] }},
                    {{ $analyticsData['grade_distribution']['A'] }},
                    {{ $analyticsData['grade_distribution']['A-'] }},
                    {{ $analyticsData['grade_distribution']['B+'] }},
                    {{ $analyticsData['grade_distribution']['B'] }},
                    {{ $analyticsData['grade_distribution']['B-'] }},
                    {{ $analyticsData['grade_distribution']['C+'] }},
                    {{ $analyticsData['grade_distribution']['C'] }},
                    {{ $analyticsData['grade_distribution']['C-'] }},
                    {{ $analyticsData['grade_distribution']['D+'] }},
                    {{ $analyticsData['grade_distribution']['D'] }},
                    {{ $analyticsData['grade_distribution']['F'] }}
                ],
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

    // Subject Performance Chart
    var subjects = [];
    var passRates = [];
    var averageMarks = [];

    @foreach($analyticsData['subject_performance'] as $performance)
        subjects.push('{{ $performance['subject'] }}');
        passRates.push({{ $performance['pass_rate'] }});
        averageMarks.push({{ $performance['average_mark'] }});
    @endforeach

    var subjectPerformanceCtx = document.getElementById('subjectPerformanceChart');
    var subjectPerformanceChart = new Chart(subjectPerformanceCtx, {
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

    // Performance Distribution Chart
    var performanceDistributionCtx = document.getElementById('performanceDistributionChart');
    var performanceDistributionChart = new Chart(performanceDistributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Excellent', 'Very Good', 'Good', 'Average', 'Poor'],
            datasets: [{
                data: [
                    {{ $excellentCount }},
                    {{ $veryGoodCount }},
                    {{ $goodCount }},
                    {{ $averageCount }},
                    {{ $poorCount }}
                ],
                backgroundColor: [
                    '#4caf50',
                    '#2196f3',
                    '#03a9f4',
                    '#ff9800',
                    '#f44336'
                ],
                hoverBackgroundColor: [
                    '#388e3c',
                    '#1976d2',
                    '#0288d1',
                    '#f57c00',
                    '#d32f2f'
                ],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var dataset = tooltipItem.dataset;
                            var total = dataset.data.reduce(function(previousValue, currentValue) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.dataIndex];
                            var percentage = Math.floor(((currentValue/total) * 100)+0.5);
                            return tooltipItem.label + ': ' + currentValue + ' subjects (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endif
@endsection