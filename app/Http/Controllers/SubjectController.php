<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::with(['class', 'teacher']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Get filter data
        $classes = ClassRoom::select('id', 'name')->orderBy('name')->get();
        $teachers = Teacher::with('user:id,name')->get();

        $subjects = $query->latest()->paginate(15)->withQueryString();

        return view('subjects.index', compact('subjects', 'classes', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = ClassRoom::select('id', 'name')->orderBy('name')->get();
        $teachers = Teacher::with('user:id,name')->get();

        return view('subjects.create', compact('classes', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'full_mark' => 'required|integer|min:1|max:1000',
            'pass_mark' => 'required|integer|min:1|max:1000',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'বিষয়ের নাম অবশ্যই দিতে হবে।',
            'code.required' => 'বিষয়ের কোড অবশ্যই দিতে হবে।',
            'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'class_id.required' => 'শ্রেণী নির্বাচন করুন।',
            'class_id.exists' => 'নির্বাচিত শ্রেণী বিদ্যমান নেই।',
            'teacher_id.exists' => 'নির্বাচিত শিক্ষক বিদ্যমান নেই।',
            'full_mark.required' => 'পূর্ণ নম্বর অবশ্যই দিতে হবে।',
            'full_mark.min' => 'পূর্ণ নম্বর ১ এর চেয়ে কম হতে পারবে না।',
            'pass_mark.required' => 'পাস নম্বর অবশ্যই দিতে হবে।',
            'pass_mark.min' => 'পাস নম্বর ১ এর চেয়ে কম হতে পারবে না।',
        ]);

        // Validate pass mark is not greater than full mark
        if ($validated['pass_mark'] >= $validated['full_mark']) {
            return back()
                ->withInput()
                ->withErrors(['pass_mark' => 'পাস নম্বর পূর্ণ নম্বরের চেয়ে কম হতে হবে।']);
        }

        $validated['is_active'] = $request->has('is_active');

        try {
            Subject::create($validated);
            
            return redirect()->route('subjects.index')
                ->with('success', 'বিষয়টি সফলভাবে তৈরি হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'বিষয় তৈরিতে সমস্যা হয়েছে। আবার চেষ্টা করুন।']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::with(['class', 'teacher.user', 'results.student.user'])
            ->findOrFail($id);

        // Get subject statistics
        $stats = [
            'total_students' => $subject->class->students()->count(),
            'total_results' => $subject->results()->count(),
            'average_marks' => $subject->results()->avg('marks') ?: 0,
            'pass_percentage' => $this->calculatePassPercentage($subject),
        ];

        return view('subjects.show', compact('subject', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        $classes = ClassRoom::select('id', 'name')->orderBy('name')->get();
        $teachers = Teacher::with('user:id,name')->get();

        return view('subjects.edit', compact('subject', 'classes', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code,' . $id,
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'full_mark' => 'required|integer|min:1|max:1000',
            'pass_mark' => 'required|integer|min:1|max:1000',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'বিষয়ের নাম অবশ্যই দিতে হবে।',
            'code.required' => 'বিষয়ের কোড অবশ্যই দিতে হবে।',
            'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'class_id.required' => 'শ্রেণী নির্বাচন করুন।',
            'class_id.exists' => 'নির্বাচিত শ্রেণী বিদ্যমান নেই।',
            'teacher_id.exists' => 'নির্বাচিত শিক্ষক বিদ্যমান নেই।',
            'full_mark.required' => 'পূর্ণ নম্বর অবশ্যই দিতে হবে।',
            'full_mark.min' => 'পূর্ণ নম্বর ১ এর চেয়ে কম হতে পারবে না।',
            'pass_mark.required' => 'পাস নম্বর অবশ্যই দিতে হবে।',
            'pass_mark.min' => 'পাস নম্বর ১ এর চেয়ে কম হতে পারবে না।',
        ]);

        // Validate pass mark is not greater than full mark
        if ($validated['pass_mark'] >= $validated['full_mark']) {
            return back()
                ->withInput()
                ->withErrors(['pass_mark' => 'পাস নম্বর পূর্ণ নম্বরের চেয়ে কম হতে হবে।']);
        }

        $validated['is_active'] = $request->has('is_active');

        try {
            $subject->update($validated);
            
            return redirect()->route('subjects.index')
                ->with('success', 'বিষয়টি সফলভাবে আপডেট হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'বিষয় আপডেটে সমস্যা হয়েছে। আবার চেষ্টা করুন।']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);

        // Check if subject has any results
        if ($subject->results()->count() > 0) {
            return redirect()->route('subjects.index')
                ->with('error', 'এই বিষয়ের ফলাফল রয়েছে, তাই মুছে ফেলা যাবে না।');
        }

        try {
            $subject->delete();
            
            return redirect()->route('subjects.index')
                ->with('success', 'বিষয়টি সফলভাবে মুছে ফেলা হয়েছে।');
        } catch (\Exception $e) {
            return redirect()->route('subjects.index')
                ->with('error', 'বিষয় মুছতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }

    /**
     * Toggle subject status (active/inactive).
     */
    public function toggleStatus(string $id)
    {
        $subject = Subject::findOrFail($id);
        
        try {
            $subject->update(['is_active' => !$subject->is_active]);
            
            $status = $subject->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';
            
            return redirect()->route('subjects.index')
                ->with('success', "বিষয়টি {$status} করা হয়েছে।");
        } catch (\Exception $e) {
            return redirect()->route('subjects.index')
                ->with('error', 'স্ট্যাটাস পরিবর্তনে সমস্যা হয়েছে।');
        }
    }

    /**
     * Get subjects by class (AJAX endpoint).
     */
    public function getByClass(Request $request)
    {
        $classId = $request->class_id;
        
        if (!$classId) {
            return response()->json(['subjects' => []]);
        }

        $subjects = Subject::where('class_id', $classId)
            ->where('is_active', true)
            ->select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json(['subjects' => $subjects]);
    }

    /**
     * Calculate pass percentage for a subject.
     */
    private function calculatePassPercentage(Subject $subject): float
    {
        $totalResults = $subject->results()->count();
        
        if ($totalResults == 0) {
            return 0;
        }

        $passedResults = $subject->results()
            ->where('marks', '>=', $subject->pass_mark)
            ->count();

        return round(($passedResults / $totalResults) * 100, 2);
    }

    /**
     * Bulk actions for subjects.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $subjects = Subject::whereIn('id', $request->subjects);

        try {
            switch ($request->action) {
                case 'activate':
                    $subjects->update(['is_active' => true]);
                    $message = 'নির্বাচিত বিষয়গুলি সক্রিয় করা হয়েছে।';
                    break;

                case 'deactivate':
                    $subjects->update(['is_active' => false]);
                    $message = 'নির্বাচিত বিষয়গুলি নিষ্ক্রিয় করা হয়েছে।';
                    break;

                case 'delete':
                    // Check if any subject has results
                    $subjectsWithResults = $subjects->has('results')->count();
                    if ($subjectsWithResults > 0) {
                        return redirect()->route('subjects.index')
                            ->with('error', 'কিছু বিষয়ের ফলাফল রয়েছে, তাই মুছে ফেলা যাবে না।');
                    }
                    
                    $subjects->delete();
                    $message = 'নির্বাচিত বিষয়গুলি মুছে ফেলা হয়েছে।';
                    break;
            }

            return redirect()->route('subjects.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('subjects.index')
                ->with('error', 'অপারেশনে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }
}
