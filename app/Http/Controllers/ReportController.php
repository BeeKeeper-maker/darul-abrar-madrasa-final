<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Fee;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the reporting dashboard.
     */
    public function index()
    {
        // Get counts for dashboard
        $studentCount = Student::where('is_active', true)->count();
        $teacherCount = Teacher::where('is_active', true)->count();
        $classCount = ClassRoom::count();
        $departmentCount = Department::count();
        
        // Get recent exams
        $recentExams = Exam::latest('end_date')->take(5)->get();
        
        // Get fee collection summary for current month
        $currentMonthFees = Fee::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
        
        $totalFees = $currentMonthFees->sum('amount');
        $collectedFees = $currentMonthFees->sum('paid_amount');
        $pendingFees = $totalFees - $collectedFees;
        
        // Get attendance summary for current month
        $currentMonthAttendance = Attendance::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get();
        
        $totalAttendance = $currentMonthAttendance->count();
        $presentCount = $currentMonthAttendance->where('status', 'present')->count();
        $absentCount = $currentMonthAttendance->where('status', 'absent')->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 2) : 0;
        
        return view('reports.index', compact(
            'studentCount',
            'teacherCount',
            'classCount',
            'departmentCount',
            'recentExams',
            'totalFees',
            'collectedFees',
            'pendingFees',
            'attendanceRate',
            'presentCount',
            'absentCount'
        ));
    }

    /**
     * Display academic performance report.
     */
    public function academicPerformance(Request $request)
    {
        $classes = ClassRoom::with('department')->get();
        $exams = Exam::where('is_result_published', true)->get();
        
        $selectedClassId = $request->input('class_id');
        $selectedExamId = $request->input('exam_id');
        
        $performanceData = null;
        $subjects = collect();
        $students = collect();
        
        if ($selectedClassId && $selectedExamId) {
            $exam = Exam::findOrFail($selectedExamId);
            $subjects = Subject::where('class_id', $selectedClassId)->get();
            $students = Student::where('class_id', $selectedClassId)
                ->where('is_active', true)
                ->with('user')
                ->get();
            
            // Get class rank list
            $performanceData = $exam->getClassRankList();
        }
        
        return view('reports.academic-performance', compact(
            'classes',
            'exams',
            'selectedClassId',
            'selectedExamId',
            'performanceData',
            'subjects',
            'students'
        ));
    }

    /**
     * Display student performance trend report.
     */
    public function studentPerformanceTrend(Request $request)
    {
        $students = Student::with('user')->where('is_active', true)->get();
        $selectedStudentId = $request->input('student_id');
        
        $performanceData = null;
        $labels = [];
        $datasets = [];
        
        if ($selectedStudentId) {
            $student = Student::findOrFail($selectedStudentId);
            
            // Get all exams for this student's class with published results
            $exams = Exam::where('class_id', $student->class_id)
                ->where('is_result_published', true)
                ->orderBy('start_date')
                ->get();
            
            if ($exams->count() > 0) {
                // Prepare data for chart
                $labels = $exams->pluck('name')->toArray();
                
                // Get subjects
                $subjects = Subject::where('class_id', $student->class_id)->get();
                
                foreach ($subjects as $subject) {
                    $marks = [];
                    
                    foreach ($exams as $exam) {
                        $result = Result::where('student_id', $selectedStudentId)
                            ->where('exam_id', $exam->id)
                            ->where('subject_id', $subject->id)
                            ->first();
                        
                        $marks[] = $result ? $result->marks_obtained : 0;
                    }
                    
                    $datasets[] = [
                        'label' => $subject->name,
                        'data' => $marks
                    ];
                }
                
                // Get overall performance
                $overallPerformance = [];
                
                foreach ($exams as $exam) {
                    $results = Result::where('student_id', $selectedStudentId)
                        ->where('exam_id', $exam->id)
                        ->get();
                    
                    $totalMarks = $results->sum('marks_obtained');
                    $totalSubjects = $results->count();
                    $averageGpa = $results->avg('gpa_point');
                    
                    $overallPerformance[] = [
                        'exam' => $exam->name,
                        'total_marks' => $totalMarks,
                        'average_gpa' => round($averageGpa, 2),
                        'subjects' => $totalSubjects
                    ];
                }
                
                $performanceData = [
                    'student' => $student,
                    'exams' => $exams,
                    'labels' => $labels,
                    'datasets' => $datasets,
                    'overall_performance' => $overallPerformance
                ];
            }
        }
        
        return view('reports.student-performance-trend', compact(
            'students',
            'selectedStudentId',
            'performanceData'
        ));
    }

    /**
     * Display class performance analytics.
     */
    public function classPerformanceAnalytics(Request $request)
    {
        $classes = ClassRoom::with('department')->get();
        $exams = Exam::where('is_result_published', true)->get();
        
        $selectedClassId = $request->input('class_id');
        $selectedExamId = $request->input('exam_id');
        
        $analyticsData = null;
        
        if ($selectedClassId && $selectedExamId) {
            $class = ClassRoom::findOrFail($selectedClassId);
            $exam = Exam::findOrFail($selectedExamId);
            $subjects = Subject::where('class_id', $selectedClassId)->get();
            
            // Get subject-wise performance
            $subjectPerformance = [];
            
            foreach ($subjects as $subject) {
                $results = Result::where('exam_id', $selectedExamId)
                    ->where('subject_id', $subject->id)
                    ->get();
                
                $totalStudents = $results->count();
                $passedStudents = $results->where('is_passed', true)->count();
                $failedStudents = $totalStudents - $passedStudents;
                $passRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 2) : 0;
                $averageMark = $totalStudents > 0 ? round($results->avg('marks_obtained'), 2) : 0;
                
                $subjectPerformance[] = [
                    'subject' => $subject->name,
                    'total_students' => $totalStudents,
                    'passed_students' => $passedStudents,
                    'failed_students' => $failedStudents,
                    'pass_rate' => $passRate,
                    'average_mark' => $averageMark
                ];
            }
            
            // Get overall class performance
            $classResults = $exam->getClassRankList();
            $totalStudents = count($classResults);
            $passedStudents = count(array_filter($classResults, function($result) {
                return $result['final_result'] === 'PASSED';
            }));
            $failedStudents = $totalStudents - $passedStudents;
            $passRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 2) : 0;
            
            // Calculate average GPA
            $totalGpa = 0;
            foreach ($classResults as $result) {
                $totalGpa += $result['average_gpa'];
            }
            $averageGpa = $totalStudents > 0 ? round($totalGpa / $totalStudents, 2) : 0;
            
            // Get grade distribution
            $gradeDistribution = [
                'A+' => 0, 'A' => 0, 'A-' => 0,
                'B+' => 0, 'B' => 0, 'B-' => 0,
                'C+' => 0, 'C' => 0, 'C-' => 0,
                'D+' => 0, 'D' => 0, 'F' => 0
            ];
            
            foreach ($classResults as $result) {
                if (isset($gradeDistribution[$result['overall_grade']])) {
                    $gradeDistribution[$result['overall_grade']]++;
                }
            }
            
            $analyticsData = [
                'class' => $class,
                'exam' => $exam,
                'subject_performance' => $subjectPerformance,
                'total_students' => $totalStudents,
                'passed_students' => $passedStudents,
                'failed_students' => $failedStudents,
                'pass_rate' => $passRate,
                'average_gpa' => $averageGpa,
                'grade_distribution' => $gradeDistribution
            ];
        }
        
        return view('reports.class-performance-analytics', compact(
            'classes',
            'exams',
            'selectedClassId',
            'selectedExamId',
            'analyticsData'
        ));
    }

    /**
     * Display attendance report.
     */
    public function attendanceReport(Request $request)
    {
        $classes = ClassRoom::with('department')->get();
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
        
        $currentYear = now()->year;
        $years = range($currentYear - 2, $currentYear);
        
        $selectedClassId = $request->input('class_id');
        $selectedMonth = $request->input('month', now()->format('m'));
        $selectedYear = $request->input('year', $currentYear);
        
        $attendanceData = null;
        
        if ($selectedClassId) {
            $class = ClassRoom::findOrFail($selectedClassId);
            $students = Student::where('class_id', $selectedClassId)
                ->where('is_active', true)
                ->with('user')
                ->get();
            
            // Get all dates in the selected month
            $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->daysInMonth;
            $dates = [];
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::createFromDate($selectedYear, $selectedMonth, $day);
                
                // Skip weekends (Friday and Saturday in Islamic context)
                if ($date->dayOfWeek !== Carbon::FRIDAY && $date->dayOfWeek !== Carbon::SATURDAY) {
                    $dates[] = $date->format('Y-m-d');
                }
            }
            
            // Get attendance records for each student
            $studentAttendance = [];
            
            foreach ($students as $student) {
                $attendanceRecords = Attendance::where('student_id', $student->id)
                    ->whereYear('date', $selectedYear)
                    ->whereMonth('date', $selectedMonth)
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->date->format('Y-m-d');
                    });
                
                $records = [];
                $presentCount = 0;
                $absentCount = 0;
                $lateCount = 0;
                
                foreach ($dates as $date) {
                    $record = $attendanceRecords->get($date);
                    $status = $record ? $record->status : 'N/A';
                    
                    if ($status === 'present') {
                        $presentCount++;
                    } elseif ($status === 'absent') {
                        $absentCount++;
                    } elseif ($status === 'late') {
                        $lateCount++;
                        $presentCount++; // Count late as present for percentage calculation
                    }
                    
                    $records[$date] = $status;
                }
                
                $totalDays = count($dates);
                $attendancePercentage = $totalDays > 0 ? round(($presentCount / $totalDays) * 100, 2) : 0;
                
                $studentAttendance[] = [
                    'student' => $student,
                    'records' => $records,
                    'present_count' => $presentCount,
                    'absent_count' => $absentCount,
                    'late_count' => $lateCount,
                    'attendance_percentage' => $attendancePercentage
                ];
            }
            
            // Sort by attendance percentage (descending)
            usort($studentAttendance, function ($a, $b) {
                return $b['attendance_percentage'] <=> $a['attendance_percentage'];
            });
            
            $attendanceData = [
                'class' => $class,
                'dates' => $dates,
                'student_attendance' => $studentAttendance
            ];
        }
        
        return view('reports.attendance', compact(
            'classes',
            'months',
            'years',
            'selectedClassId',
            'selectedMonth',
            'selectedYear',
            'attendanceData'
        ));
    }

    /**
     * Display financial report.
     */
    public function financialReport(Request $request)
    {
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
        
        $currentYear = now()->year;
        $years = range($currentYear - 2, $currentYear);
        
        $reportType = $request->input('report_type', 'monthly');
        $selectedMonth = $request->input('month', now()->format('m'));
        $selectedYear = $request->input('year', $currentYear);
        $selectedQuarter = $request->input('quarter', 1);
        
        $reportData = null;
        
        if ($reportType === 'monthly') {
            // Monthly report
            $fees = Fee::whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $selectedMonth)
                ->get();
            
            $reportData = $this->generateFinancialReportData($fees, "Monthly Report: {$months[$selectedMonth]} {$selectedYear}");
        } elseif ($reportType === 'quarterly') {
            // Quarterly report
            $startMonth = ($selectedQuarter - 1) * 3 + 1;
            $endMonth = $startMonth + 2;
            
            $fees = Fee::whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', '>=', $startMonth)
                ->whereMonth('created_at', '<=', $endMonth)
                ->get();
            
            $reportData = $this->generateFinancialReportData($fees, "Quarterly Report: Q{$selectedQuarter} {$selectedYear}");
        } elseif ($reportType === 'yearly') {
            // Yearly report
            $fees = Fee::whereYear('created_at', $selectedYear)->get();
            
            $reportData = $this->generateFinancialReportData($fees, "Yearly Report: {$selectedYear}");
        }
        
        return view('reports.financial', compact(
            'months',
            'years',
            'reportType',
            'selectedMonth',
            'selectedYear',
            'selectedQuarter',
            'reportData'
        ));
    }

    /**
     * Generate financial report data.
     */
    private function generateFinancialReportData($fees, $title)
    {
        $totalAmount = $fees->sum('amount');
        $collectedAmount = $fees->sum('paid_amount');
        $pendingAmount = $totalAmount - $collectedAmount;
        $collectionRate = $totalAmount > 0 ? round(($collectedAmount / $totalAmount) * 100, 2) : 0;
        
        // Fee type breakdown
        $feeTypeBreakdown = $fees->groupBy('fee_type')
            ->map(function ($typeFees) {
                return [
                    'total' => $typeFees->sum('amount'),
                    'collected' => $typeFees->sum('paid_amount'),
                    'pending' => $typeFees->sum('amount') - $typeFees->sum('paid_amount'),
                    'count' => $typeFees->count()
                ];
            });
        
        // Payment method breakdown
        $paymentMethodBreakdown = $fees->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->map(function ($methodFees) {
                return [
                    'amount' => $methodFees->sum('paid_amount'),
                    'count' => $methodFees->count()
                ];
            });
        
        // Status breakdown
        $statusBreakdown = [
            'paid' => $fees->where('status', 'paid')->count(),
            'partial' => $fees->where('status', 'partial')->count(),
            'unpaid' => $fees->where('status', 'unpaid')->count()
        ];
        
        // Daily collection trend
        $dailyCollection = $fees->groupBy(function ($fee) {
            return $fee->created_at->format('Y-m-d');
        })->map(function ($dayFees) {
            return $dayFees->sum('paid_amount');
        });
        
        return [
            'title' => $title,
            'total_amount' => $totalAmount,
            'collected_amount' => $collectedAmount,
            'pending_amount' => $pendingAmount,
            'collection_rate' => $collectionRate,
            'fee_type_breakdown' => $feeTypeBreakdown,
            'payment_method_breakdown' => $paymentMethodBreakdown,
            'status_breakdown' => $statusBreakdown,
            'daily_collection' => $dailyCollection,
            'total_transactions' => $fees->count()
        ];
    }

    /**
     * Export report as PDF.
     */
    public function exportPdf(Request $request)
    {
        $reportType = $request->input('report_type');
        $data = [];
        
        switch ($reportType) {
            case 'academic_performance':
                $data = $this->prepareAcademicPerformanceData($request);
                $view = 'reports.pdf.academic-performance';
                $filename = 'academic_performance_report.pdf';
                break;
                
            case 'attendance':
                $data = $this->prepareAttendanceData($request);
                $view = 'reports.pdf.attendance';
                $filename = 'attendance_report.pdf';
                break;
                
            case 'financial':
                $data = $this->prepareFinancialData($request);
                $view = 'reports.pdf.financial';
                $filename = 'financial_report.pdf';
                break;
                
            default:
                return back()->with('error', 'Invalid report type');
        }
        
        $pdf = PDF::loadView($view, $data);
        return $pdf->download($filename);
    }

    /**
     * Prepare academic performance data for PDF export.
     */
    private function prepareAcademicPerformanceData(Request $request)
    {
        $classId = $request->input('class_id');
        $examId = $request->input('exam_id');
        
        $class = ClassRoom::findOrFail($classId);
        $exam = Exam::findOrFail($examId);
        $subjects = Subject::where('class_id', $classId)->get();
        
        // Get class rank list
        $performanceData = $exam->getClassRankList();
        
        return [
            'class' => $class,
            'exam' => $exam,
            'subjects' => $subjects,
            'performanceData' => $performanceData,
            'generated_at' => now()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Prepare attendance data for PDF export.
     */
    private function prepareAttendanceData(Request $request)
    {
        $classId = $request->input('class_id');
        $month = $request->input('month');
        $year = $request->input('year');
        
        $class = ClassRoom::findOrFail($classId);
        $students = Student::where('class_id', $classId)
            ->where('is_active', true)
            ->with('user')
            ->get();
        
        // Get all dates in the selected month
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $dates = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            
            // Skip weekends (Friday and Saturday in Islamic context)
            if ($date->dayOfWeek !== Carbon::FRIDAY && $date->dayOfWeek !== Carbon::SATURDAY) {
                $dates[] = $date->format('Y-m-d');
            }
        }
        
        // Get attendance records for each student
        $studentAttendance = [];
        
        foreach ($students as $student) {
            $attendanceRecords = Attendance::where('student_id', $student->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()
                ->keyBy(function ($item) {
                    return $item->date->format('Y-m-d');
                });
            
            $records = [];
            $presentCount = 0;
            $absentCount = 0;
            $lateCount = 0;
            
            foreach ($dates as $date) {
                $record = $attendanceRecords->get($date);
                $status = $record ? $record->status : 'N/A';
                
                if ($status === 'present') {
                    $presentCount++;
                } elseif ($status === 'absent') {
                    $absentCount++;
                } elseif ($status === 'late') {
                    $lateCount++;
                    $presentCount++; // Count late as present for percentage calculation
                }
                
                $records[$date] = $status;
            }
            
            $totalDays = count($dates);
            $attendancePercentage = $totalDays > 0 ? round(($presentCount / $totalDays) * 100, 2) : 0;
            
            $studentAttendance[] = [
                'student' => $student,
                'records' => $records,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'late_count' => $lateCount,
                'attendance_percentage' => $attendancePercentage
            ];
        }
        
        // Sort by attendance percentage (descending)
        usort($studentAttendance, function ($a, $b) {
            return $b['attendance_percentage'] <=> $a['attendance_percentage'];
        });
        
        $monthName = Carbon::createFromDate($year, $month, 1)->format('F');
        
        return [
            'class' => $class,
            'month' => $monthName,
            'year' => $year,
            'dates' => $dates,
            'student_attendance' => $studentAttendance,
            'generated_at' => now()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Prepare financial data for PDF export.
     */
    private function prepareFinancialData(Request $request)
    {
        $reportType = $request->input('report_type', 'monthly');
        $month = $request->input('month');
        $year = $request->input('year');
        $quarter = $request->input('quarter');
        
        $title = '';
        $fees = collect();
        
        if ($reportType === 'monthly') {
            // Monthly report
            $monthName = Carbon::createFromDate($year, $month, 1)->format('F');
            $title = "Monthly Financial Report: {$monthName} {$year}";
            
            $fees = Fee::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } elseif ($reportType === 'quarterly') {
            // Quarterly report
            $startMonth = ($quarter - 1) * 3 + 1;
            $endMonth = $startMonth + 2;
            
            $title = "Quarterly Financial Report: Q{$quarter} {$year}";
            
            $fees = Fee::whereYear('created_at', $year)
                ->whereMonth('created_at', '>=', $startMonth)
                ->whereMonth('created_at', '<=', $endMonth)
                ->get();
        } elseif ($reportType === 'yearly') {
            // Yearly report
            $title = "Yearly Financial Report: {$year}";
            
            $fees = Fee::whereYear('created_at', $year)->get();
        }
        
        $totalAmount = $fees->sum('amount');
        $collectedAmount = $fees->sum('paid_amount');
        $pendingAmount = $totalAmount - $collectedAmount;
        $collectionRate = $totalAmount > 0 ? round(($collectedAmount / $totalAmount) * 100, 2) : 0;
        
        // Fee type breakdown
        $feeTypeBreakdown = $fees->groupBy('fee_type')
            ->map(function ($typeFees) {
                return [
                    'total' => $typeFees->sum('amount'),
                    'collected' => $typeFees->sum('paid_amount'),
                    'pending' => $typeFees->sum('amount') - $typeFees->sum('paid_amount'),
                    'count' => $typeFees->count()
                ];
            });
        
        // Status breakdown
        $statusBreakdown = [
            'paid' => $fees->where('status', 'paid')->count(),
            'partial' => $fees->where('status', 'partial')->count(),
            'unpaid' => $fees->where('status', 'unpaid')->count()
        ];
        
        return [
            'title' => $title,
            'total_amount' => $totalAmount,
            'collected_amount' => $collectedAmount,
            'pending_amount' => $pendingAmount,
            'collection_rate' => $collectionRate,
            'fee_type_breakdown' => $feeTypeBreakdown,
            'status_breakdown' => $statusBreakdown,
            'fees' => $fees,
            'generated_at' => now()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Export report as Excel.
     */
    public function exportExcel(Request $request)
    {
        // This would be implemented with a package like Laravel Excel
        // For now, we'll redirect back with a message
        return back()->with('info', 'Excel export functionality will be implemented soon.');
    }
}