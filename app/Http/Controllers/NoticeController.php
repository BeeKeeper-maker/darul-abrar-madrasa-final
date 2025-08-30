<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NoticeController extends Controller
{
    /**
     * Display a listing of the notices.
     */
    public function index(): View
    {
        $notices = Notice::with('publishedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new notice.
     */
    public function create(): View
    {
        return view('notices.create');
    }

    /**
     * Store a newly created notice in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:publish_date',
            'notice_for' => 'required|in:all,students,teachers,staff,guardians',
            'is_active' => 'boolean',
        ]);
        
        $validated['published_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');
        
        Notice::create($validated);
        
        return redirect()->route('notices.index')
            ->with('success', 'Notice created successfully.');
    }

    /**
     * Display the specified notice.
     */
    public function show(Notice $notice): View
    {
        return view('notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified notice.
     */
    public function edit(Notice $notice): View
    {
        return view('notices.edit', compact('notice'));
    }

    /**
     * Update the specified notice in storage.
     */
    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:publish_date',
            'notice_for' => 'required|in:all,students,teachers,staff,guardians',
            'is_active' => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        $notice->update($validated);
        
        return redirect()->route('notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified notice from storage.
     */
    public function destroy(Notice $notice): RedirectResponse
    {
        $notice->delete();
        
        return redirect()->route('notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
    
    /**
     * Display public notices for authenticated users.
     */
    public function publicNotices(): View
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        $notices = Notice::with('publishedBy')
            ->published()
            ->notExpired()
            ->where(function ($query) use ($userRole) {
                $query->where('notice_for', $userRole . 's') // students, teachers, guardians
                    ->orWhere('notice_for', 'all');
            })
            ->orderBy('publish_date', 'desc')
            ->paginate(10);
            
        return view('notices.public', compact('notices'));
    }
}