<?php

namespace App\Http\Controllers;

use App\Traits\TokenTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use TokenTrait;

    public function __construct()
    {
//        $this->middleware('checkToken', ['only' => ['pay']]);
//        $this->middleware('checkUser', ['only' => ['pay']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        return view('test' , compact('redirect_uri'));
        return view('test');
    }

    public function pay(Request $request)
    {
//dd($request);
        //todo keywords:state, base64,decode,view

        return response()->view('dashboard.beneficiary', $request->query(), 200)->header('authorization', 'Bearer ' . $request->bearerToken());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
