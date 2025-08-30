<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Debug logging (remove in production)
        Log::info('CheckRole middleware executed', [
            'user' => $request->user() ? $request->user()->toArray() : null,
            'required_roles' => $roles,
            'user_role' => $request->user() ? $request->user()->role : null
        ]);
        
        if (!$request->user()) {
            Log::warning('CheckRole: User not authenticated');
            abort(401, 'Authentication required.');
        }
        
        if (!in_array($request->user()->role, $roles)) {
            Log::warning('CheckRole: Insufficient permissions', [
                'user_role' => $request->user()->role,
                'required_roles' => $roles
            ]);
            abort(403, 'Unauthorized action. Required roles: ' . implode(', ', $roles) . '. Your role: ' . $request->user()->role);
        }

        Log::info('CheckRole: Access granted', [
            'user_role' => $request->user()->role,
            'required_roles' => $roles
        ]);

        return $next($request);
    }
}