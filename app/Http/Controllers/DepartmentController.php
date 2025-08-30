<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Department::withCount('teachers');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $departments = $query->latest()->paginate(15)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:10|unique:departments,code',
            'head_of_department' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'budget' => 'nullable|numeric|min:0',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'is_active' => 'boolean',
        ], [
            'name.required' => 'বিভাগের নাম অবশ্যই দিতে হবে।',
            'name.unique' => 'এই নামের বিভাগ ইতিমধ্যে রয়েছে।',
            'code.required' => 'বিভাগের কোড অবশ্যই দিতে হবে।',
            'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'code.max' => 'কোড সর্বোচ্চ ১০ অক্ষরের হতে পারে।',
            'budget.numeric' => 'বাজেট সংখ্যায় হতে হবে।',
            'budget.min' => 'বাজেট ০ বা তার বেশি হতে হবে।',
            'established_year.integer' => 'প্রতিষ্ঠা বছর সংখ্যায় হতে হবে।',
            'established_year.min' => 'প্রতিষ্ঠা বছর ১৯০০ বা তার পরের হতে হবে।',
            'established_year.max' => 'প্রতিষ্ঠা বছর ' . date('Y') . ' বা তার আগের হতে হবে।',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            Department::create($validated);
            
            return redirect()->route('departments.index')
                ->with('success', 'বিভাগটি সফলভাবে তৈরি হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'বিভাগ তৈরিতে সমস্যা হয়েছে। আবার চেষ্টা করুন।']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::with(['teachers.user'])->findOrFail($id);

        // Get department statistics
        $stats = [
            'total_teachers' => $department->teachers()->count(),
            'active_teachers' => $department->teachers()->whereHas('user', function($q) {
                $q->where('is_active', true);
            })->count(),
            'total_students' => $this->getTotalStudentsInDepartment($department),
            'subjects_count' => $this->getSubjectsCountInDepartment($department),
        ];

        return view('departments.show', compact('department', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'code' => 'required|string|max:10|unique:departments,code,' . $id,
            'head_of_department' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'budget' => 'nullable|numeric|min:0',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'is_active' => 'boolean',
        ], [
            'name.required' => 'বিভাগের নাম অবশ্যই দিতে হবে।',
            'name.unique' => 'এই নামের বিভাগ ইতিমধ্যে রয়েছে।',
            'code.required' => 'বিভাগের কোড অবশ্যই দিতে হবে।',
            'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'code.max' => 'কোড সর্বোচ্চ ১০ অক্ষরের হতে পারে।',
            'budget.numeric' => 'বাজেট সংখ্যায় হতে হবে।',
            'budget.min' => 'বাজেট ০ বা তার বেশি হতে হবে।',
            'established_year.integer' => 'প্রতিষ্ঠা বছর সংখ্যায় হতে হবে।',
            'established_year.min' => 'প্রতিষ্ঠা বছর ১৯০০ বা তার পরের হতে হবে।',
            'established_year.max' => 'প্রতিষ্ঠা বছর ' . date('Y') . ' বা তার আগের হতে হবে।',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $department->update($validated);
            
            return redirect()->route('departments.index')
                ->with('success', 'বিভাগটি সফলভাবে আপডেট হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'বিভাগ আপডেটে সমস্যা হয়েছে। আবার চেষ্টা করুন।']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        // Check if department has any teachers
        if ($department->teachers()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'এই বিভাগে শিক্ষক রয়েছেন, তাই মুছে ফেলা যাবে না।');
        }

        try {
            $department->delete();
            
            return redirect()->route('departments.index')
                ->with('success', 'বিভাগটি সফলভাবে মুছে ফেলা হয়েছে।');
        } catch (\Exception $e) {
            return redirect()->route('departments.index')
                ->with('error', 'বিভাগ মুছতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }

    /**
     * Toggle department status (active/inactive).
     */
    public function toggleStatus(string $id)
    {
        $department = Department::findOrFail($id);
        
        try {
            $department->update(['is_active' => !$department->is_active]);
            
            $status = $department->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';
            
            return redirect()->route('departments.index')
                ->with('success', "বিভাগটি {$status} করা হয়েছে।");
        } catch (\Exception $e) {
            return redirect()->route('departments.index')
                ->with('error', 'স্ট্যাটাস পরিবর্তনে সমস্যা হয়েছে।');
        }
    }

    /**
     * Get departments list for API/AJAX calls.
     */
    public function getDepartments(Request $request)
    {
        $query = Department::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $departments = $query->select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json(['departments' => $departments]);
    }

    /**
     * Bulk actions for departments.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'departments' => 'required|array|min:1',
            'departments.*' => 'exists:departments,id',
        ]);

        $departments = Department::whereIn('id', $request->departments);

        try {
            switch ($request->action) {
                case 'activate':
                    $departments->update(['is_active' => true]);
                    $message = 'নির্বাচিত বিভাগগুলি সক্রিয় করা হয়েছে।';
                    break;

                case 'deactivate':
                    $departments->update(['is_active' => false]);
                    $message = 'নির্বাচিত বিভাগগুলি নিষ্ক্রিয় করা হয়েছে।';
                    break;

                case 'delete':
                    // Check if any department has teachers
                    $departmentsWithTeachers = $departments->has('teachers')->count();
                    if ($departmentsWithTeachers > 0) {
                        return redirect()->route('departments.index')
                            ->with('error', 'কিছু বিভাগে শিক্ষক রয়েছেন, তাই মুছে ফেলা যাবে না।');
                    }
                    
                    $departments->delete();
                    $message = 'নির্বাচিত বিভাগগুলি মুছে ফেলা হয়েছে।';
                    break;
            }

            return redirect()->route('departments.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('departments.index')
                ->with('error', 'অপারেশনে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }

    /**
     * Get total students count in a department.
     */
    private function getTotalStudentsInDepartment(Department $department): int
    {
        // Get all subjects taught by teachers from this department
        $subjectIds = $department->teachers()
            ->with('subjects')
            ->get()
            ->pluck('subjects')
            ->flatten()
            ->pluck('id')
            ->unique();

        if ($subjectIds->isEmpty()) {
            return 0;
        }

        // Get unique students enrolled in these subjects
        return \App\Models\Student::whereHas('class.subjects', function($query) use ($subjectIds) {
            $query->whereIn('subjects.id', $subjectIds);
        })->distinct()->count();
    }

    /**
     * Get subjects count in a department.
     */
    private function getSubjectsCountInDepartment(Department $department): int
    {
        return $department->teachers()
            ->with('subjects')
            ->get()
            ->pluck('subjects')
            ->flatten()
            ->unique('id')
            ->count();
    }

    /**
     * Generate department report.
     */
    public function generateReport(string $id)
    {
        $department = Department::with(['teachers.user', 'teachers.subjects.class'])
            ->findOrFail($id);

        // Compile department data
        $reportData = [
            'department' => $department,
            'teachers' => $department->teachers()->with('user')->get(),
            'total_students' => $this->getTotalStudentsInDepartment($department),
            'subjects_count' => $this->getSubjectsCountInDepartment($department),
            'generated_at' => now(),
        ];

        return view('departments.report', $reportData);
    }
}
