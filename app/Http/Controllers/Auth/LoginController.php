<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Traits\TokenTrait;
use Illuminate\Cookie\CookieJar;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use TokenTrait;

    public function __construct()
    {
        $this->middleware('logOut', ['only' => ['logout']]);
    }

    public function showLoginForm(Request $request)
    {
        if (!$request->session()->get('redirect_uri'))
            $request->redirect_uri = $request->root() . '/profile';
        else {
            $request->redirect_uri = $request->session()->get('redirect_uri');
        }
        $id = adapterAssignment()->getId();
        return Redirect::away(config('urls.sso') . 'oauth2/authorize/?client_id='
            . $id . '&response_type=code&redirect_uri=' . $request->redirect_uri . '&scope=profile write');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return Redirect::away(config('urls.sso') . 'oauth2/logout/?continue=' . $request->root());
    }

}
