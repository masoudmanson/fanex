<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogExist
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
        if(isset($_COOKIE['backlog'])){
            return $next($request);
        }
        return redirect('/home')->withErrors(['msg', 'The Message']);
    }
}
