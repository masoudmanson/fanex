<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Currency;
use App\Http\Requests\RemittanceForm;
use App\Rate;
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

    public function getExchangeRate($currency)
    {
        $rate_obj = Currency::last($currency)->rates()->last();
        return $rate_obj->rate;
    }

    public function getEuroExchangeRate()
    {
//        $client = new Client();
//        $U_to_R = $client->get('http://localhost:3000/er');
//        return $U_to_R;
        $rates = Rate::last();
//        $rates->exchanger;
//        $rates->currency;
        return $rates->rate;
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
        $upt_rate = 1;
        $EuroER = 1 ;
        $amount = (float)($request->amount);

        if ($request['currency'] == 'TRY') {
//            $upt_result = $this->UPTGetTExchangeData((float)($request->amount), 'TRY', 'EUR');
//            $upt_rate = $upt_result['currency_rate'];
            $upt_rate = $this->getExchangeRate('TRY');
            $amount = ceil($upt_rate * ($amount + $this->calculateCommission($amount , 'TRY')));
        }

        else {
//        $EuroER = $this->getEuroExchangeRate();
            $EuroER = $this->getExchangeRate('EUR');

            $amount = ceil($EuroER * ($amount + $this->calculateCommission($amount, 'EUR')));
        }

        //write to backlog
        $log = new Backlog();
        $log = $this->mainFormBackLog($log, $amount, $request, $upt_rate, $EuroER);
        setcookie('backlog', encrypt($log->id), time() + 600);
//        setcookie('ttl', time()+600, time() + 600);
        return $amount;
    }

    public function calculateCommission($amount, $currency)
    {
         $wage = $currency == 'TRY' ? (0.005 * $amount) + 20 : (0.005 * $amount) + 5;
        return $wage;
    }
}
