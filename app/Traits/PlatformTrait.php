<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 5/21/17
 * Time: 11:48 AM
 */

namespace App\Traits;

use App\Backlog;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Morilog\Jalali\jDate;

trait PlatformTrait
{

    public function registerWithSSO(Request $request)
    {
        $token = $request->bearerToken();

//        $nick = $request['nickname'];
        $nick = $request->nickname;

        $client = new Client();
        $res = $client->request('GET', 'http://sandbox.fanapium.com:8081/aut/registerWithSSO/', [
            'query' => ['nickname' => $nick],
            'headers' => [
                '_token_' => $token,
                '_token_issuer_' => 1
            ]
        ]);

        return $res;
    }

    public function getCurrentPlatformUser($token)
    {
        $client = new Client();
        $res = $client->get('http://sandbox.fanapium.com:8081/nzh/getUserProfile', [
            'headers' => [
                '_token_' => $token,
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }

    public function getOtt()
    {
        $token = '0c9e54ee15174cbda4a68b06318a8c14'; //biz static token
        $client = new Client();
        //businessId should receive from getBusiness.however it's static in platform db.
        $res = $client->get('http://sandbox.fanapium.com:8081/nzh/ott/', [
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
        $res = $client->get('http://sandbox.fanapium.com:8081/nzh/follow/?businessId=22&follow=true', [
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
        $res = $client->get('http://sandbox.fanapium.com:8081/nzh/getUserBusiness', [
            'headers' => [
                '_token_' => $token,// get business token and put in here
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }

    public function userInvoice(Request $request, Backlog $backlog)
    {
        $client = new Client();
        //business token must taken from sso

//        $token_object = $this->refreshToken('33dc287af5f34f9bb9534f0bf6687866'); //token must taken from setting or register from a service provider
//        $token = json_decode($token_object->getBody()->getContents())->access_token;
        $token = '0c9e54ee15174cbda4a68b06318a8c14'; //biz static token

//        $user_object = $this->getCurrentPlatformUser($request->bearerToken());
        $user_object = $this->getCurrentPlatformUser($request->cookie('_token_')['access']);
//        if (!$user->hasError)
//        dd($user_object->getBody()->getContents());
        $json_input = $user_object->getBody()->getContents();
        $userId = json_decode($json_input)->result->userId;

        $result = $this->getOtt();
        $json = $result->getBody()->getContents();
        $ott = json_decode($json)->ott;
//        else

        //redirect to login? or refresh the user token ,,,
        // *hint: if refresh token was needed, get the user refresh token from its db row
        //todo how can I know user object on db, if his token expired and I don't have his userId??

        $res = $client->get('http://sandbox.fanapium.com:8081/nzh/biz/issueInvoice', [
//            'form_params' => [
            'query' => [
                //todo
                'redirectURL' => $request->root() . '/invoice/show',
                'userId' => $userId,// get userId from his token: gholi = 204
                'billNumber' => generateUniqueReferenceNumber(), //todo : make a random factor bill number , it's the same URN (Unique Reference Number)
                'description' => 'for now we have no description',
                'deadline' => jDate::forge('now')->format('Y/m/d'), //persian date in format yyyy/mm/dd
                'productId[]' => 0, //I've no idea
                'price[]' => $backlog->payment_amount, //give the price from saved transaction
                'productDescription[]' => 'for now we have no description', //I've no idea
                'quantity[]' => 1, //I'm not sure
                'pay' => false, // for now false is enough. later, depend on method of pay, it can change dynamically.
                'block' => false, // I think so
                'guildCode' => 'FINANCIAL_GUILD',
                'state' => 'tehran', //right up to the address maybe
                'city' => 'tehran',
                'postalCode' => '1654777158',// maybe will taken from user
                'address' => 'somewhere new',
                'addressId' => 0,
                'phoneNumber' => '09387181694',//maybe user's phone number
                'preferredTaxRate' => 0
            ],
            'headers' => [
                '_token_' => $token,
                '_ott_' => $ott,
                '_token_issuer_' => 1
            ]
        ]);

        return $res;
    }

    public function trackingInvoiceByBillNumber($billNumber) //the form parameters can be taken from arguments, according to needs
    {
        $client = new Client();
        $token = '0c9e54ee15174cbda4a68b06318a8c14'; //biz static token

        $res = $client->post('http://sandbox.fanapium.com:8081/nzh/biz/getInvoiceList', [
                'form_params' => [
                    'billNumber' => $billNumber,
                    'size' => 1,
                    'firstId' => 0,
//                    'isPayed' => true,
//                    'isCanceled' => false,
                ],
                'headers' => [
                    '_token_' => $token,
                    '_token_issuer_' => 1
                ]
            ]
        );
        return $res;
    }

    public function cancelInvoice($invoice_id , $token = 'd35b0c351acd47cc87a76b1c4b07239a') //todo: get api_token from config or .env file
    {
        $client = new Client();
        $res = $client->get('http://sandbox.fanapium.com:8080/nzh/biz/cancelInvoice', [
            'query' =>
                [
                    'invoiceId' => $invoice_id
                ],
            'headers' => [
                '_token_' => $token,
                '_token_issuer_' => 1
            ]
        ]);
        return $res;
    }
}