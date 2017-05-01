<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function showLoginForm()
    {

        http://demo.fanapium.com:12594/oauth2/authorize/?client_id=474c4fbdbf159b1560e8c230&response_type=token&redirect_uri=http://fanapium.com&prompt=login

        $client = new Client();
        $client_id = '474c4fbdbf159b1560e8c230';
        $res = $client->get('http://demo.fanapium.com:12594/oauth2/authorize/?client_id=474c4fbdbf159b1560e8c230&response_type=token&redirect_uri=localhost:8080&prompt=login');
        echo $res->getStatusCode(); // 200
        echo $res->getBody();

        //sso login form
    }

    public function logout()
    {
        /*
         * logout sso
         */

        //http://demo.fanapium.com:12594/oauth2/logout/
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
