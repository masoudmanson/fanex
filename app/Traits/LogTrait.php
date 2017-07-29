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

    public function mainFormBackLog(Backlog $log,$amount, Request $request, $upt_result, $euro_result=0)
    {
        $log->ip = $this->getClientIp();
        $log->ip = $request->ip();
        $log->currency = $request->currency;
        $log->payment_amount = $amount;
        $log->premium_amount = $request->amount; //todo: I think it has to be added to db
        $log->country = $request->country;
        $log->ttl = time() + 600; //from sarrafi, or agreement
        $log->upt_ttl = time() + 600; //from upt, ws response
        $log->payment_type = 'transfer'; //from form


        if (isset($upt_result)) {
            $log->upt_exchange_rate = $upt_result;
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

    public function getClientIp()
    {
//        $externalContent = file_get_contents('http://checkip.dyndns.com/');
//        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
//        $externalIp = $m[1];
//        return $externalIp;
        $ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
        return $ip;

    }
}