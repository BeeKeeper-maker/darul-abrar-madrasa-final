<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Load relationships based on user role
        if ($user->hasRole('student')) {
            $user->load('student.class', 'student.guardian');
        } elseif ($user->hasRole('teacher')) {
            $user->load('teacher.department');
        } elseif ($user->hasRole('guardian')) {
            $user->load('guardian.children.class');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address', 'date_of_birth', 'gender']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        // Update user profile
        $user->update($data);

        // Update role-specific information
        $this->updateRoleSpecificInfo($request, $user);

        return redirect()->route('profile.show')->with('success', 'প্রোফাইল সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড প্রয়োজন।',
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            'password.required' => 'নতুন পাসওয়ার্ড প্রয়োজন।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিল নেই।',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।');
    }

    /**
     * Update role-specific information.
     */
    private function updateRoleSpecificInfo(Request $request, $user)
    {
        if ($user->hasRole('student') && $user->student) {
            $studentData = $request->only(['father_name', 'mother_name', 'blood_group']);
            if (!empty(array_filter($studentData))) {
                $user->student->update($studentData);
            }
        } elseif ($user->hasRole('teacher') && $user->teacher) {
            $teacherData = $request->only(['designation', 'qualification', 'experience', 'salary']);
            if (!empty(array_filter($teacherData))) {
                $user->teacher->update($teacherData);
            }
        } elseif ($user->hasRole('guardian') && $user->guardian) {
            $guardianData = $request->only(['occupation', 'income', 'relationship']);
            if (!empty(array_filter($guardianData))) {
                $user->guardian->update($guardianData);
            }
        }
    }

    /**
     * Delete user avatar.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return redirect()->route('profile.show')->with('success', 'প্রোফাইল ছবি মুছে ফেলা হয়েছে।');
    }

    /**
     * Get user dashboard stats based on role.
     */
    public function getDashboardStats()
    {
        $user = Auth::user();
        $stats = [];

        if ($user->hasRole('student')) {
            $student = $user->student;
            if ($student) {
                $stats = [
                    'total_subjects' => $student->class->subjects()->count() ?? 0,
                    'attendance_percentage' => $this->calculateAttendancePercentage($student->id),
                    'pending_fees' => $student->fees()->where('status', '!=', 'paid')->sum('amount') ?? 0,
                    'total_results' => $student->results()->count() ?? 0,
                ];
            }
        } elseif ($user->hasRole('teacher')) {
            $teacher = $user->teacher;
            if ($teacher) {
                $stats = [
                    'total_students' => $teacher->subjects()->withCount('class.students')->get()->sum('class.students_count') ?? 0,
                    'total_classes' => $teacher->subjects()->distinct('class_id')->count() ?? 0,
                    'total_subjects' => $teacher->subjects()->count() ?? 0,
                    'pending_results' => $this->getPendingResultsCount($teacher->id),
                ];
            }
        } elseif ($user->hasRole('guardian')) {
            $guardian = $user->guardian;
            if ($guardian) {
                $stats = [
                    'total_children' => $guardian->children()->count() ?? 0,
                    'total_pending_fees' => $guardian->children()->withSum('fees', 'amount')->get()->sum('fees_sum_amount') ?? 0,
                    'average_attendance' => $this->calculateChildrenAttendance($guardian->id),
                    'total_notifications' => $user->notifications()->unread()->count() ?? 0,
                ];
            }
        }

        return $stats;
    }

    /**
     * Calculate attendance percentage for a student.
     */
    private function calculateAttendancePercentage($studentId)
    {
        $totalClasses = \App\Models\Attendance::where('student_id', $studentId)->count();
        if ($totalClasses == 0) return 0;
        
        $presentClasses = \App\Models\Attendance::where('student_id', $studentId)
            ->where('status', 'present')->count();
        
        return round(($presentClasses / $totalClasses) * 100, 2);
    }

    /**
     * Get pending results count for a teacher.
     */
    private function getPendingResultsCount($teacherId)
    {
        return \App\Models\Exam::whereHas('subjects', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->whereDoesntHave('results')->count();
    }

    /**
     * Calculate average attendance for guardian's children.
     */
    private function calculateChildrenAttendance($guardianId)
    {
        $children = \App\Models\Guardian::find($guardianId)->children;
        if ($children->isEmpty()) return 0;

        $totalAttendance = 0;
        $childrenCount = 0;

        foreach ($children as $child) {
            $attendance = $this->calculateAttendancePercentage($child->id);
            if ($attendance > 0) {
                $totalAttendance += $attendance;
                $childrenCount++;
            }
        }

        return $childrenCount > 0 ? round($totalAttendance / $childrenCount, 2) : 0;
    }
}
