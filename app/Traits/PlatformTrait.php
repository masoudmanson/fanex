<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 5/21/17
 * Time: 11:48 AM
 */

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

trait PlatformTrait
{

    public function RegisterWithSSO(Request $request)
    {
        $code = $request['code'];
        $nick = $request['nickname'];

        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        $client = new Client();
        $res = $client->post('http://sandbox.fanapium.com/aut/registerWithSSO', [
            "form_params" => [
                "nickname" => 'authorization_code',
                "code" => $code,
                "redirect_uri" => $request->url(),
                "client_id" => $id,
                "client_secret" => $secret,
            ]
        ]);

        return $res;
    }

    public function GetCurrentPlatformUser(Request $request , $token)
    {
        $code = $request['code'];
        $nick = $request['nickname'];

        $id = adapterAssignment()->getId();
        $secret = adapterAssignment()->getSecret();

        //token in header
        $client = new Client();
        $res = $client->post('http://sandbox.fanapium.com/user', [
//            "form_params" => [
//                "nickname" => 'authorization_code',
//                "code" => $code,
//                "redirect_uri" => $request->url(),
//                "client_id" => $id,
//                "client_secret" => $secret,
//            ]
        ]);
    }
}