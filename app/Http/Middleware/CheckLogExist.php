<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckLogExist
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
        if(isset($_COOKIE['backlog'])){
            return $next($request);
        }
//        Session::flash('message', 'This is a message!');
//        Session::flash('alert-class', 'alert-danger');
        $request->session()->flash('alert-danger', __('payment.errorTtl'));
        return redirect('/');
    }
}
