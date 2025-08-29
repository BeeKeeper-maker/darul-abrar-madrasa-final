<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
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
            font-size: 10px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 5px;
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
        .present {
            background-color: #c6f6d5;
            color: #22543d;
        }
        .absent {
            background-color: #fed7d7;
            color: #822727;
        }
        .late {
            background-color: #feebc8;
            color: #744210;
        }
        .page-break {
            page-break-after: always;
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
        .progress-fill.high {
            background-color: #48bb78;
        }
        .progress-fill.medium {
            background-color: #ecc94b;
        }
        .progress-fill.low {
            background-color: #f56565;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Darul Abrar Model Kamil Madrasa</h1>
        <h2>Monthly Attendance Report</h2>
        <p>Class: {{ $class->name }} | Month: {{ $month }} {{ $year }}</p>
    </div>

    <div class="info-section">
        <h3>Report Summary</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Class:</strong>
                <span>{{ $class->name }}</span>
            </div>
            <div class="info-item">
                <strong>Department:</strong>
                <span>{{ $class->department->name }}</span>
            </div>
            <div class="info-item">
                <strong>Month:</strong>
                <span>{{ $month }} {{ $year }}</span>
            </div>
            <div class="info-item">
                <strong>Working Days:</strong>
                <span>{{ count($dates) }}</span>
            </div>
            <div class="info-item">
                <strong>Total Students:</strong>
                <span>{{ count($student_attendance) }}</span>
            </div>
            <div class="info-item">
                <strong>Report Generated:</strong>
                <span>{{ $generated_at }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Attendance Overview</h3>
        @php
            $totalStudents = count($student_attendance);
            $totalDays = count($dates);
            $totalPossibleAttendances = $totalStudents * $totalDays;
            
            $totalPresent = 0;
            $totalAbsent = 0;
            $totalLate = 0;
            
            foreach ($student_attendance as $attendance) {
                $totalPresent += $attendance['present_count'];
                $totalAbsent += $attendance['absent_count'];
                $totalLate += $attendance['late_count'];
            }
            
            $overallAttendanceRate = $totalPossibleAttendances > 0 
                ? round(($totalPresent / $totalPossibleAttendances) * 100, 2) 
                : 0;
                
            // Calculate attendance distribution
            $excellentCount = 0;
            $goodCount = 0;
            $averageCount = 0;
            $poorCount = 0;
            $criticalCount = 0;
            
            foreach ($student_attendance as $attendance) {
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
        
        <div class="info-grid">
            <div class="info-item">
                <strong>Overall Attendance Rate:</strong>
                <span>{{ $overallAttendanceRate }}%</span>
            </div>
            <div class="info-item">
                <strong>Total Present:</strong>
                <span>{{ $totalPresent }}</span>
            </div>
            <div class="info-item">
                <strong>Total Absent:</strong>
                <span>{{ $totalAbsent }}</span>
            </div>
            <div class="info-item">
                <strong>Total Late:</strong>
                <span>{{ $totalLate }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Attendance Distribution</h3>
        <table>
            <thead>
                <tr>
                    <th>Attendance Range</th>
                    <th>Number of Students</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Excellent (90-100%)</td>
                    <td class="text-center">{{ $excellentCount }}</td>
                    <td class="text-right">{{ $totalStudents > 0 ? round(($excellentCount / $totalStudents) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Good (75-89%)</td>
                    <td class="text-center">{{ $goodCount }}</td>
                    <td class="text-right">{{ $totalStudents > 0 ? round(($goodCount / $totalStudents) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Average (60-74%)</td>
                    <td class="text-center">{{ $averageCount }}</td>
                    <td class="text-right">{{ $totalStudents > 0 ? round(($averageCount / $totalStudents) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Poor (40-59%)</td>
                    <td class="text-center">{{ $poorCount }}</td>
                    <td class="text-right">{{ $totalStudents > 0 ? round(($poorCount / $totalStudents) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Critical (Below 40%)</td>
                    <td class="text-center">{{ $criticalCount }}</td>
                    <td class="text-right">{{ $totalStudents > 0 ? round(($criticalCount / $totalStudents) * 100, 2) : 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="info-section">
        <h3>Student Attendance Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Late</th>
                    <th>Attendance %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student_attendance as $attendance)
                    <tr>
                        <td>{{ $attendance['student']->student_id }}</td>
                        <td>{{ $attendance['student']->name }}</td>
                        <td class="text-center">{{ $attendance['present_count'] }}</td>
                        <td class="text-center">{{ $attendance['absent_count'] }}</td>
                        <td class="text-center">{{ $attendance['late_count'] }}</td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <span style="width: 40px; text-align: right; margin-right: 5px;">{{ $attendance['attendance_percentage'] }}%</span>
                                <div class="progress-bar">
                                    @php
                                        $attendancePercentage = $attendance['attendance_percentage'];
                                        $progressClass = 'low';
                                        
                                        if ($attendancePercentage >= 90) {
                                            $progressClass = 'high';
                                        } elseif ($attendancePercentage >= 60) {
                                            $progressClass = 'medium';
                                        }
                                    @endphp
                                    <div class="progress-fill {{ $progressClass }}" style="width: {{ $attendancePercentage }}%;"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="info-section">
        <h3>Detailed Attendance Record</h3>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Student ID</th>
                    <th rowspan="2">Name</th>
                    @foreach($dates as $date)
                        <th>{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach($dates as $date)
                        <th>{{ \Carbon\Carbon::parse($date)->format('D') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($student_attendance as $attendance)
                    <tr>
                        <td>{{ $attendance['student']->student_id }}</td>
                        <td>{{ $attendance['student']->name }}</td>
                        @foreach($dates as $date)
                            <td class="text-center {{ 
                                $attendance['records'][$date] === 'present' ? 'present' : 
                                ($attendance['records'][$date] === 'absent' ? 'absent' : 
                                ($attendance['records'][$date] === 'late' ? 'late' : ''))
                            }}">
                                @if($attendance['records'][$date] === 'present')
                                    P
                                @elseif($attendance['records'][$date] === 'absent')
                                    A
                                @elseif($attendance['records'][$date] === 'late')
                                    L
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This is a computer-generated report and does not require a signature.</p>
        <p>Darul Abrar Model Kamil Madrasa - Monthly Attendance Report</p>
    </div>
</body>
</html>