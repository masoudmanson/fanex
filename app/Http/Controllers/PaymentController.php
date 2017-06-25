<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Http\Requests\BeneficiaryRequest;
use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use App\Transaction;
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
        $this->middleware('checkToken', ['only' => ['pay', 'invoice']]);
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

        $id = base64_decode($_COOKIE['backlog']);
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->beneficiary_id = $beneficiary->id;
        $transaction->backlog_id = $id;
        $transaction->save();//todo : code cleaning
//        $transaction['hash'] = bcrypt($transaction);
        $transaction['hash'] = Crypt::encryptString($transaction);

        $request->query->add(['beneficiary' => $beneficiary,
            'transaction_sign'=>$transaction['hash']
        ]);
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

        $id = base64_decode($_COOKIE['backlog']);
        $transaction = new Transaction();
        $transaction->user_id = Auth::user();
        $transaction->beneficiary_id = $beneficiary->id;
        $transaction->backlog_id = $id;
        $transaction->save();//todo : code cleaning
//        $transaction['hash'] = bcrypt($transaction);
        $transaction['hash'] = Crypt::encryptString($transaction);

        $request->query->add(['beneficiary' => $beneficiary,
            'transaction_sign'=>$transaction['hash']
        ]);

        return $beneficiary->id
            ? response()->view('dashboard.proforma', $request->query(), 200)
            : redirect()->back()->withErrors(['msg', 'The Message']);
    }

    public function issueInvoice(Request $request)
    {
        $id = base64_decode($_COOKIE['backlog']);
        $backlog = Backlog::findOrFail($id);
        $result = $this->userInvoice($request,$backlog);

        $invoice = json_decode($result->getBody()->getContents());

        if(!$invoice->hasError) {

            $transaction = Transaction::findOrFail(json_decode(Crypt::decryptString($request->transaction_sign))->id);//todo : check it after masouds changes

            $transaction->uri = $invoice->result->billNumber;
            $transaction->update();

            return redirect("http://176.221.69.209:1031/v1/pbc/payinvoice/?invoiceId="
                .$invoice->result->id."&redirectUri=http://" . $_SERVER['HTTP_HOST']  . "/invoice/show");
            //todo : why still not redirect
        }

        else dd($invoice);  //todo: error handling
//        return view('dashboard.invoice');
    }

    public function showInvoice(Request $request)
    {
        var_dump($request->tref);
        dd($request);
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
