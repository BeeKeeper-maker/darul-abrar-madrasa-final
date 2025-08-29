<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4a5568;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2d3748;
            font-size: 24px;
        }
        .header h2 {
            margin: 5px 0;
            color: #4a5568;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            margin: 0 0 10px 0;
            color: #2d3748;
            font-size: 16px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }
        .info-grid {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        .info-item {
            width: 33%;
            margin-bottom: 10px;
        }
        .info-item strong {
            display: block;
            font-size: 14px;
            color: #4a5568;
        }
        .info-item span {
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f7fafc;
            font-weight: bold;
            color: #4a5568;
        }
        tr:nth-child(even) {
            background-color: #f7fafc;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
        .summary-box {
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f7fafc;
        }
        .summary-box h4 {
            margin: 0 0 10px 0;
            color: #2d3748;
            font-size: 14px;
        }
        .summary-grid {
            display: flex;
            flex-wrap: wrap;
        }
        .summary-item {
            width: 25%;
            text-align: center;
            padding: 10px 0;
        }
        .summary-item strong {
            display: block;
            font-size: 12px;
            color: #4a5568;
        }
        .summary-item span {
            font-size: 16px;
            font-weight: bold;
        }
        .collected {
            color: #2f855a;
        }
        .pending {
            color: #c53030;
        }
        .progress-bar {
            height: 10px;
            background-color: #edf2f7;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 3px;
        }
        .progress-fill {
            height: 100%;
            background-color: #4299e1;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Darul Abrar Model Kamil Madrasa</h1>
        <h2>Financial Report</h2>
        <p>{{ $title }}</p>
    </div>

    <div class="summary-box">
        <h4>Financial Summary</h4>
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Total Amount</strong>
                <span>৳{{ number_format($total_amount, 2) }}</span>
            </div>
            <div class="summary-item">
                <strong>Collected</strong>
                <span class="collected">৳{{ number_format($collected_amount, 2) }}</span>
            </div>
            <div class="summary-item">
                <strong>Pending</strong>
                <span class="pending">৳{{ number_format($pending_amount, 2) }}</span>
            </div>
            <div class="summary-item">
                <strong>Collection Rate</strong>
                <span>{{ $collection_rate }}%</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Fee Type Breakdown</h3>
        <table>
            <thead>
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
                @foreach($fee_type_breakdown as $feeType => $data)
                    <tr>
                        <td>{{ ucfirst($feeType) }}</td>
                        <td class="text-right">৳{{ number_format($data['total'], 2) }}</td>
                        <td class="text-right">৳{{ number_format($data['collected'], 2) }}</td>
                        <td class="text-right">৳{{ number_format($data['pending'], 2) }}</td>
                        <td class="text-right">
                            @php
                                $collectionRate = $data['total'] > 0 ? round(($data['collected'] / $data['total']) * 100, 2) : 0;
                            @endphp
                            {{ $collectionRate }}%
                        </td>
                        <td class="text-center">{{ $data['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th class="text-right">৳{{ number_format($total_amount, 2) }}</th>
                    <th class="text-right">৳{{ number_format($collected_amount, 2) }}</th>
                    <th class="text-right">৳{{ number_format($pending_amount, 2) }}</th>
                    <th class="text-right">{{ $collection_rate }}%</th>
                    <th class="text-center">{{ $total_transactions }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="info-section">
        <h3>Fee Status Distribution</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paid</td>
                    <td class="text-center">{{ $status_breakdown['paid'] }}</td>
                    <td class="text-right">{{ $total_transactions > 0 ? round(($status_breakdown['paid'] / $total_transactions) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Partial</td>
                    <td class="text-center">{{ $status_breakdown['partial'] }}</td>
                    <td class="text-right">{{ $total_transactions > 0 ? round(($status_breakdown['partial'] / $total_transactions) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Unpaid</td>
                    <td class="text-center">{{ $status_breakdown['unpaid'] }}</td>
                    <td class="text-right">{{ $total_transactions > 0 ? round(($status_breakdown['unpaid'] / $total_transactions) * 100, 2) : 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="info-section">
        <h3>Fee Transactions</h3>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Fee Type</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fees as $fee)
                    <tr>
                        <td>{{ $fee->student->student_id }}</td>
                        <td>{{ $fee->student->name }}</td>
                        <td>{{ ucfirst($fee->fee_type) }}</td>
                        <td class="text-right">৳{{ number_format($fee->amount, 2) }}</td>
                        <td class="text-right">৳{{ number_format($fee->paid_amount, 2) }}</td>
                        <td class="text-right">৳{{ number_format($fee->amount - $fee->paid_amount, 2) }}</td>
                        <td class="text-center">
                            @if($fee->status === 'paid')
                                Paid
                            @elseif($fee->status === 'partial')
                                Partial
                            @else
                                Unpaid
                            @endif
                        </td>
                        <td>{{ $fee->due_date->format('d M, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="info-section">
        <h3>Collection Analysis</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Total Transactions:</strong>
                <span>{{ $total_transactions }}</span>
            </div>
            <div class="info-item">
                <strong>Paid Transactions:</strong>
                <span>{{ $status_breakdown['paid'] }}</span>
            </div>
            <div class="info-item">
                <strong>Partial Payments:</strong>
                <span>{{ $status_breakdown['partial'] }}</span>
            </div>
            <div class="info-item">
                <strong>Unpaid Fees:</strong>
                <span>{{ $status_breakdown['unpaid'] }}</span>
            </div>
            <div class="info-item">
                <strong>Average Collection Rate:</strong>
                <span>{{ $collection_rate }}%</span>
            </div>
            <div class="info-item">
                <strong>Report Generated:</strong>
                <span>{{ $generated_at }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated report and does not require a signature.</p>
        <p>Darul Abrar Model Kamil Madrasa - Financial Report</p>
    </div>
</body>
</html>