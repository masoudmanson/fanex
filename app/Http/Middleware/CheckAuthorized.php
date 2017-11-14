<?php

namespace App\Http\Middleware;

use App\Identifier;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $identifier = Identifier::other()->first();
        if (Auth::user()->identifier_id == $identifier->id) {
            $request->session()->flash('alert-success', __('auth.otherMsg'));
            return redirect('/');
        }
        if(!Auth::user()->is_authorized)
        {
            $request->session()->flash('alert-danger', __('auth.notAuth'));
            return redirect('/');
        }
        return $next($request);
    }
}
