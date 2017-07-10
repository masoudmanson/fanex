<?php

namespace App\Http\Middleware;

use App\Traits\TokenTrait;
use Closure;
use Illuminate\Cookie\CookieJar;

class LogOut
{
    use TokenTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        setcookie('ttl','', -60, "/", "", false, false);

        if ($request->hasCookie('token')) {
            $this->revokeToken($request->cookie('token')['access']);
            $cookie = cookie('token', '', -6000);
            return $response->withCookie($cookie);
        }

        return $response;
    }
}
