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

    public function registerWithSSO(Request $request)
    {
        $token = $request->bearerToken();

//        $nick = $request['nickname'];
        $nick = $request->nickname;

        $client = new Client();
        $res = $client->request('GET', 'http://sandbox.fanapium.com:8080/aut/registerWithSSO/', [
            'query' => ['nickname' => $nick],
            'headers' => [
                '_token_' => $token,
                '_token_issuer_' => 1
            ]
        ]);

//        dd($res->getBody()->getContents());
        return $res;
    }

    public function getCurrentPlatformUser($token)
    {
        $client = new Client();
        $res = $client->get('http://sandbox.fanapium.com:8080/nzh/getUserProfile', [
            'headers' => [
                '_token_' => $token,
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }

    public function followBusiness($token)
    {
        $client = new Client();
        //businessId should receive from getBusiness.however it's static in platform db.
        $res = $client->get('http://sandbox.fanapium.com:8080/nzh/follow/?businessId=22&follow=true', [
            'headers' => [
                '_token_' => $token,
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }

    public function getBusiness($token)
    {
        $client = new Client();
        //business token must taken from sso
        $res = $client->get('http://sandbox.fanapium.com:8080/nzh/getUserBusiness', [
            'headers' => [
                '_token_' => $token,// get business token and put in here
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }
}