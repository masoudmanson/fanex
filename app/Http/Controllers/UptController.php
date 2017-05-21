<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class UptController extends Controller
{
    // upt fake web service

    public function getEuroExchangeRate()
    {
        $client = new Client();

        $U_to_R = $client->get('https://private-3df4f-fanex.apiary-mock.com/er');

        return $U_to_R;


//        "er": "123",
//    "date": "2015-08-05T08:40:51.620Z",
//    "ttl": "12355234"

    }

    public function getLiraExchangeRate(Request $request)
    {
        $client = new Client();

        $T_to_U = $client->get('https://private-3df4f-fanex.apiary-mock.com/upt/er');

        return $T_to_U;

    }

    public function calculateRemittance(Request $request)
    {
        $result = $this->getEuroExchangeRate();

        $EuroER = $result->getBody()->getContents();
//        dd(json_decode($EuroER)[0]->er);
        $EuroTTL = $this->getEuroExchangeRate($request);

        if($request['currency']=='Turkish Lira'){


        }
        echo 'calculating...';
    }


}
