<?php

namespace App\Http\Middleware;

use App\Traits\PlatformTrait;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CheckUserExist
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
        if ($request->hasCookie('_token'))
            $access_token = $request->cookie('_token')['access'];
        elseif ($access_token = $request->bearerToken());

            $result = $this->getCurrentPlatformUser($access_token);
            $platform_user = json_decode($result->getBody()->getContents());

            $id = $platform_user->id;

            if (User::findByUserId($id)->first()) {
                $user = User::findByUserId($id)->first();

                Auth::login($user);

                return $next($request);
            } else {

                $data = array(
                    'redirect_uri' => $request->url(),
                    'state' => $request->state,
                );

                return response()->view('statics.additional', $data, 200);
//                    ->header('authorization', 'Bearer ' . $token);
            }

        }
}
