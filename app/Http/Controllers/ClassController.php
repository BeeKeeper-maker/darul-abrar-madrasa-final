<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Department;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassRoom::with('department')->paginate(10);
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('classes.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'class_numeric' => 'required|integer|min:1|max:12',
            'section' => 'nullable|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        ClassRoom::create($request->all());

        return redirect()->route('classes.index')
            ->with('success', 'শ্রেণী সফলভাবে তৈরি করা হয়েছে।');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $class = ClassRoom::with(['department', 'students', 'subjects'])->findOrFail($id);
        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $class = ClassRoom::findOrFail($id);
        $departments = Department::where('is_active', true)->get();
        return view('classes.edit', compact('class', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $class = ClassRoom::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'class_numeric' => 'required|integer|min:1|max:12',
            'section' => 'nullable|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        $class->update($data);

        return redirect()->route('classes.index')
            ->with('success', 'শ্রেণীর তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $class = ClassRoom::findOrFail($id);
        
        // Check if class has students
        if ($class->students()->count() > 0) {
            return redirect()->route('classes.index')
                ->with('error', 'এই শ্রেণীতে ছাত্র-ছাত্রী আছে, তাই ডিলিট করা যাবে না।');
        }

        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'শ্রেণী সফলভাবে ডিলিট করা হয়েছে।');
    }
}
