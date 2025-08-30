<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /**
     * Test middleware and role functionality
     */
    public function testRoleMiddleware(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'error' => 'User not authenticated',
                'middleware_status' => 'auth middleware working'
            ], 401);
        }
        
        return response()->json([
            'success' => 'Role middleware working correctly',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'middleware_status' => 'role middleware working'
        ]);
    }
    
    /**
     * Test admin role specifically
     */
    public function testAdminRole(Request $request)
    {
        return response()->json([
            'success' => 'Admin role middleware working correctly',
            'user_role' => Auth::user()->role,
            'middleware_chain' => 'auth,role:admin'
        ]);
    }
    
    /**
     * Test teacher role specifically
     */
    public function testTeacherRole(Request $request)
    {
        return response()->json([
            'success' => 'Teacher role middleware working correctly',
            'user_role' => Auth::user()->role,
            'middleware_chain' => 'auth,role:teacher'
        ]);
    }
}