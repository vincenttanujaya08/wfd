<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id === 1) {
            return $next($request);
        }
        // Pastikan redirect ke route yang jelas untuk user biasa
        return redirect()->route('load'); // atau ke 'explore', bukan ke '/'
    }
}
