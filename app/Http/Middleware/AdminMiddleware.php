<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\StaffController;
use App\Models\Role; // Ensure the Role model is imported

class AdminMiddleware
{
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {// Check if the user is authenticated
        // Check if the user is authenticated
        
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if there is a role with name 'admin' and user_id == current user's id
        $isAdmin = Role::where('name', 'admin')
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isAdmin) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}

