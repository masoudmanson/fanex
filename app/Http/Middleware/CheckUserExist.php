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
        if ($token = $request->bearerToken()) {

            $result = $this->getCurrentPlatformUser($token);
            $platform_user = json_decode($result->getBody()->getContents());
            $id = $platform_user->result->userId;

            if (User::find($id)) {
                $user = User::find($id);
                dd($user);
                $user->api_token = $request->bearerToken();
                Auth::login($user);
                dd(Auth::user());
                return $next($request);
            }
            else {
//                $this->RegisterWithSSO($request);
//                return redirect('additional-info')->with([
//                    'redirect_uri' => $request->url(),
//                    'state' => $request->state,
//                    'token' => $token
//                ]);

                $data = array(
                    'redirect_uri' => $request->url(),
                    'state' => $request->state
                );

                return response()->view('additional', $data, 200)->header('authorization', 'Bearer ' . $token);
            }

        }
    }
}
