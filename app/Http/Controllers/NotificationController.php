<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index(): View
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notification $notification): RedirectResponse
    {
        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->markAsRead();
        
        if ($notification->link) {
            return redirect($notification->link);
        }
        
        return redirect()->back()
            ->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        Auth::user()->notifications()
            ->unread()
            ->update(['is_read' => true]);
            
        return redirect()->back()
            ->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->delete();
        
        return redirect()->back()
            ->with('success', 'Notification deleted.');
    }

    /**
     * Get unread notifications count.
     */
    public function getUnreadCount(): JsonResponse
    {
        $count = Auth::user()->notifications()
            ->unread()
            ->count();
            
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent unread notifications.
     */
    public function getRecentNotifications(): JsonResponse
    {
        $notifications = Auth::user()->notifications()
            ->unread()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return response()->json(['notifications' => $notifications]);
    }
}