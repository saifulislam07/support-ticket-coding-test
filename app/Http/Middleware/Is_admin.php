<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Is_admin
{

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()?->role == 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You have not admin access');
    }
}
