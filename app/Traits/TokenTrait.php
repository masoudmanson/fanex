<?php

namespace App\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

trait TokenTrait
{

    public function getToken(Request $request)
    {
        $code = $request['code'];

        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        $client = new Client();
        $res = $client->post(config('urls.sso').'oauth2/token', [
            "form_params" => [
                "grant_type" => 'authorization_code',
                "code" => $code,
                "redirect_uri" => $request->url(),
                "client_id" => $id,
                "client_secret" => $secret,
            ]
        ]);

        return $res;
    }

    public function tokenValidation($token)
    {
        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        $client = new Client();
        $res = $client->post(config('urls.sso').'oauth2/token/info', [
            'form_params' => [
                'token' => $token,
                'client_id' => $id,
                'client_secret' => $secret,
            ]
        ]);

        return $res;
    }

    public function checkToken(Request $request) //delete if was unused.
    {
        if ($request->hasHeader('authorization')) {

            $result = $this->tokenValidation($request->bearerToken());
            $result = json_decode($result->getBody()->getContents());

            if (!$result || !$result->active) {

                return redirect('login')->with([
                    'redirect_uri' => $redirect_uri = $request->url(),
//                    'redirect_uri' => $redirect_uri = $request->route()->uri(),
                    'query_string' => $request->getQueryString()
//                    'query_string' => base64_encode($request->getQueryString())
                ]);

                // or refresh token

            } else {
                return $result;
            }
        }
        return false;
    }

    public function refreshToken($token)
    {
        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        $client = new Client();
        $res = $client->post(config('urls.sso').'oauth2/token', [
            'form_params' => [
                'grant_type'=>'refresh_token',
                'refresh_token' => $token,
                'client_id' => $id,
                'client_secret' => $secret,
            ]
        ]);

        return $res;
    }

    public function revokeToken($token)
    {
        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        $client = new Client();
        $res = $client->post(config('urls.sso').'oauth2/token/revoke', [
            'form_params' => [
                'token_type_hint'=>'access_token',
                'token' => $token,
                'client_id' => $id,
                'client_secret' => $secret,
            ]
        ]);

        return $res;
    }


}