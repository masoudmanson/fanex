<?php

namespace App\Http\Middleware;

use App\Traits\PlatformTrait;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserHome
{
    use PlatformTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasCookie('token'))
            $access_token = $request->cookie('token')['access'];
        elseif ($access_token = $request->bearerToken()) ;

        else
            return $next($request);

        $result = $this->getCurrentPlatformUser($access_token);
        $platform_user = json_decode($result->getBody()->getContents());
        $id = $platform_user->result->userId;

        if (User::findByUserId($id)->first()) {
            $user = User::findByUserId($id)->first();

            //todo : this is only for test, to find out csrf-token problem is related to user session or not.
            if (Auth::check())
                return $next($request);

            Auth::login($user);
        }

            return $next($request);

    }
}
