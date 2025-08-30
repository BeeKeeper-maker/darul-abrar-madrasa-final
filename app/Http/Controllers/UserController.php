<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        // Get role counts for statistics
        $roleStats = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        return view('users.index', compact('users', 'roleStats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = [
            'admin' => 'প্রশাসক',
            'teacher' => 'শিক্ষক',
            'student' => 'ছাত্র/ছাত্রী',
            'guardian' => 'অভিভাবক',
            'staff' => 'কর্মচারী'
        ];

        $departments = Department::where('is_active', true)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $classes = ClassRoom::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('users.create', compact('roles', 'departments', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,teacher,student,guardian,staff',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'নাম অবশ্যই দিতে হবে।',
            'email.required' => 'ইমেইল অবশ্যই দিতে হবে।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট দিন।',
            'email.unique' => 'এই ইমেইলটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'password.required' => 'পাসওয়ার্ড অবশ্যই দিতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিল নেই।',
            'role.required' => 'ভূমিকা নির্বাচন করুন।',
            'role.in' => 'অবৈধ ভূমিকা নির্বাচিত হয়েছে।',
            'avatar.image' => 'প্রোফাইল ছবি একটি ইমেজ ফাইল হতে হবে।',
            'avatar.max' => 'প্রোফাইল ছবি সর্বোচ্চ ২ এমবি হতে পারে।',
            'date_of_birth.before' => 'জন্ম তারিখ আজকের আগের হতে হবে।',
            'gender.in' => 'লিঙ্গ পুরুষ অথবা মহিলা নির্বাচন করুন।',
        ]);

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $validated['password'] = Hash::make($validated['password']);
            $validated['is_active'] = $request->has('is_active');

            $user = User::create($validated);

            // Create role-specific records
            $this->createRoleSpecificRecord($user, $request);

            return redirect()->route('users.index')
                ->with('success', 'ব্যবহারকারী সফলভাবে তৈরি হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'ব্যবহারকারী তৈরিতে সমস্যা হয়েছে। আবার চেষ্টা করুন।']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        // Load relationships based on role
        switch ($user->role) {
            case 'teacher':
                $user->load('teacher.department');
                break;
            case 'student':
                $user->load('student.class', 'student.guardian');
                break;
            case 'guardian':
                $user->load('guardian.children');
                break;
        }

        // Get user statistics based on role
        $stats = $this->getUserStats($user);

        return view('users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        $roles = [
            'admin' => 'প্রশাসক',
            'teacher' => 'শিক্ষক',
            'student' => 'ছাত্র/ছাত্রী',
            'guardian' => 'অভিভাবক',
            'staff' => 'কর্মচারী'
        ];

        $departments = Department::where('is_active', true)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $classes = ClassRoom::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('users.edit', compact('user', 'roles', 'departments', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,teacher,student,guardian,staff',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'নাম অবশ্যই দিতে হবে।',
            'email.required' => 'ইমেইল অবশ্যই দিতে হবে।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট দিন।',
            'email.unique' => 'এই ইমেইলটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'role.required' => 'ভূমিকা নির্বাচন করুন।',
            'role.in' => 'অবৈধ ভূমিকা নির্বাচিত হয়েছে।',
            'avatar.image' => 'প্রোফাইল ছবি একটি ইমেজ ফাইল হতে হবে।',
            'avatar.max' => 'প্রোফাইল ছবি সর্বোচ্চ ২ এমবি হতে পারে।',
            'date_of_birth.before' => 'জন্ম তারিখ আজকের আগের হতে হবে।',
            'gender.in' => 'লিঙ্গ পুরুষ অথবা মহিলা নির্বাচন করুন।',
        ]);

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $validated['is_active'] = $request->has('is_active');

            $user->update($validated);

            // Update role-specific records if role changed
            if ($user->wasChanged('role')) {
                $this->handleRoleChange($user, $user->getOriginal('role'), $user->role, $request);
            }

            return redirect()->route('users.index')
                ->with('success', 'ব্যবহারকারী সফলভাবে আপডেট হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'ব্যবহারকারী আপডেটে সমস্যা হয়েছে। আবার চেষ্টা করুন।']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin users (safety check)
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'শেষ প্রশাসক ব্যবহারকারী মুছে ফেলা যাবে না।');
        }

        try {
            // Delete avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Delete role-specific records
            $this->deleteRoleSpecificRecord($user);

            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'ব্যবহারকারী সফলভাবে মুছে ফেলা হয়েছে।');
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'ব্যবহারকারী মুছতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);
        
        try {
            $user->update(['is_active' => !$user->is_active]);
            
            $status = $user->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';
            
            return redirect()->route('users.index')
                ->with('success', "ব্যবহারকারী {$status} করা হয়েছে।");
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'স্ট্যাটাস পরিবর্তনে সমস্যা হয়েছে।');
        }
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'new_password.required' => 'নতুন পাসওয়ার্ড অবশ্যই দিতে হবে।',
            'new_password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিল নেই।',
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('users.show', $user->id)
                ->with('success', 'পাসওয়ার্ড সফলভাবে রিসেট হয়েছে।');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'পাসওয়ার্ড রিসেটে সমস্যা হয়েছে।']);
        }
    }

    /**
     * Bulk actions for users.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $request->users);

        try {
            switch ($request->action) {
                case 'activate':
                    $users->update(['is_active' => true]);
                    $message = 'নির্বাচিত ব্যবহারকারীগণ সক্রিয় করা হয়েছে।';
                    break;

                case 'deactivate':
                    $users->update(['is_active' => false]);
                    $message = 'নির্বাচিত ব্যবহারকারীগণ নিষ্ক্রিয় করা হয়েছে।';
                    break;

                case 'delete':
                    // Check if trying to delete all admin users
                    $adminCount = User::where('role', 'admin')->count();
                    $adminToDelete = $users->where('role', 'admin')->count();
                    
                    if ($adminCount <= $adminToDelete) {
                        return redirect()->route('users.index')
                            ->with('error', 'সব প্রশাসক ব্যবহারকারী মুছে ফেলা যাবে না।');
                    }
                    
                    // Delete avatars and role-specific records
                    foreach ($users->get() as $user) {
                        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                            Storage::disk('public')->delete($user->avatar);
                        }
                        $this->deleteRoleSpecificRecord($user);
                    }
                    
                    $users->delete();
                    $message = 'নির্বাচিত ব্যবহারকারীগণ মুছে ফেলা হয়েছে।';
                    break;
            }

            return redirect()->route('users.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'অপারেশনে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }

    /**
     * Create role-specific record for user.
     */
    private function createRoleSpecificRecord(User $user, Request $request)
    {
        switch ($user->role) {
            case 'teacher':
                if ($request->filled('department_id')) {
                    \App\Models\Teacher::create([
                        'user_id' => $user->id,
                        'employee_id' => 'TCH' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'department_id' => $request->department_id,
                        'designation' => $request->designation,
                        'qualification' => $request->qualification,
                        'experience' => $request->experience,
                        'salary' => $request->salary,
                        'joining_date' => $request->joining_date ?: now(),
                    ]);
                }
                break;

            case 'student':
                if ($request->filled('class_id')) {
                    \App\Models\Student::create([
                        'user_id' => $user->id,
                        'student_id' => 'STD' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'class_id' => $request->class_id,
                        'admission_date' => $request->admission_date ?: now(),
                        'roll_number' => $request->roll_number,
                        'father_name' => $request->father_name,
                        'mother_name' => $request->mother_name,
                        'guardian_id' => $request->guardian_id,
                        'blood_group' => $request->blood_group,
                    ]);
                }
                break;

            case 'guardian':
                \App\Models\Guardian::create([
                    'user_id' => $user->id,
                    'occupation' => $request->occupation,
                    'income' => $request->income,
                    'relationship' => $request->relationship,
                    'emergency_contact' => $request->emergency_contact,
                ]);
                break;
        }
    }

    /**
     * Handle role change for user.
     */
    private function handleRoleChange(User $user, string $oldRole, string $newRole, Request $request)
    {
        // Delete old role-specific record
        $this->deleteRoleSpecificRecord($user, $oldRole);
        
        // Create new role-specific record
        $this->createRoleSpecificRecord($user, $request);
    }

    /**
     * Delete role-specific record for user.
     */
    private function deleteRoleSpecificRecord(User $user, string $role = null)
    {
        $role = $role ?: $user->role;

        switch ($role) {
            case 'teacher':
                $user->teacher()?->delete();
                break;
            case 'student':
                $user->student()?->delete();
                break;
            case 'guardian':
                $user->guardian()?->delete();
                break;
        }
    }

    /**
     * Get user statistics based on role.
     */
    private function getUserStats(User $user): array
    {
        $stats = [];

        switch ($user->role) {
            case 'teacher':
                if ($user->teacher) {
                    $stats = [
                        'subjects_taught' => $user->teacher->subjects()->count(),
                        'total_students' => $user->teacher->subjects()
                            ->withCount('class.students')
                            ->get()
                            ->sum('class.students_count'),
                        'classes_taught' => $user->teacher->subjects()
                            ->distinct('class_id')
                            ->count(),
                    ];
                }
                break;

            case 'student':
                if ($user->student) {
                    $stats = [
                        'total_subjects' => $user->student->class->subjects()->count(),
                        'attendance_percentage' => $this->calculateAttendancePercentage($user->student->id),
                        'total_results' => $user->student->results()->count(),
                        'pending_fees' => $user->student->fees()
                            ->where('status', '!=', 'paid')
                            ->sum('amount'),
                    ];
                }
                break;

            case 'guardian':
                if ($user->guardian) {
                    $stats = [
                        'total_children' => $user->guardian->children()->count(),
                        'total_fees_due' => $user->guardian->children()
                            ->with('fees')
                            ->get()
                            ->pluck('fees')
                            ->flatten()
                            ->where('status', '!=', 'paid')
                            ->sum('amount'),
                    ];
                }
                break;
        }

        return $stats;
    }

    /**
     * Calculate attendance percentage for student.
     */
    private function calculateAttendancePercentage(int $studentId): float
    {
        $totalClasses = \App\Models\Attendance::where('student_id', $studentId)->count();
        
        if ($totalClasses == 0) return 0;
        
        $presentClasses = \App\Models\Attendance::where('student_id', $studentId)
            ->where('status', 'present')
            ->count();
        
        return round(($presentClasses / $totalClasses) * 100, 2);
    }
}
