<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            abort(403);
        }

        if (! $request->user()->isActive()) {
            auth()->logout();

            return redirect()->route('login')->with('error', 'Your account is not active.');
        }

        return $next($request);
    }
}
