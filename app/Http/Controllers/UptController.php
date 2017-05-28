<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ServerRequestInterface;

class UptController extends Controller
{
    // upt fake web service

    public function getEuroExchangeRate()
    {
        $client = new Client();

        $U_to_R = $client->get('http://localhost:3000/er');

        return $U_to_R;


//        "er": "123",
//    "date": "2015-08-05T08:40:51.620Z",
//    "ttl": "12355234"

    }

    public function getLiraExchangeRate(Request $request)
    {
        $client = new Client();

        $T_to_U = $client->get('http://localhost:3000/er');

        return $T_to_U;

    }

    public function calculateRemittance(Request $request)
    {
        $rules = ['captcha' => 'required|captcha'];
dd($request);
        $validator = Validator::make($request->all(), $rules);//todo validation class must add to head of class
        if ($validator->fails())
        {
            echo '<p style="color: #ff0000;">Incorrect!</p>';
        }
        else
        {
            echo '<p style="color: #00ff30;">Matched :)</p>';
        }

        $result = $this->getEuroExchangeRate();

        $EuroER = $result->getBody()->getContents();
//        dd(json_decode($EuroER)[0]->er);
//        $EuroTTL = $this->getEuroExchangeRate($request);

        if($request['currency']=='Turkish Lira'){


        }

        //write to backlog

       return json_decode($EuroER)[0]->er;
    }


}
