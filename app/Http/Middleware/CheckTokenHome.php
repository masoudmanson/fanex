<?php

namespace App\Http\Middleware;

use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckTokenHome
{
    use TokenTrait;
    use PlatformTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('token')) {
            $token = $request->cookie('token');

            $result = $this->tokenValidation($token['access']);
            $result = json_decode($result->getBody()->getContents());
            if ($result && $result->active) {

                $result = $this->refreshToken($token['refresh']);
                $token_object = json_decode($result->getBody()->getContents());

                $token_array = array('access' => $token_object->access_token, 'refresh' => $token_object->refresh_token);

                $cookie = cookie('token', $token_array, $token_object->expires_in / 60,
                    '', '', FALSE, FALSE);

                return $next($request)->withCookie($cookie);
            }

        } elseif ($request->has('code')) {

            $result = $this->getToken($request);
            $token_object = json_decode($result->getBody()->getContents());
            $token_array = array('access' => $token_object->access_token, 'refresh' => $token_object->refresh_token);

            $cookie = cookie('token', $token_array, $token_object->expires_in / 60,
                '', '', false, false);

            $request->headers->set('authorization', 'Bearer ' . $token_object->access_token);

            $response = $next($request);

            return $response->withCookie($cookie);

        }

        if (Auth::user()) {
            Auth::logout();
        }

        return $next($request);
    }
}
