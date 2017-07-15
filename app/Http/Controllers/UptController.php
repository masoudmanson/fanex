<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Http\Requests\RemittanceForm;
use App\Traits\LogTrait;
use App\Traits\UptTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ServerRequestInterface;

class UptController extends Controller
{
    use UptTrait;
    use LogTrait;

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
        $amount = (float)($request->amount);

        if ($request['currency'] == 'TRY') {
            $upt_result = $this->UPTGetTExchangeData((float)($request->amount), 'TRY', 'EUR');
            $upt_rate = $upt_result['currency_rate'];
            $amount = $upt_rate*$amount ;
        }

//        $result = $this->getEuroExchangeRate();
//        $EuroResult = $result->getBody()->getContents();
        $EuroER = 4000;//($EuroResult)[0]->er;

        $amount = ceil($EuroER*$amount);

        //write to backlog
        $log = new Backlog();
        $log = $this->mainFormBackLog($log,$amount, $request, $upt_result, $EuroER);
        setcookie('backlog', encrypt($log->id), time() + 600);
//        setcookie('ttl', time()+600, time() + 600);
        return  $amount;
    }
}
