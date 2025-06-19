<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureBanned
{
    /**
     * Hanya izinkan user yang saat ini sedang diblokir.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Jika belum login atau tidak sedang diblokir → redirect ke home
        if (! $user || ! $user->isBanned()) {
            return redirect()->route('home')
                ->with('info', 'Anda tidak sedang diblokir.');
        }

        return $next($request);
    }
}
