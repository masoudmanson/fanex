<?php

namespace App\Http\Middleware;

use App\Traits\PlatformTrait;
use App\User;
use Closure;
use Illuminate\Http\Request;
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

            if (User::find($id))
                return $next($request);
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
        //redirect to login


//        elseif ($request->has('code')) {
//
//            $result = $this->getToken($request);
//
//            $token_object = json_decode($result->getBody()->getContents());
//
//            $request->headers->set('authorization', 'Bearer ' . $token_object->access_token);
//
////            $result = $this->RegisterWithSSO($request);
//
//            return $next($request);
//        }
//
//        $queryString = $request->getQueryString();
//
//        return redirect('login')->with([
//            'redirect_uri' => $redirect_uri = $request->url(),
////            'redirect_uri' => $redirect_uri = $request->route()->uri(),
//            'query_string' => (is_base64($queryString) ? $queryString : base64_encode($queryString))
//        ]);
    }
}
