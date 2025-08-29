@extends('layouts.app')

@section('title', 'Financial Report')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Financial Report</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active">Financial Report</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter Options
        </div>
        <div class="card-body">
            <form action="{{ route('reports.financial') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="report_type" class="form-label">Report Type</label>
                    <select class="form-select" id="report_type" name="report_type">
                        <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ $reportType == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="yearly" {{ $reportType == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>
                
                <div class="col-md-3 monthly-option {{ $reportType != 'monthly' ? 'd-none' : '' }}">
                    <label for="month" class="form-label">Month</label>
                    <select class="form-select" id="month" name="month">
                        @foreach($months as $key => $month)
                            <option value="{{ $key }}" {{ $selectedMonth == $key ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 quarterly-option {{ $reportType != 'quarterly' ? 'd-none' : '' }}">
                    <label for="quarter" class="form-label">Quarter</label>
                    <select class="form-select" id="quarter" name="quarter">
                        <option value="1" {{ $selectedQuarter == 1 ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                        <option value="2" {{ $selectedQuarter == 2 ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                        <option value="3" {{ $selectedQuarter == 3 ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                        <option value="4" {{ $selectedQuarter == 4 ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
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
                
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    @if($reportData)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-chart-line me-1"></i>
                    {{ $reportData['title'] }}
                </div>
                <div>
                    <form action="{{ route('reports.export-pdf') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="financial">
                        <input type="hidden" name="report_period" value="{{ $reportType }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <input type="hidden" name="quarter" value="{{ $selectedQuarter }}">
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export as PDF
                        </button>
                    </form>
                    <form action="{{ route('reports.export-excel') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="report_type" value="financial">
                        <input type="hidden" name="report_period" value="{{ $reportType }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <input type="hidden" name="quarter" value="{{ $selectedQuarter }}">
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel me-1"></i> Export as Excel
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <h6 class="mb-1">Total Amount</h6>
                                <h3 class="mb-0">৳{{ number_format($reportData['total_amount'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <h6 class="mb-1">Collected Amount</h6>
                                <h3 class="mb-0">৳{{ number_format($reportData['collected_amount'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <h6 class="mb-1">Pending Amount</h6>
                                <h3 class="mb-0">৳{{ number_format($reportData['pending_amount'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <h6 class="mb-1">Collection Rate</h6>
                                <h3 class="mb-0">{{ $reportData['collection_rate'] }}%</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                Collection Overview
                            </div>
                            <div class="card-body">
                                <canvas id="collectionOverviewChart" width="100%" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                Fee Status Distribution
                            </div>
                            <div class="card-body">
                                <canvas id="statusDistributionChart" width="100%" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Fee Type Breakdown
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <canvas id="feeTypeChart" width="100%" height="300"></canvas>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fee Type</th>
                                        <th>Total Amount</th>
                                        <th>Collected Amount</th>
                                        <th>Pending Amount</th>
                                        <th>Collection Rate</th>
                                        <th>Transactions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportData['fee_type_breakdown'] as $feeType => $data)
                                        <tr>
                                            <td>{{ ucfirst($feeType) }}</td>
                                            <td>৳{{ number_format($data['total'], 2) }}</td>
                                            <td>৳{{ number_format($data['collected'], 2) }}</td>
                                            <td>৳{{ number_format($data['pending'], 2) }}</td>
                                            <td>
                                                @php
                                                    $collectionRate = $data['total'] > 0 ? round(($data['collected'] / $data['total']) * 100, 2) : 0;
                                                @endphp
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $collectionRate }}%;" aria-valuenow="{{ $collectionRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>{{ $collectionRate }}%</small>
                                            </td>
                                            <td>{{ $data['count'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <th>Total</th>
                                        <th>৳{{ number_format($reportData['total_amount'], 2) }}</th>
                                        <th>৳{{ number_format($reportData['collected_amount'], 2) }}</th>
                                        <th>৳{{ number_format($reportData['pending_amount'], 2) }}</th>
                                        <th>{{ $reportData['collection_rate'] }}%</th>
                                        <th>{{ $reportData['total_transactions'] }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                @if(isset($reportData['payment_method_breakdown']) && count($reportData['payment_method_breakdown']) > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-credit-card me-1"></i>
                            Payment Method Analysis
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <canvas id="paymentMethodChart" width="100%" height="300"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <th>Amount</th>
                                                    <th>Transactions</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalAmount = array_sum(array_column($reportData['payment_method_breakdown'], 'amount'));
                                                @endphp
                                                @foreach($reportData['payment_method_breakdown'] as $method => $data)
                                                    <tr>
                                                        <td>{{ ucfirst($method) }}</td>
                                                        <td>৳{{ number_format($data['amount'], 2) }}</td>
                                                        <td>{{ $data['count'] }}</td>
                                                        <td>
                                                            @php
                                                                $percentage = $totalAmount > 0 ? round(($data['amount'] / $totalAmount) * 100, 2) : 0;
                                                            @endphp
                                                            {{ $percentage }}%
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($reportData['daily_collection']) && count($reportData['daily_collection']) > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Daily Collection Trend
                        </div>
                        <div class="card-body">
                            <canvas id="dailyCollectionChart" width="100%" height="300"></canvas>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i>
            Please select report parameters to generate the financial report.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Toggle filter options based on report type
    document.getElementById('report_type').addEventListener('change', function() {
        var reportType = this.value;
        
        // Hide all period-specific options
        document.querySelectorAll('.monthly-option, .quarterly-option').forEach(function(el) {
            el.classList.add('d-none');
        });
        
        // Show options for selected report type
        if (reportType === 'monthly') {
            document.querySelectorAll('.monthly-option').forEach(function(el) {
                el.classList.remove('d-none');
            });
        } else if (reportType === 'quarterly') {
            document.querySelectorAll('.quarterly-option').forEach(function(el) {
                el.classList.remove('d-none');
            });
        }
    });
</script>

@if($reportData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Collection Overview Chart
    var overviewCtx = document.getElementById('collectionOverviewChart');
    var overviewChart = new Chart(overviewCtx, {
        type: 'pie',
        data: {
            labels: ['Collected', 'Pending'],
            datasets: [{
                data: [{{ $reportData['collected_amount'] }}, {{ $reportData['pending_amount'] }}],
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
                    text: 'Fee Collection Overview'
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
                            return tooltipItem.label + ': ৳' + currentValue.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Status Distribution Chart
    var statusCtx = document.getElementById('statusDistributionChart');
    var statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Partial', 'Unpaid'],
            datasets: [{
                data: [
                    {{ $reportData['status_breakdown']['paid'] }},
                    {{ $reportData['status_breakdown']['partial'] }},
                    {{ $reportData['status_breakdown']['unpaid'] }}
                ],
                backgroundColor: ['#4caf50', '#ff9800', '#f44336'],
                hoverBackgroundColor: ['#388e3c', '#f57c00', '#d32f2f'],
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
                    text: 'Fee Status Distribution'
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
                            return tooltipItem.label + ': ' + currentValue + ' transactions (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Fee Type Chart
    var feeTypeLabels = [];
    var feeTypeTotals = [];
    var feeTypeCollected = [];
    var feeTypePending = [];

    @foreach($reportData['fee_type_breakdown'] as $feeType => $data)
        feeTypeLabels.push('{{ ucfirst($feeType) }}');
        feeTypeTotals.push({{ $data['total'] }});
        feeTypeCollected.push({{ $data['collected'] }});
        feeTypePending.push({{ $data['pending'] }});
    @endforeach

    var feeTypeCtx = document.getElementById('feeTypeChart');
    var feeTypeChart = new Chart(feeTypeCtx, {
        type: 'bar',
        data: {
            labels: feeTypeLabels,
            datasets: [
                {
                    label: 'Total',
                    data: feeTypeTotals,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Collected',
                    data: feeTypeCollected,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pending',
                    data: feeTypePending,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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
                    text: 'Fee Type Breakdown'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '৳' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    @if(isset($reportData['payment_method_breakdown']) && count($reportData['payment_method_breakdown']) > 0)
        // Payment Method Chart
        var methodLabels = [];
        var methodAmounts = [];
        var methodColors = [
            'rgba(75, 192, 192, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 99, 132, 0.7)'
        ];

        @foreach($reportData['payment_method_breakdown'] as $method => $data)
            methodLabels.push('{{ ucfirst($method) }}');
            methodAmounts.push({{ $data['amount'] }});
        @endforeach

        var paymentMethodCtx = document.getElementById('paymentMethodChart');
        var paymentMethodChart = new Chart(paymentMethodCtx, {
            type: 'pie',
            data: {
                labels: methodLabels,
                datasets: [{
                    data: methodAmounts,
                    backgroundColor: methodColors,
                    hoverBackgroundColor: methodColors.map(color => color.replace('0.7', '1')),
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    title: {
                        display: true,
                        text: 'Payment Method Distribution'
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
                                return tooltipItem.label + ': ৳' + currentValue.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    @endif

    @if(isset($reportData['daily_collection']) && count($reportData['daily_collection']) > 0)
        // Daily Collection Chart
        var dailyLabels = [];
        var dailyAmounts = [];

        @foreach($reportData['daily_collection'] as $date => $amount)
            dailyLabels.push('{{ \Carbon\Carbon::parse($date)->format('d M') }}');
            dailyAmounts.push({{ $amount }});
        @endforeach

        var dailyCollectionCtx = document.getElementById('dailyCollectionChart');
        var dailyCollectionChart = new Chart(dailyCollectionCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Daily Collection',
                    data: dailyAmounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
                    },
                    title: {
                        display: true,
                        text: 'Daily Collection Trend'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Collection: ৳' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '৳' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    @endif
</script>
@endif
@endsection