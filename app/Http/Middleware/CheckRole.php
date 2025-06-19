<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $roleAlias
     */
    public function handle(Request $request, Closure $next, string $roleAlias)
    {
        $user = $request->user();
        if (! $user) {
            // belum login
            return redirect()->route('login');
        }

        // periksa berdasarkan alias
        if ($roleAlias === 'admin' && ! $user->isAdmin()) {
            abort(403, 'Anda bukan admin.');
        }
        if ($roleAlias === 'user' && ! $user->isUser()) {
            abort(403, 'Akses terbatas untuk user.');
        }

        return $next($request);
    }
}
