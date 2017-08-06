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

    public function filterCountires()
    {
        $beneficiaries = Auth::user()->beneficiary()->available()->get();
        $filter_countries = array();
        foreach ($beneficiaries as $beneficiary) {
            if (!in_array($beneficiary->country, $filter_countries))
                array_push($filter_countries, $beneficiary->country);
        }
        return $filter_countries;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $beneficiaries = $user->beneficiary()->available()->paginate(5);
        $countries = countries(session('applocale'));
        $filter_countries = $this->filterCountires();

        if ($request->ajax())
            return response()->json(view('partials.beneficiaty-list-item', compact('beneficiaries', 'countries'))->render());

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
     * @param BeneficiaryRequest|Request $request
     * @param Beneficiary $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(BeneficiaryRequest $request, Beneficiary $beneficiary)
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

    public function search(Request $request, $keyword)
    {
        $user = Auth::user();
        if($keyword == '') {
            $beneficiaries = $user->beneficiary()->available()->orderby("beneficiaries.id", "desc")->paginate(10);
        }
        else {
            $beneficiaries = Beneficiary::available()->where('beneficiaries.user_id', '=', $user->id)
                ->where(function ($query) use ($keyword) {
                    $query->whereRaw("regexp_like(beneficiaries.firstname, '$keyword', 'i')")
                        ->orWhereRaw("regexp_like(beneficiaries.lastname, '$keyword', 'i')")
                        ->orWhere('beneficiaries.account_number', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.tel', 'like', "%$keyword%");
                })->orderby("beneficiaries.id", "desc")->paginate(10);
        }
        $countries = countries(session('applocale'));


        if ($request->ajax())
            return response()->json(view('partials.beneficiaty-list-item', compact('beneficiaries', 'countries'))->render());

        else {
            $filter_countries = $this->filterCountires();
            return view('dashboard.beneficiaries', compact('beneficiaries', 'countries', 'filter_countries'));
        }
    }

    public function searchCountry(Request $request, $country)
    {
        $keyword = $country;
        $user = Auth::user();
        if($keyword == 'all') {
            $beneficiaries = $user->beneficiary()->available()->paginate(10);
        }
        else {
            $beneficiaries = Beneficiary::available()->where('beneficiaries.user_id', '=', $user->id)
                ->where("beneficiaries.country", '=', $country)->orderby("beneficiaries.id", "desc")->paginate(10);
        }
        $countries = countries(session('applocale'));

        if ($request->ajax())
            return response()->json(view('partials.beneficiaty-list-item', compact('beneficiaries', 'countries'))->render());

        else {
            $filter_countries = $this->filterCountires();

            return view('dashboard.beneficiaries', compact('beneficiaries', 'countries', 'filter_countries'));
        }
    }
}
