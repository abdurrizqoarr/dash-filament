<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MultiGuardAuth
{
    protected $guards = ['web', 'admin', 'anggota'];

    public function handle($request, Closure $next)
    {
        foreach ($this->guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard); // Set guard aktif
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
