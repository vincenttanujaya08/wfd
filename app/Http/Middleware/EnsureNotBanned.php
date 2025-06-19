<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureNotBanned
{
    /**
     * Hanya izinkan user yang TIDAK sedang diblokir.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Jika user sedang diblokir → redirect ke form appeal
        if ($user && $user->isBanned()) {
            return redirect()->route('appeal.create')
                ->with('info', 'Akun Anda sedang diblokir. Silakan ajukan banding.');
        }

        return $next($request);
    }
}
