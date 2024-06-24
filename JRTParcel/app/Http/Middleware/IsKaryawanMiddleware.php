<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsKaryawanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'karyawan' role
        if (Auth::check() && Auth::user()->role === 'karyawan') {
            return $next($request);
        }

        // redirect non-admin users or return a response
        return redirect()->route('dashboard')->with('error', 'You do not have access to this section.');
    }
}