<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Reports routes - protected by auth and admin/teacher roles
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    // Main reports dashboard
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Academic performance reports
    Route::get('/reports/academic-performance', [ReportController::class, 'academicPerformance'])->name('reports.academic-performance');
    Route::get('/reports/student-performance-trend', [ReportController::class, 'studentPerformanceTrend'])->name('reports.student-performance-trend');
    Route::get('/reports/class-performance-analytics', [ReportController::class, 'classPerformanceAnalytics'])->name('reports.class-performance-analytics');
    
    // Attendance reports
    Route::get('/reports/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
    
    // Financial reports
    Route::get('/reports/financial', [ReportController::class, 'financialReport'])->name('reports.financial');
    
    // Export reports
    Route::post('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::post('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
});