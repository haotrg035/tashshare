<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsNumberUri
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
        // $path = explode('/',$path)[1];
        if (preg_match('/project\/[0-9]+/',$request->path(),$matches)) {
            return $next($request);
        } else {
            return redirect(route('dashboard'));
        }

    }
}
