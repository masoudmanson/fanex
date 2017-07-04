<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use App\Http\Requests\BeneficiaryRequest;
use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use App\Traits\UptTrait;
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
    use UptTrait;

    public function __construct()
    {
        $this->middleware('checkToken', ['only' => ['pay', 'invoice']]);
        $this->middleware('checkUser', ['only' => ['pay']]);
        $this->middleware('checkLog', ['only' => ['proforma_with_selected_bnf_profile','proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice']]);
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

        $transaction = $this->createNewTrans($beneficiary);

        $transaction['hash'] = Crypt::encryptString($transaction);

        $request->query->add(['beneficiary' => $beneficiary,
            'transaction_sign' => $transaction['hash']
        ]);
        return Hash::check($beneficiary, $request->hash)
            ? response()->view('dashboard.proforma', $request->query(), 200)
            : redirect()->back()->withErrors(['msg', 'The Message']);
    }

    public function proforma_with_selected_bnf_profile(Request $request, Beneficiary $beneficiary)
    {
        $transaction = $this->createNewTrans($beneficiary);

        $transaction['hash'] = Crypt::encryptString($transaction);

        $request->query->add(['beneficiary' => $beneficiary,
            'transaction_sign' => $transaction['hash']
        ]);

        return response()->view('dashboard.proforma', $request->query(), 200);
    }


    /**
     * @param BeneficiaryRequest $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function proforma_with_new_bnf(BeneficiaryRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        $beneficiary = Beneficiary::create($request->all());

        $transaction = $this->createNewTrans($beneficiary);

        $transaction['hash'] = Crypt::encryptString($transaction);

        $request->query->add(['beneficiary' => $beneficiary,
            'transaction_sign' => $transaction['hash']
        ]);

        return $beneficiary->id
            ? response()->view('dashboard.proforma', $request->query(), 200)
            : redirect()->back()->withErrors(['msg', 'The Message']);
    }

    public function issueInvoice(Request $request)
    {
        $id = decrypt($_COOKIE['backlog']); // todo: maybe it's better to do that with middleware. !important!
        $backlog = Backlog::findOrFail($id);
        $result = $this->userInvoice($request, $backlog);

        $invoice = json_decode($result->getBody()->getContents());

        if (!$invoice->hasError) {

            $transaction = Transaction::findOrFail(json_decode(Crypt::decryptString($request->transaction_sign))->id);//todo : check it after masouds changes

            $transaction->uri = $invoice->result->billNumber;
            $transaction->update();

            return redirect("http://sandbox.fanapium.com:1031/v1/pbc/payinvoice/?invoiceId="
                . $invoice->result->id . "&redirectUri=" . $request->root() . "/invoice/show?billNumber=" . $transaction->uri);
        } else dd($invoice);  //todo: error handling
//        return view('dashboard.invoice');
    }

    public function showInvoice(Request $request)
    {
        $result = $this->trackingInvoiceByBillNumber($request->billNumber);
        $invoice = json_decode($result->getBody()->getContents());
//dd($invoice);
        if (!$invoice->hasError && count($invoice->result) > 0) {
            $invoice_result = $invoice->result[0];
            if ($invoice_result->payed && !$invoice_result->canceled) {

                $transaction = Transaction::findByBillNumber($invoice_result->billNumber)->firstOrFail();
                $transaction->bank_status = 'successful';
                $transaction->fanex_status = 'pending';

//                if (!$flag)
//                    $this->cancelInvoice($result->id);//

                // todo** : do it after admin accept the payment , in a specific func.**
                $upt_res = $this->CorpSendRequest($transaction, $transaction->user, $transaction->beneficiary, $transaction->backlog);// todo : it must written after fanex admin

                if ($upt_res->CorpSendRequestResult->TransferRequestStatus->RESPONSE == 'Success') {
                    $transaction->fanex_status = 'accepted';

                    $result = $this->CorpSendRequestConfirm($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT);

                    if ($result->CorpSendRequestConfirmResult->TransferConfirmStatus->RESPONSE == 'Success') {
                        $transaction->upt_status = 'successful';
                        $transaction->update();

                    }
                    else{
                        $transaction->upt_status = 'failed'; //or rejected?
                        $transaction->fanex_status = 'pending';
                        $transaction->update();
//                  $this->CorpCancelRequest($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT);
//                  $this->CorpCancelConfirm($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT); // todo: check it later
                    }
                } else {
                    //if ($cancel_res)
//                    $transaction->fanex_status = 'pending'; // it's already on pending condition
                    $transaction->upt_status = 'failed'; //?
                    $transaction->update();
                    // return ?
                }
                $back_log = $transaction->backlog;
                $beneficiary = $transaction->beneficiary;
                return view('dashboard.invoice', compact('invoice_result','beneficiary','back_log'));

            } else {
//                    return error;
                dd('there is no invoice to show');
            }

        }

        //$this->cancelInvoice($request->$billNumber);
        return view('dashboard.invoice', compact(''));
    }

    public function updatePaymentCondition(Request $request)
    {

    }

    /**
     * @param Beneficiary $beneficiary
     * @return Transaction
     */
    public function createNewTrans(Beneficiary $beneficiary)
    {
        $id = decrypt($_COOKIE['backlog']);
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->beneficiary_id = $beneficiary->id;
        $transaction->backlog_id = $id;
        $transaction->save();//todo : code cleaning
        return $transaction;
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
