<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DotinController extends Controller
{

    public function showDotinForm()
    {
        dd('form view');
    }

    public function dotinAuthorization(Request $request)//ServerRequestInterface $request
    {
        $body["Account_number"] = "8615239123"; //$request->acc
        $body["Mobile_number"] = "09167871238"; //$request->mobile

//        $token = $request->token;
        $token = "ABCASDNKCDEF";

        $client = new Client();
        $res = $client->post('https://private-3df4f-fanex.apiary-mock.com/dotin', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],

        ]);

        return $res;
    }
}
