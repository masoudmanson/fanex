<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Cookie;

use Illuminate\Support\Facades\Cookie;

class CallbackController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkToken', ['only' => ['callbackHandler']]);
//        $this->middleware('checkUser', ['only' => ['pay']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function callbackHandler(Request $request , $callback)
    {

        $state = $request->state;
        $token = $request->bearerToken();

        $cookie = Cookie::make('token', $token, 60, null, null, FALSE, TRUE); //todo hint: is it secure enough??

        return redirect('test')
            ->with(['state'=>$state])
            ->withCookie($cookie);

//            ->withCookie(cookie("MyCookie",'salam',3600,"","",TRUE, True));

//        return response()->view('beneficiary', $request->query(), 200)->withCookie(cookie("token",'salam',3600,"","",TRUE, true));



    }

}