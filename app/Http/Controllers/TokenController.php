<?php

namespace App\Http\Controllers;

use App\Traits\TokenTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TokenController extends Controller
{

    public function tokenValidation(Request $request)
    {

//        $redirect_uri = $request['redirect_uri'];

        $token = $request->token;
        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        $client = new Client();
        $res = $client->post('http://sandbox.fanapium.com/oauth2/token/info', [
            'form_params' => [
                'token' => $token,
                'client_id' => $id,
                'client_secret' => $secret,
            ]
        ]);

        return $res;
//        echo $res->getStatusCode(); // 200
//        echo $res->getBody();

    }
}
