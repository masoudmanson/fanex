<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Traits\TokenTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function showLoginForm(Request $request)
    {
        if (!$request->session()->get('redirect_uri'))
//            $request->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/callback/profile';
            $request->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/profile';
        else {

            $request->redirect_uri = $request->session()->get('redirect_uri');
//            $redirect_uri = $request->session()->get('redirect_uri');
            $request->queryString = $request->session()->get('query_string');
//            $request->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/callback'.'/'.$redirect_uri;
        }

        $id = adapterAssignment()->getId();

        return Redirect::away('http://sandbox.fanapium.com/oauth2/authorize/?client_id=' . $id . '&response_type=code&redirect_uri=' . $request->redirect_uri . '&state='.$request->queryString.'&prompt=login');

//        return \Redirect::away('http://sandbox.fanapium.com/oauth2/authorize?'.$queryString);
//        return \redirect('http://sandbox.fanapium.com/oauth2/authorize?'.$queryString);

        //sso login form
    }

    public function logout(Request $request)
    {
        $this->revokeToken(Auth::user()->api_token);
        Auth::logout();
        return Redirect::away('http://sandbox.fanapium.com/oauth2/logout/?continue='.$request->root());
    }

    public function showRegistrationForm()
    {
        /*
         *  http://demo.fanapium.com:12594/oauth2/authorize/?client_id=474c4fbdbf159b1560e8c230&response_type=token&redirect_uri=http://fanapium.com&prompt=signup
         */
    }


//    use AuthenticatesUsers;
//
//    /**
//     * Where to redirect users after login.
//     *
//     * @var string
//     */
//    protected $redirectTo = '/home';
//
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('guest', ['except' => 'logout']);
//    }
}
