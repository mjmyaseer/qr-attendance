<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('userID'))
        {
            return redirect('sign-in.html');
        }
        return $next($request);
    }
}
