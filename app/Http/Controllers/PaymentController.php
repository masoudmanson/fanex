<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Http\Requests\BeneficiaryRequest;
use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    use TokenTrait;
    use PlatformTrait;

    public function __construct()
    {
        $this->middleware('checkToken', ['only' => ['pay']]);
        $this->middleware('checkUser', ['only' => ['pay']]);
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

    public function test(Request $request)
    {

//        dd($request->input());
//        dd(Auth::user()->api_token);
        $request->headers->set('authorization', 'Bearer ' . Auth::user()->api_token);

        return $this->userInvoice($request);

    }

    public function pay(Request $request)
    {
        //todo keywords:state, base64,decode,view

        $user = Auth::user();

        $beneficiaries = $user->beneficiary()->get();
        foreach ($beneficiaries as $beneficiary) {
            $beneficiary['hash'] = bcrypt($beneficiary);
        }

        $request->query->add(['beneficiaries' => $beneficiaries]);
        return response()->view('dashboard.beneficiary', $request->query(), 200);//->withCookie($cookie);
//            ->header('authorization', 'Bearer ' . $request->bearerToken());
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function proforma_with_selected_bnf(Request $request)
    {
        $beneficiary = Beneficiary::findOrFail($request->bnf);
        $request->query->add(['beneficiary' => $beneficiary]);
        return Hash::check($beneficiary, $request->hash)
            ? response()->view('dashboard.proforma', $request->query(), 200)
            : redirect()->back()->withErrors(['msg', 'The Message']);
    }


    /**
     * @param BeneficiaryRequest $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function proforma_with_new_bnf(BeneficiaryRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        $beneficiary = Beneficiary::create($request->all());

        $request->query->add(['beneficiary' => $beneficiary]);

        return $beneficiary->id
            ? response()->view('dashboard.proforma', $request->query(), 200)
            : redirect()->back()->withErrors(['msg', 'The Message']);
    }

    public function invoice()
    {
        return view('dashboard.invoice');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
