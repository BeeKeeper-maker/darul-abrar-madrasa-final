<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Report</title>
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
        .passed {
            color: #38a169;
        }
        .failed {
            color: #e53e3e;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Darul Abrar Model Kamil Madrasa</h1>
        <h2>Academic Performance Report</h2>
        <p>Class: {{ $class->name }} | Exam: {{ $exam->name }}</p>
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
                <strong>Exam:</strong>
                <span>{{ $exam->name }}</span>
            </div>
            <div class="info-item">
                <strong>Exam Period:</strong>
                <span>{{ $exam->start_date->format('d M, Y') }} - {{ $exam->end_date->format('d M, Y') }}</span>
            </div>
            <div class="info-item">
                <strong>Total Students:</strong>
                <span>{{ count($performanceData) }}</span>
            </div>
            <div class="info-item">
                <strong>Report Generated:</strong>
                <span>{{ $generated_at }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Performance Overview</h3>
        @php
            $totalStudents = count($performanceData);
            $passedStudents = count(array_filter($performanceData, function($item) { return $item['final_result'] === 'PASSED'; }));
            $failedStudents = $totalStudents - $passedStudents;
            $passRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 2) : 0;
            
            // Calculate average GPA
            $totalGpa = 0;
            foreach ($performanceData as $result) {
                $totalGpa += $result['average_gpa'];
            }
            $averageGpa = $totalStudents > 0 ? round($totalGpa / $totalStudents, 2) : 0;
            
            // Grade distribution
            $gradeDistribution = [
                'A+' => 0, 'A' => 0, 'A-' => 0,
                'B+' => 0, 'B' => 0, 'B-' => 0,
                'C+' => 0, 'C' => 0, 'C-' => 0,
                'D+' => 0, 'D' => 0, 'F' => 0
            ];
            
            foreach ($performanceData as $result) {
                if (isset($gradeDistribution[$result['overall_grade']])) {
                    $gradeDistribution[$result['overall_grade']]++;
                }
            }
        @endphp
        
        <div class="info-grid">
            <div class="info-item">
                <strong>Passed Students:</strong>
                <span class="passed">{{ $passedStudents }}</span>
            </div>
            <div class="info-item">
                <strong>Failed Students:</strong>
                <span class="failed">{{ $failedStudents }}</span>
            </div>
            <div class="info-item">
                <strong>Pass Rate:</strong>
                <span>{{ $passRate }}%</span>
            </div>
            <div class="info-item">
                <strong>Average GPA:</strong>
                <span>{{ $averageGpa }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Class Rank List</h3>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Total Marks</th>
                    <th>GPA</th>
                    <th>Grade</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @foreach($performanceData as $studentId => $data)
                    <tr>
                        <td class="text-center">{{ $data['rank'] }}</td>
                        <td>{{ $data['student']->student_id }}</td>
                        <td>{{ $data['student']->name }}</td>
                        <td class="text-right">{{ $data['total_marks'] }}</td>
                        <td class="text-center">{{ $data['average_gpa'] }}</td>
                        <td class="text-center">{{ $data['overall_grade'] }}</td>
                        <td class="text-center {{ $data['final_result'] === 'PASSED' ? 'passed' : 'failed' }}">
                            {{ $data['final_result'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="info-section">
        <h3>Subject-wise Performance</h3>
        <table>
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
                        <td class="text-right">{{ $highestMark }}</td>
                        <td class="text-right">{{ $lowestMark }}</td>
                        <td class="text-right">{{ round($averageMark, 2) }}</td>
                        <td class="text-right">{{ round($passRate, 2) }}%</td>
                        <td class="text-right">{{ round($failRate, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="info-section">
        <h3>Grade Distribution</h3>
        <table>
            <thead>
                <tr>
                    <th>Grade</th>
                    <th>Number of Students</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gradeDistribution as $grade => $count)
                    @if($count > 0)
                        <tr>
                            <td>{{ $grade }}</td>
                            <td class="text-center">{{ $count }}</td>
                            <td class="text-right">{{ $totalStudents > 0 ? round(($count / $totalStudents) * 100, 2) : 0 }}%</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This is a computer-generated report and does not require a signature.</p>
        <p>Darul Abrar Model Kamil Madrasa - Academic Performance Report</p>
    </div>
</body>
</html>