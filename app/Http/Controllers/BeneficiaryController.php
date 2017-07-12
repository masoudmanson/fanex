<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Http\Requests\BeneficiaryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Countries;

class BeneficiaryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['checkToken', 'checkUser']);
        $this->middleware('checkLog', ['only' => ['createOrSelect']]);
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

        $countries = countries(session('applocale'));

        $filter_countries = array();
        foreach ($beneficiaries as $beneficiary) {
            if (!in_array($beneficiary->country, $filter_countries))
                array_push($filter_countries, $beneficiary->country);
        }

        return view('dashboard.beneficiaries', compact('beneficiaries', 'countries', 'filter_countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = countries(session('applocale'));

        return view("dashboard.add-beneficiary", compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createOrSelect(Request $request)
    {
        $user = Auth::user();

        $beneficiaries = $user->beneficiary()->get();
        foreach ($beneficiaries as $beneficiary) {
            $beneficiary['hash'] = bcrypt($beneficiary);
        }

        $countries = countries(session('applocale'));

        $request->query->add(['beneficiaries' => $beneficiaries, 'countries' => $countries]);
        return view("dashboard.beneficiary", $request->query());
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
     * @param Beneficiary $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function show(Beneficiary $beneficiary)
    {
        return view('beneficiary', compact('beneficiary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Beneficiary $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function edit(Beneficiary $beneficiary)
    {
        $countries = countries(session('applocale'));

        return view('dashboard.edit-beneficiary', compact('beneficiary', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Beneficiary $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        $beneficiary->update($request->all());

        $user = Auth::user();
        $beneficiaries = $user->beneficiary()->get();

        $countries = countries(session('applocale'));

        $filter_countries = array();
        foreach ($beneficiaries as $beneficiary) {
            if (!in_array($beneficiary->country, $filter_countries))
                array_push($filter_countries, $beneficiary->country);
        }

        return view('dashboard.beneficiaries', compact('beneficiaries', 'countries', 'filter_countries'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Beneficiary $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();

        return redirect()->route('beneficiary.list');

    }
}
