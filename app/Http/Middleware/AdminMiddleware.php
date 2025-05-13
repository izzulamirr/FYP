<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\StaffController;

class AdminMiddleware
{
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {// Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        // Allow only 'admin' role
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized.'); // Block access if the role is not 'admin'
        }

        return $next($request);
    }
}

