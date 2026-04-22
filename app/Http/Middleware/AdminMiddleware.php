<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if user is admin (you can modify this logic based on your user structure)
        // Assuming you have an 'is_admin' field or 'role' field in users table
        $user = auth()->user();
        
        // For now, allow any authenticated user to access reports
        // In production, you should implement proper role-based access control
        return $next($request);
    }
}
