<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Http\Requests\RemittanceForm;
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
    }

    public function getLiraExchangeRate(Request $request)
    {
        $client = new Client();

        $T_to_U = $client->get('http://localhost:3000/er');

        return $T_to_U;
    }

    public function calculateRemittance(RemittanceForm $request)
    {

        $result = $this->getEuroExchangeRate();

        $EuroER = $result->getBody()->getContents();
//        dd(json_decode($EuroER)[0]->er);
//        $EuroTTL = $this->getEuroExchangeRate($request);

        if($request['currency']=='Turkish Lira'){


        }

        //write to backlog

       return json_decode($EuroER)[0]->er*$request->amount;
    }


}
