<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 6/19/17
 * Time: 11:51 AM
 */

namespace App\Traits;


use App\Backlog;
use Illuminate\Http\Request;

trait LogTrait
{

    public function mainFormBackLog(Backlog $log,$amount, Request $request, $upt_result, $euro_result)
    {
        $log->ip = $request->ip();
        $log->currency = $request->currency;
        $log->payment_amount = $amount;
        $log->premium_amount = $request->amount; //todo: I think it has to be added to db
        $log->country = $request->country;
        $log->ttl = time() + 600; //from sarrafi, or agreement
        $log->upt_ttl = time() + 600; //from upt, ws response
        $log->payment_type = 'transfer'; //from form


        if (isset($upt_result['currency_rate'])) {
            $log->upt_exchange_rate = $upt_result['currency_rate'];
        }

//        if (isset($euro_result[0]->er)) {
//            $log->exchange_rate = $euro_result[0]->er;
//        }
        if (isset($euro_result)) {
            $log->exchange_rate = $euro_result;
        }
        $log->save();
        return $log;
    }
}