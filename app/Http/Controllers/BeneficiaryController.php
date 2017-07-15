<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Http\Requests\BeneficiaryRequest;
use App\User;
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
        $beneficiaries = $user->beneficiary()->available()->get();

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

        $beneficiaries = $user->beneficiary()->available()->get();
        foreach ($beneficiaries as $beneficiary) {
            $beneficiary['hash'] = bcrypt($beneficiary);
        }

        $id = decrypt($_COOKIE['backlog']);
        $backlog = Backlog::findOrFail($id);
        $finish_time = strtotime($backlog->ttl) - time();

        $countries = countries(session('applocale'));

        $request->query->add(['beneficiaries' => $beneficiaries, 'countries' => $countries, 'finish_time' => $finish_time]);
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

        return redirect()->action('BeneficiaryController@index');
    }

    public function destroy(Beneficiary $beneficiary, Request $request)
    {
        $beneficiary->is_deleted = 1;
        $beneficiary->save();

        if ($request->ajax())
            return response()->json(true);

        return redirect()->action('BeneficiaryController@index');
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $user = Auth::user();
        if($keyword == '') {
            $beneficiaries = $user->beneficiary;
        }
        else {
            $beneficiaries = Beneficiary::available()->where('beneficiaries.user_id', '=', $user->id)
                ->where(function ($query) use ($keyword) {
                    $query->where('beneficiaries.firstname', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.lastname', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.account_number', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.swift_code', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.iban_code', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.tel', 'like', "%$keyword%");
                })->get();
        }
        $countries = countries(session('applocale'));

        if ($request->ajax())
            return view('partials.beneficiaty-list-item', compact('beneficiaries', 'countries'));
    }
}
