@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Attendance Report</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active">Attendance Report</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter Options
        </div>
        <div class="card-body">
            <form action="{{ route('reports.attendance') }}" method="GET" class="row g-3">
                <div class="col-md-4">
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
                <div class="col-md-3">
                    <label for="month" class="form-label">Month</label>
                    <select class="form-select" id="month" name="month">
                        @foreach($months as $key => $month)
                            <option value="{{ $key }}" {{ $selectedMonth == $key ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-select" id="year" name="year">
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
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

    @if($attendanceData)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-calendar-check me-1"></i>
                    Attendance Summary
                </div>
                <div>
                    <form action="{{ route('reports.export-pdf') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="attendance">
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export as PDF
                        </button>
                    </form>
                    <form action="{{ route('reports.export-excel') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="attendance">
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel me-1"></i> Export as Excel
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Class: {{ $attendanceData['class']->name }}</h5>
                        <h5>Department: {{ $attendanceData['class']->department->name }}</h5>
                        <h5>Month: {{ $months[$selectedMonth] }}, {{ $selectedYear }}</h5>
                    </div>
                    <div class="col-md-6">
                        @php
                            $totalStudents = count($attendanceData['student_attendance']);
                            $totalDays = count($attendanceData['dates']);
                            $totalPossibleAttendances = $totalStudents * $totalDays;
                            
                            $totalPresent = 0;
                            $totalAbsent = 0;
                            $totalLate = 0;
                            
                            foreach ($attendanceData['student_attendance'] as $attendance) {
                                $totalPresent += $attendance['present_count'];
                                $totalAbsent += $attendance['absent_count'];
                                $totalLate += $attendance['late_count'];
                            }
                            
                            $overallAttendanceRate = $totalPossibleAttendances > 0 
                                ? round(($totalPresent / $totalPossibleAttendances) * 100, 2) 
                                : 0;
                        @endphp
                        
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Total Students:</strong> {{ $totalStudents }}</p>
                                    <p><strong>Working Days:</strong> {{ $totalDays }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Overall Attendance Rate:</strong> {{ $overallAttendanceRate }}%</p>
                                    <p><strong>Total Late Instances:</strong> {{ $totalLate }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <canvas id="attendanceOverviewChart" width="100%" height="300"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="dailyAttendanceChart" width="100%" height="300"></canvas>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2">Student ID</th>
                                <th rowspan="2">Name</th>
                                @foreach($attendanceData['dates'] as $date)
                                    <th>{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                                @endforeach
                                <th rowspan="2">Present</th>
                                <th rowspan="2">Absent</th>
                                <th rowspan="2">Late</th>
                                <th rowspan="2">Attendance %</th>
                            </tr>
                            <tr>
                                @foreach($attendanceData['dates'] as $date)
                                    <th>{{ \Carbon\Carbon::parse($date)->format('D') }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceData['student_attendance'] as $attendance)
                                <tr>
                                    <td>{{ $attendance['student']->student_id }}</td>
                                    <td>{{ $attendance['student']->name }}</td>
                                    @foreach($attendanceData['dates'] as $date)
                                        <td class="{{ 
                                            $attendance['records'][$date] === 'present' ? 'table-success' : 
                                            ($attendance['records'][$date] === 'absent' ? 'table-danger' : 
                                            ($attendance['records'][$date] === 'late' ? 'table-warning' : ''))
                                        }}">
                                            @if($attendance['records'][$date] === 'present')
                                                <i class="fas fa-check text-success"></i>
                                            @elseif($attendance['records'][$date] === 'absent')
                                                <i class="fas fa-times text-danger"></i>
                                            @elseif($attendance['records'][$date] === 'late')
                                                <i class="fas fa-clock text-warning"></i>
                                            @else
                                                <i class="fas fa-minus text-muted"></i>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>{{ $attendance['present_count'] }}</td>
                                    <td>{{ $attendance['absent_count'] }}</td>
                                    <td>{{ $attendance['late_count'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                                @php
                                                    $attendancePercentage = $attendance['attendance_percentage'];
                                                    $progressClass = 'bg-danger';
                                                    
                                                    if ($attendancePercentage >= 90) {
                                                        $progressClass = 'bg-success';
                                                    } elseif ($attendancePercentage >= 75) {
                                                        $progressClass = 'bg-primary';
                                                    } elseif ($attendancePercentage >= 60) {
                                                        $progressClass = 'bg-info';
                                                    } elseif ($attendancePercentage >= 40) {
                                                        $progressClass = 'bg-warning';
                                                    }
                                                @endphp
                                                <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $attendancePercentage }}%;" aria-valuenow="{{ $attendancePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span>{{ $attendancePercentage }}%</span>
                                        </div>
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
                Attendance Analysis
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                Attendance Distribution
                            </div>
                            <div class="card-body">
                                @php
                                    // Calculate attendance distribution
                                    $excellentCount = 0;
                                    $goodCount = 0;
                                    $averageCount = 0;
                                    $poorCount = 0;
                                    $criticalCount = 0;
                                    
                                    foreach ($attendanceData['student_attendance'] as $attendance) {
                                        $percentage = $attendance['attendance_percentage'];
                                        
                                        if ($percentage >= 90) {
                                            $excellentCount++;
                                        } elseif ($percentage >= 75) {
                                            $goodCount++;
                                        } elseif ($percentage >= 60) {
                                            $averageCount++;
                                        } elseif ($percentage >= 40) {
                                            $poorCount++;
                                        } else {
                                            $criticalCount++;
                                        }
                                    }
                                @endphp

                                <canvas id="attendanceDistributionChart" width="100%" height="300"></canvas>
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
                                    // Find students with perfect attendance
                                    $perfectAttendance = array_filter($attendanceData['student_attendance'], function($attendance) {
                                        return $attendance['attendance_percentage'] == 100;
                                    });
                                    
                                    // Find students with critical attendance
                                    $criticalAttendance = array_filter($attendanceData['student_attendance'], function($attendance) {
                                        return $attendance['attendance_percentage'] < 40;
                                    });
                                    
                                    // Calculate most absent day
                                    $dailyAbsences = [];
                                    foreach ($attendanceData['dates'] as $date) {
                                        $absences = 0;
                                        foreach ($attendanceData['student_attendance'] as $attendance) {
                                            if ($attendance['records'][$date] === 'absent') {
                                                $absences++;
                                            }
                                        }
                                        $dailyAbsences[$date] = $absences;
                                    }
                                    
                                    arsort($dailyAbsences);
                                    $mostAbsentDate = key($dailyAbsences);
                                    $mostAbsences = current($dailyAbsences);
                                    
                                    // Calculate most present day
                                    $dailyPresences = [];
                                    foreach ($attendanceData['dates'] as $date) {
                                        $presences = 0;
                                        foreach ($attendanceData['student_attendance'] as $attendance) {
                                            if ($attendance['records'][$date] === 'present') {
                                                $presences++;
                                            }
                                        }
                                        $dailyPresences[$date] = $presences;
                                    }
                                    
                                    arsort($dailyPresences);
                                    $mostPresentDate = key($dailyPresences);
                                    $mostPresences = current($dailyPresences);
                                @endphp

                                <div class="alert alert-primary">
                                    <h5 class="alert-heading">Overall Attendance Rate: {{ $overallAttendanceRate }}%</h5>
                                    <p>The class has an overall attendance rate of {{ $overallAttendanceRate }}% for the month of {{ $months[$selectedMonth] }}, {{ $selectedYear }}.</p>
                                </div>

                                <div class="alert alert-success">
                                    <h5 class="alert-heading">Perfect Attendance</h5>
                                    @if(count($perfectAttendance) > 0)
                                        <p>{{ count($perfectAttendance) }} student(s) had perfect attendance this month.</p>
                                    @else
                                        <p>No students had perfect attendance this month.</p>
                                    @endif
                                </div>

                                <div class="alert alert-danger">
                                    <h5 class="alert-heading">Critical Attendance</h5>
                                    @if(count($criticalAttendance) > 0)
                                        <p>{{ count($criticalAttendance) }} student(s) had critical attendance (below 40%) this month.</p>
                                    @else
                                        <p>No students had critical attendance this month.</p>
                                    @endif
                                </div>

                                <div class="alert alert-warning">
                                    <h5 class="alert-heading">Attendance Patterns</h5>
                                    <p>
                                        <strong>Day with Most Absences:</strong> 
                                        {{ \Carbon\Carbon::parse($mostAbsentDate)->format('D, d M') }} 
                                        ({{ $mostAbsences }} absences)
                                    </p>
                                    <p>
                                        <strong>Day with Best Attendance:</strong> 
                                        {{ \Carbon\Carbon::parse($mostPresentDate)->format('D, d M') }} 
                                        ({{ $mostPresences }} present)
                                    </p>
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
            Please select a class, month, and year to generate the attendance report.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if($attendanceData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attendance Overview Chart
    var overviewCtx = document.getElementById('attendanceOverviewChart');
    var overviewChart = new Chart(overviewCtx, {
        type: 'pie',
        data: {
            labels: ['Present', 'Absent', 'Late'],
            datasets: [{
                data: [{{ $totalPresent - $totalLate }}, {{ $totalAbsent }}, {{ $totalLate }}],
                backgroundColor: ['#4caf50', '#f44336', '#ff9800'],
                hoverBackgroundColor: ['#388e3c', '#d32f2f', '#f57c00'],
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
                    text: 'Attendance Overview'
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
                            return tooltipItem.label + ': ' + currentValue + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Daily Attendance Chart
    var dailyLabels = [];
    var presentData = [];
    var absentData = [];
    var lateData = [];

    @foreach($attendanceData['dates'] as $date)
        dailyLabels.push('{{ \Carbon\Carbon::parse($date)->format('d') }}');
        
        var presentCount = 0;
        var absentCount = 0;
        var lateCount = 0;
        
        @foreach($attendanceData['student_attendance'] as $attendance)
            @if(isset($attendance['records'][$date]))
                if ('{{ $attendance['records'][$date] }}' === 'present') {
                    presentCount++;
                } else if ('{{ $attendance['records'][$date] }}' === 'absent') {
                    absentCount++;
                } else if ('{{ $attendance['records'][$date] }}' === 'late') {
                    lateCount++;
                }
            @endif
        @endforeach
        
        presentData.push(presentCount);
        absentData.push(absentCount);
        lateData.push(lateCount);
    @endforeach

    var dailyCtx = document.getElementById('dailyAttendanceChart');
    var dailyChart = new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [
                {
                    label: 'Present',
                    data: presentData,
                    backgroundColor: 'rgba(76, 175, 80, 0.7)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Absent',
                    data: absentData,
                    backgroundColor: 'rgba(244, 67, 54, 0.7)',
                    borderColor: 'rgba(244, 67, 54, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Late',
                    data: lateData,
                    backgroundColor: 'rgba(255, 152, 0, 0.7)',
                    borderColor: 'rgba(255, 152, 0, 1)',
                    borderWidth: 1
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
                    text: 'Daily Attendance'
                }
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Attendance Distribution Chart
    var distributionCtx = document.getElementById('attendanceDistributionChart');
    var distributionChart = new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Excellent (90-100%)', 'Good (75-89%)', 'Average (60-74%)', 'Poor (40-59%)', 'Critical (<40%)'],
            datasets: [{
                data: [
                    {{ $excellentCount }},
                    {{ $goodCount }},
                    {{ $averageCount }},
                    {{ $poorCount }},
                    {{ $criticalCount }}
                ],
                backgroundColor: [
                    '#4caf50',
                    '#2196f3',
                    '#ff9800',
                    '#ff5722',
                    '#f44336'
                ],
                hoverBackgroundColor: [
                    '#388e3c',
                    '#1976d2',
                    '#f57c00',
                    '#e64a19',
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
                title: {
                    display: true,
                    text: 'Attendance Distribution'
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
                            return tooltipItem.label + ': ' + currentValue + ' students (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endif
@endsection