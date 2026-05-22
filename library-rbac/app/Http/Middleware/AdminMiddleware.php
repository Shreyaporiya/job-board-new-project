<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and is admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }
        
        // Redirect non-admin users with error message
        return redirect()->route('dashboard')->with('error', 'You do not have administrator access.');
    }
}