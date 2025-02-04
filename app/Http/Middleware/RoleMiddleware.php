<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with([
                'status' => false,
                'message' => 'Silakan login untuk mengakses halaman ini.'
            ]);
        }
        
        if (Auth::user()->role !== $role) {
            return redirect('/')->with([
                'status' => false,
                'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'
            ]);
        }

        return $next($request);
    }
}
