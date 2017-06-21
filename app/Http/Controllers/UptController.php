<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Http\Requests\RemittanceForm;
use App\Traits\LogTrait;
use App\Traits\UptTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ServerRequestInterface;

class UptController extends Controller
{
    use UptTrait;
    use LogTrait;

    public function test()
    {
        dd($this->CorpGetCurrencyRate());
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

    /**
     * @param RemittanceForm $request
     * @return mixed
     */
    public function calculateRemittance(RemittanceForm $request)
    {
        $upt_result = array();
        $amount = $request->amount;

        if ($request['currency'] == 'lira') {
            $upt_result = $this->UPTGetTExchangeData($request->amount, 'TRY', 'EUR');
            $amount = $upt_result['out'];
        }

        $result = $this->getEuroExchangeRate();

        $EuroER = $result->getBody()->getContents();

//        $EuroTTL = $this->getEuroExchangeRate($request);


        //write to backlog
        $log = new Backlog();
        $log = $this->maniFormBackLog($log, $request, $upt_result, json_decode($EuroER));

        setcookie('backlog', base64_encode($log->id), time() + 600);

        setcookie('ttl', time() + 600, time() + 600);

        return json_decode($EuroER)[0]->er * $amount;
    }


}
