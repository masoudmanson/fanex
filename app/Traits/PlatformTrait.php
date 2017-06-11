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
use Morilog\Jalali\jDate;

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

//    public function getCurrentPlatformUser($token)
//    {
//        $client = new Client();
//        $res = $client->get('http://sandbox.fanapium.com:8080/nzh/getUserProfile', [
//            'headers' => [
//                '_token_' => $token,
//                '_token_issuer_' => 1
//            ]
//        ]);
//        return $res;
//    }

    public function getCurrentPlatformUser($token)
    {
        $client = new Client();
        $res = $client->get('http://sandbox.fanapium.com/users', [
            'headers' => [
                'authorization' => 'bearer '.$token
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

    public function userInvoice(Request $request)
    {
        $client = new Client();
        //business token must taken from sso
        $token_object = $this->refreshToken('2345413e8e5041ec945e48ab4ce65596'); //token must taken from setting or register from a service provider
        $token = $token_object->access_token;

        $user = $this->getCurrentPlatformUser($request->bearerToken());
//        if (!$user->hasError)
            $userId = $user->result->userId;
//        else

            //redirect to login? or refresh the user token ,,,
            // *hint: if refresh token was needed, get the user refresh token from its db row
            //todo how can I know user object on db, if his token expired and I don't have his userId??

        $res = $client->get('http://sandbox.fanapium.com:8080/nzh/biz/issueInvoice', [
            'query' => [
                //todo
                'redirectURL' => 'http://localhost:8080/profile',// factor page
                'userId' => $userId,// get userId from his token: gholi = 204
                'billNumber' => generateUniqueReferenceNumber(), //todo : make a random factor bill number , it's the same URN (Unique Reference Number)
                'description' => 'for now we have no description',
                'deadline' => jDate::forge('now')->format('Y/m/d'), //persian date in format yyyy/mm/dd
                'productId[]' => 0, //I've no idea
                'price[]' => 0, //give the price from saved transaction
                'productDescription[]' => 'for now we have no description', //I've no idea
                'quantity[]' => 1, //I'm not sure
                'pay' => false, // for now false is enough. later, depend on method of pay, it can change dynamically.
                'block' => false, // I think so
                'guildCode' => 'FINANCIAL_GUILD',
                'state' => 'tehran', //right up to the address maybe
                'city' => 'tehran',
                'postalCode' => '1654777159',// maybe will taken from user
                'address' => 'somewhere',
                'addressId' => 0,
                'phoneNumber' => '09387181694',//maybe user's phone number
            ],
            'headers' => [
                '_token_' => $token,// get business token and put in here
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }
}