<?php

namespace App\Http\Middleware;

use App\Transaction;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Crypt;

class CheckTtlExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $transaction = Transaction::findOrFail(json_decode(Crypt::decryptString($request->transaction_sign))->id);

        if(Carbon::now()>$transaction->ttl){
            $request->session()->flash('alert-danger', __('payment.errorTtl'));
            return redirect('/');
        }

        return $next($request);
    }
}
