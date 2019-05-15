<?php

namespace App\Http\Middleware;

use Closure;

class IsPostToSignup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('Post')) {
            return $next($request);
        }
        return redirect()->route('dashboard');

    }
}
