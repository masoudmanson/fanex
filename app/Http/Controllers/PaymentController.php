<?php

namespace App\Http\Controllers;

use App\Backlog;
use App\Beneficiary;
use Carbon\Carbon;
use Countries;
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
        $this->middleware('checkToken', ['only' => ['proforma_with_selected_transaction','proforma_with_selected_bnf_profile', 'proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice']]);
        $this->middleware('checkUser' , ['only' => ['proforma_with_selected_transaction','proforma_with_selected_bnf_profile', 'proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice']]);
        $this->middleware('checkLog'  , ['only' => ['proforma_with_selected_transaction','proforma_with_selected_bnf_profile', 'proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test');
    }
    public function test()
    {

        $clientIpaddress = $_SERVER['REMOTE_ADDR'];
        dd($clientIpaddress);
// get ip address
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            // get ip address
            $clientIpaddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
            // echo ip address
            echo $clientIpaddress;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function proforma_with_selected_bnf(Request $request)
    {
        $beneficiary = Beneficiary::findOrFail($request->bnf);

        $user_of_bfn = $beneficiary->user;
        if (Auth::user() == $user_of_bfn) {
            $user = Auth::user();
            $transaction = $this->createOrGetTrans($beneficiary);

            $proforma_date = $transaction['created_at'];

            $transaction['hash'] = Crypt::encryptString($transaction);

            $countries = countries(session('applocale'));

            $finish_time = strtotime($transaction['ttl']) - time();

            $request->query->add(['beneficiary' => $beneficiary,
                'transaction_sign' => $transaction['hash'],
                'countries' => $countries,
                'date' => $proforma_date,
                'user' => $user,
                'amount' => $transaction['premium_amount'] . ' ' . $transaction['currency'],
                'finish_time' => $finish_time
            ]);

            return Hash::check($beneficiary, $request->hash)
                ? response()->view('dashboard.proforma', $request->query(), 200)
                : redirect()->back()->withErrors(['msg', 'The Message']);
        }
        return redirect()->back()->withErrors(['msg', "You haven't access to pay this transaction"]);
    }

    public function proforma_with_selected_bnf_profile(Request $request, Beneficiary $beneficiary)
    {
        $transaction = $this->createOrGetTrans($beneficiary);

        $user_of_bfn = $beneficiary->user;
        if (Auth::user() == $user_of_bfn) {
            $user = Auth::user();
            $proforma_date = $transaction['created_at'];
            $countries = countries(session('applocale'));

            $transaction['hash'] = Crypt::encryptString($transaction);

            $finish_time = strtotime($transaction['ttl']) - time();

            $request->query->add(['beneficiary' => $beneficiary,
                'transaction_sign' => $transaction['hash'],
                'countries' => $countries,
                'date' => $proforma_date,
                'user' => $user,
                'amount' => $transaction['premium_amount'] . ' ' . $transaction['currency'],
                'finish_time' => $finish_time
            ]);

            return response()->view('dashboard.proforma', $request->query(), 200);
        }
        return redirect()->back()->withErrors(['msg', "You haven't access to pay this transaction"]);
    }

    /**
     * @param BeneficiaryRequest $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function proforma_with_new_bnf(BeneficiaryRequest $request) //todo : is it necessary to check Auth::user with bnf->user here??!
    {
        $request['user_id'] = Auth::user()->id;
        $user = Auth::user();
        $beneficiary = Beneficiary::create($request->all());

        $transaction = $this->createOrGetTrans($beneficiary);

        $proforma_date = $transaction['created_at'];
        $countries = countries(session('applocale'));
        $transaction['hash'] = Crypt::encryptString($transaction);

        $finish_time = strtotime($transaction['ttl']) - time();

        $request->query->add(['beneficiary' => $beneficiary,
            'transaction_sign' => $transaction['hash'],
            'countries' => $countries,
            'date' => $proforma_date,
            'user' => $user,
            'amount' => $transaction['premium_amount'].' '.$transaction['currency'],
            'finish_time' => $finish_time
        ]);

        return $beneficiary->id
            ? response()->view('dashboard.proforma', $request->query(), 200)
            : redirect()->back()->withErrors(['msg', 'The Message']);
    }

    public function proforma_with_selected_transaction(Request $request, Transaction $transaction)
    {
        $beneficiary = $transaction->beneficiary;
        $log = $transaction->backlog;

        $user_of_bnf = $beneficiary->user;
        if (Auth::user() == $user_of_bnf) {

            if($transaction->uri){
                $reference = $this->trackingInvoiceByBillNumber($transaction->uri);
                $invoice = json_decode($reference->getBody()->getContents());

                if (!$invoice->hasError && count($invoice->result) > 0) {

                    return redirect()->back()->withErrors(['msg', "This transaction has already been done."]); // todo : make a lang
                    //todo : redirect to a single page
                }
            }

            $transaction['hash'] = Crypt::encryptString($transaction);

            $user = Auth::user();
            $proforma_date = $log->created_at;
            $countries = countries(session('applocale'));

            $finish_time = strtotime($transaction['ttl']) - time();

            $request->query->add(['beneficiary' => $beneficiary,
                'transaction_sign' => $transaction['hash'],
                'countries' => $countries,
                'date' => $proforma_date,
                'user' => $user,
                'amount' => $transaction['premium_amount'] . ' ' . $transaction['currency'],
                'finish_time' => $finish_time
            ]);
            $diff = Carbon::now()->diffInSeconds($transaction->ttl);
            setcookie('backlog', encrypt($log->id), time() + $diff, '/');

            return response()->view('dashboard.proforma', $request->query(), 200);
        }
        return redirect()->back()->withErrors(['msg', "You haven't access to pay this transaction"]); // todo : make a lang
    }

    public function issueInvoice(Request $request)
    {
        $id = decrypt($_COOKIE['backlog']);
        $backlog = Backlog::findOrFail($id);
        $result = $this->userInvoice($request, $backlog);

        $invoice = json_decode($result->getBody()->getContents());
        if (!$invoice->hasError) {

            $transaction = Transaction::findOrFail(json_decode(Crypt::decryptString($request->transaction_sign))->id);

            $transaction->uri = $invoice->result->billNumber;
            $transaction->update();

            return redirect(config('urls.private')."pbc/payinvoice/?invoiceId="
                . $invoice->result->id . "&redirectUri=" . $request->root() . "/invoice/show?billNumber=" . $transaction->uri);
        }
        else
            dd($invoice);  //todo: error handling
    }

    public function showInvoice(Request $request)
    {
        $result = $this->trackingInvoiceByBillNumber($request->billNumber);
        $invoice = json_decode($result->getBody()->getContents());

        $finish_time = 0;

        if (!$invoice->hasError && count($invoice->result) > 0) {
            $invoice_result = $invoice->result[0];
            $transaction = Transaction::findByBillNumber($invoice_result->billNumber)->firstOrFail();

            // Converting EPOCH timestamp to UNIX timestamp
            $invoice_result->paymentDate = ceil($invoice_result->paymentDate / 1000);
            $finish_time = strtotime($transaction->ttl) - time();

            if ($invoice_result->payed && !$invoice_result->canceled) {

                $transaction->payment_date = $invoice_result->paymentDate;
                $transaction->vat = $invoice_result->vat;
                $transaction->bank_status = 'successful';
                $transaction->fanex_status = 'pending';

                // todo** : do it after admin accept the payment , in a specific func.**
                $upt_res = $this->CorpSendRequest($transaction, $transaction->user, $transaction->beneficiary, $transaction->backlog);// todo : it must written after fanex admin

                if ($upt_res->CorpSendRequestResult->TransferRequestStatus->RESPONSE == 'Success') {
                    $transaction->fanex_status = 'accepted';

                    $result = $this->CorpSendRequestConfirm($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT);

                    if ($result->CorpSendRequestConfirmResult->TransferConfirmStatus->RESPONSE == 'Success') {
                        $transaction->upt_status = 'successful';
                        $transaction->update();

                    } else {
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
                return view('dashboard.invoice', compact('invoice_result', 'transaction', 'finish_time'));

            } else {
                $transaction->bank_status = 'canceled';
                $transaction->fanex_status = 'rejected';
                $transaction->upt_status = 'failed';
                $transaction->payment_date = time();
                $transaction->update();
                return view('dashboard.invoice', compact('invoice_result', 'transaction', 'finish_time'))->withErrors(['msg' => __('payment.transFailed')]);;
            }

        }
        $error = __('payment.transFailed');
        return view('dashboard.invoice', compact('error', 'finish_time'));
    }

    public function updatePaymentCondition(Request $request)
    {

    }

    /**
     * @param Beneficiary $beneficiary
     * @return Transaction
     */
    public function createOrGetTrans(Beneficiary $beneficiary)
    {
        $id = decrypt($_COOKIE['backlog']);
        $backlog = Backlog::findOrFail($id);

        $transaction = Backlog::find($id)->transaction;
        if(!$transaction) {
            $transaction = new Transaction();

            $transaction->user_id = Auth::user()->id;
            $transaction->beneficiary_id = $beneficiary->id;
            $transaction->backlog_id = $id;
            $transaction->exchange_rate = $backlog->exchange_rate;
            $transaction->premium_amount = $backlog->premium_amount;
            $transaction->payment_amount = $backlog->payment_amount;
            $transaction->currency = $backlog->currency;
            $transaction->payment_type = $backlog->payment_type;
            $transaction->ttl = $backlog->ttl;
            $transaction->country = $backlog->country;

            $transaction->save();
        }
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
