<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('checkToken');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function formController(Request $request)
    {
//
////        dd($request);
//        if($request["calculate"]) {
////            return redirect()->action(
////                'UptController@calculateRemittance', ['id' => 1]
////            );
//            return redirect()->route('calculate', ['id' => 1]);
//        }
//        if($request["payment"]) {
//
//            echo "hi there";
//            //wallet controller
//        }
    }
}
