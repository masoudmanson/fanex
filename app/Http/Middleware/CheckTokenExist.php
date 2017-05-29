<?php

namespace App\Http\Middleware;

use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use Closure;
use GuzzleHttp\Client;

class CheckTokenExist
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
        if (($token = $request->bearerToken())) //|| ($token = $request->hasCookie('token')))
        {

//            $result = $this->tokenValidation($request->bearerToken());
            $result = $this->tokenValidation($token);
            $result = json_decode($result->getBody()->getContents());

            if ($result->active) {
                return $next($request);
                // or ,else refresh token
            }

        } elseif ($request->has('code')) {

            $result = $this->getToken($request);

            $token_object = json_decode($result->getBody()->getContents());

            $request->headers->set('authorization', 'Bearer ' . $token_object->access_token);

//            $result = $this->RegisterWithSSO($request);

            return $next($request);
        }

        $queryString = $request->getQueryString();

        return redirect('login')->with([
            'redirect_uri' =>  $request->url(),
//            'redirect_uri' => $redirect_uri = $request->route()->uri(),
            'query_string' => (is_base64($queryString) ? $queryString : base64_encode($queryString))
        ]);
    }
}
