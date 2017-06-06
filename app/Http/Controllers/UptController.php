<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Http\Requests\RemittanceForm;
use App\Traits\UptTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ServerRequestInterface;

class UptController extends Controller
{
    use UptTrait;
    public function test(RemittanceForm $request)
    {
        $this->CorpGetCountryData();
    }


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
//     dd(   $this->CorpGetCurrencyRate($request->amount));

        $result = $this->getEuroExchangeRate();

        $EuroER = $result->getBody()->getContents();
//        dd(json_decode($EuroER)[0]->er);
//        $EuroTTL = $this->getEuroExchangeRate($request);

        if($request['currency']=='Turkish Lira'){


        }

        //write to backlog

//        $log = new Backlog();

       return json_decode($EuroER)[0]->er*$request->amount;
    }


}
