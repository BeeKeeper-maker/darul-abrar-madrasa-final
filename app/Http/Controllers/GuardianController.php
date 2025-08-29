<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuardianRequest;
use App\Http\Requests\UpdateGuardianRequest;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GuardianController extends Controller
{
    /**
     * Display a listing of the guardians.
     */
    public function index(): View
    {
        $guardians = Guardian::with('user', 'students')->paginate(10);
        return view('guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new guardian.
     */
    public function create(): View
    {
        $students = Student::with('user')->get();
        return view('guardians.create', compact('students'));
    }

    /**
     * Store a newly created guardian in storage.
     */
    public function store(StoreGuardianRequest $request): RedirectResponse
    {
        // Create a new user for the guardian
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guardian',
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        // Handle profile photo upload
        $profilePhoto = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Create the guardian record
        $guardian = Guardian::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'relation' => $request->relation,
            'phone' => $request->phone,
            'alternate_phone' => $request->alternate_phone,
            'email' => $request->email,
            'occupation' => $request->occupation,
            'address' => $request->address,
            'profile_photo' => $profilePhoto,
            'is_emergency_contact' => $request->has('is_emergency_contact'),
        ]);

        // Attach students to the guardian
        if ($request->has('student_ids')) {
            $guardian->students()->attach($request->student_ids);
        }

        return redirect()->route('guardians.index')
            ->with('success', 'Guardian created successfully.');
    }

    /**
     * Display the specified guardian.
     */
    public function show(Guardian $guardian): View
    {
        $guardian->load('user', 'students.user', 'students.class');
        return view('guardians.show', compact('guardian'));
    }

    /**
     * Show the form for editing the specified guardian.
     */
    public function edit(Guardian $guardian): View
    {
        $students = Student::with('user')->get();
        $selectedStudents = $guardian->students->pluck('id')->toArray();
        
        return view('guardians.edit', compact('guardian', 'students', 'selectedStudents'));
    }

    /**
     * Update the specified guardian in storage.
     */
    public function update(UpdateGuardianRequest $request, Guardian $guardian): RedirectResponse
    {
        // Update user information
        $guardian->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $guardian->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($guardian->profile_photo) {
                Storage::disk('public')->delete($guardian->profile_photo);
            }
            
            $profilePhoto = $request->file('profile_photo')->store('profile-photos', 'public');
            $guardian->profile_photo = $profilePhoto;
        }

        // Update guardian information
        $guardian->update([
            'name' => $request->name,
            'relation' => $request->relation,
            'phone' => $request->phone,
            'alternate_phone' => $request->alternate_phone,
            'email' => $request->email,
            'occupation' => $request->occupation,
            'address' => $request->address,
            'is_emergency_contact' => $request->has('is_emergency_contact'),
        ]);

        // Sync students
        if ($request->has('student_ids')) {
            $guardian->students()->sync($request->student_ids);
        } else {
            $guardian->students()->detach();
        }

        return redirect()->route('guardians.index')
            ->with('success', 'Guardian updated successfully.');
    }

    /**
     * Remove the specified guardian from storage.
     */
    public function destroy(Guardian $guardian): RedirectResponse
    {
        // Delete profile photo if exists
        if ($guardian->profile_photo) {
            Storage::disk('public')->delete($guardian->profile_photo);
        }

        // Delete the user (will cascade delete the guardian due to foreign key constraint)
        $guardian->user->delete();

        return redirect()->route('guardians.index')
            ->with('success', 'Guardian deleted successfully.');
    }

    /**
     * Display the guardian dashboard.
     */
    public function dashboard(): View
    {
        $guardian = auth()->user()->guardian;
        $students = $guardian->students()->with('class', 'results', 'attendances', 'fees')->get();
        
        return view('dashboard.guardian', compact('guardian', 'students'));
    }

    /**
     * Display the children's attendances.
     */
    public function childrenAttendances(): View
    {
        $guardian = auth()->user()->guardian;
        $students = $guardian->students()->with('attendances')->get();
        
        return view('guardians.attendances', compact('guardian', 'students'));
    }

    /**
     * Display the children's results.
     */
    public function childrenResults(): View
    {
        $guardian = auth()->user()->guardian;
        $students = $guardian->students()->with('results.exam', 'results.subject')->get();
        
        return view('guardians.results', compact('guardian', 'students'));
    }

    /**
     * Display the children's fees.
     */
    public function childrenFees(): View
    {
        $guardian = auth()->user()->guardian;
        $students = $guardian->students()->with('fees')->get();
        
        return view('guardians.fees', compact('guardian', 'students'));
    }
}