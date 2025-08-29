@extends('layouts.app')

@section('title', 'Reporting Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Reporting Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Reports</li>
    </ol>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Students</h5>
                            <h2 class="mb-0">{{ $studentCount }}</h2>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-graduate fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('students.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Teachers</h5>
                            <h2 class="mb-0">{{ $teacherCount }}</h2>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chalkboard-teacher fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('teachers.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Classes</h5>
                            <h2 class="mb-0">{{ $classCount }}</h2>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-school fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('classes.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Departments</h5>
                            <h2 class="mb-0">{{ $departmentCount }}</h2>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-building fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('departments.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Fee Collection Summary (Current Month)
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Total Fees</h6>
                            <h3>৳{{ number_format($totalFees, 2) }}</h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Collected</h6>
                            <h3 class="text-success">৳{{ number_format($collectedFees, 2) }}</h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Pending</h6>
                            <h3 class="text-danger">৳{{ number_format($pendingFees, 2) }}</h3>
                        </div>
                    </div>
                    <div class="text-center">
                        <canvas id="feeCollectionChart" width="100%" height="40"></canvas>
                    </div>
                </div>
                <div class="card-footer small text-muted">
                    <a href="{{ route('reports.financial') }}" class="btn btn-sm btn-primary">View Detailed Financial Reports</a>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Attendance Summary (Current Month)
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Present</h6>
                            <h3 class="text-success">{{ $presentCount }}</h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Absent</h6>
                            <h3 class="text-danger">{{ $absentCount }}</h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Attendance Rate</h6>
                            <h3>{{ $attendanceRate }}%</h3>
                        </div>
                    </div>
                    <div class="text-center">
                        <canvas id="attendanceChart" width="100%" height="40"></canvas>
                    </div>
                </div>
                <div class="card-footer small text-muted">
                    <a href="{{ route('reports.attendance') }}" class="btn btn-sm btn-primary">View Detailed Attendance Reports</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Available Reports
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Academic Performance Reports</h5>
                                    <p class="card-text">View comprehensive academic performance reports including class rankings, subject-wise analysis, and student performance trends.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('reports.academic-performance') }}" class="btn btn-primary">View Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Student Performance Trends</h5>
                                    <p class="card-text">Track individual student performance across multiple exams and subjects to identify strengths and areas for improvement.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('reports.student-performance-trend') }}" class="btn btn-primary">View Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Class Performance Analytics</h5>
                                    <p class="card-text">Analyze class performance with detailed metrics, subject comparisons, and grade distributions.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('reports.class-performance-analytics') }}" class="btn btn-primary">View Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Attendance Reports</h5>
                                    <p class="card-text">View detailed attendance reports with monthly summaries, student-wise tracking, and attendance patterns.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('reports.attendance') }}" class="btn btn-primary">View Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Financial Reports</h5>
                                    <p class="card-text">Access comprehensive financial reports including fee collection summaries, outstanding fees, and payment trends.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('reports.financial') }}" class="btn btn-primary">View Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clipboard-list me-1"></i>
                    Recent Exams
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Class</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentExams as $exam)
                                <tr>
                                    <td>{{ $exam->name }}</td>
                                    <td>{{ $exam->class->name }}</td>
                                    <td>{{ $exam->start_date->format('d M, Y') }}</td>
                                    <td>{{ $exam->end_date->format('d M, Y') }}</td>
                                    <td>
                                        @if($exam->is_result_published)
                                            <span class="badge bg-success">Results Published</span>
                                        @elseif($exam->is_completed)
                                            <span class="badge bg-warning">Completed</span>
                                        @elseif($exam->is_ongoing)
                                            <span class="badge bg-primary">Ongoing</span>
                                        @else
                                            <span class="badge bg-info">Upcoming</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($exam->is_result_published)
                                            <a href="{{ route('reports.class-performance-analytics', ['exam_id' => $exam->id, 'class_id' => $exam->class_id]) }}" class="btn btn-sm btn-primary">View Results</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recent exams found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fee Collection Chart
    var feeCtx = document.getElementById('feeCollectionChart');
    var feeChart = new Chart(feeCtx, {
        type: 'pie',
        data: {
            labels: ['Collected', 'Pending'],
            datasets: [{
                data: [{{ $collectedFees }}, {{ $pendingFees }}],
                backgroundColor: ['#28a745', '#dc3545'],
                hoverBackgroundColor: ['#218838', '#c82333'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue/total) * 100)+0.5);
                        return data.labels[tooltipItem.index] + ': ৳' + currentValue + ' (' + percentage + '%)';
                    }
                }
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 70,
        },
    });

    // Attendance Chart
    var attendanceCtx = document.getElementById('attendanceChart');
    var attendanceChart = new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [{{ $presentCount }}, {{ $absentCount }}],
                backgroundColor: ['#28a745', '#dc3545'],
                hoverBackgroundColor: ['#218838', '#c82333'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue/total) * 100)+0.5);
                        return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                    }
                }
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 70,
        },
    });
</script>
@endsection