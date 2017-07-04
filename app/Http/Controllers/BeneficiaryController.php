<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Http\Requests\BeneficiaryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkToken');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $beneficiaries = $user->beneficiary()->get();
        return view('dashboard.beneficiaries', compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.add-beneficiary");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BeneficiaryRequest $request
     * @return \Illuminate\Http\Response
     * @internal param $
     */
    public function store(BeneficiaryRequest $request)
    {

        $request['user_id'] = Auth::user()->id;

        Beneficiary::create($request->all());

        return redirect('beneficiaries');

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

    }
}
