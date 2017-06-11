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
//            dd($platform_user);
            $id = $platform_user->id; //todo : check for a logined user he isn't exist in platform

            if (User::findByUserId($id)->first()) {
                $user = User::findByUserId($id)->first();
                $user->api_token = $request->bearerToken();

                $user->save();
                Auth::login($user);

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
                    'state' => $request->state,
                    'token' => $request->bearerToken() // todo: this is just for run test. when masoud put his js codes into project, it must be deleted.
                );

                return response()->view('statics.additional', $data, 200)->header('authorization', 'Bearer ' . $token);
            }

        }
    }
}
