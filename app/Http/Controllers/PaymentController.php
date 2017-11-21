<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Exception;
use File;
use Illuminate\Support\Facades\Input;
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
        $this->middleware('checkToken', ['only' => ['proforma_with_selected_transaction', 'proforma_with_selected_bnf_profile', 'proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice','showInvoice']]);
        $this->middleware('checkUser', ['only' => ['proforma_with_selected_transaction', 'proforma_with_selected_bnf_profile', 'proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice','showInvoice']]);
        $this->middleware('checkLog', ['only' => ['proforma_with_selected_bnf_profile', 'proforma_with_selected_bnf', 'proforma_with_new_bnf', 'issueInvoice']]);
        $this->middleware('checkTtl', ['only' => ['issueInvoice']]);
        $this->middleware('authorized', ['only' => ['issueInvoice']]);
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
                'amount' => $transaction['premium_amount'],
                'payable' =>$transaction['payment_amount'],
                'currency' => $transaction['currency'],
                'finish_time' => $finish_time
            ]);

            return Hash::check($beneficiary, $request->hash)
                ? response()->view('dashboard.proforma', $request->query(), 200)
                : abort('402');
        }
        return abort('401');
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
                'amount' => $transaction['premium_amount'],
                'payable' =>$transaction['payment_amount'],
                'currency' => $transaction['currency'],
                'finish_time' => $finish_time
            ]);

            return response()->view('dashboard.proforma', $request->query(), 200);
        }
        return abort('401');
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
            'amount' => $transaction['premium_amount'],
            'payable' =>$transaction['payment_amount'],
            'currency' => $transaction['currency'],
            'finish_time' => $finish_time
        ]);

        return $beneficiary->id
            ? response()->view('dashboard.proforma', $request->query(), 200)
//            : redirect()->back()->withErrors(['msg', 'The Message']);
            : abort('402');
    }

    public function proforma_with_selected_transaction(Request $request, Transaction $transaction)
    {
        $beneficiary = $transaction->beneficiary;
        $log = $transaction->backlog;

        $user_of_bnf = $beneficiary->user;
        if (Auth::user() == $user_of_bnf) {

            if ($transaction->uri) {
                $reference = $this->trackingInvoiceByBillNumber($transaction->uri);
                $invoice = json_decode($reference->getBody()->getContents());

                if (!$invoice->hasError && count($invoice->result) > 0) {

                    $request->session()->flash('alert-danger', __('payment.errorDone'));
                    return redirect('/');
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
                'amount' => $transaction['premium_amount'],
                'payable' =>$transaction['payment_amount'],
                'currency' => $transaction['currency'],
                'finish_time' => $finish_time
            ]);
            $diff = Carbon::now()->diffInSeconds($transaction->ttl);
            setcookie('backlog', encrypt($log->id), time() + $diff, '/');

            return response()->view('dashboard.proforma', $request->query(), 200);
        }
        return abort('401');
//        throw new CustomException();
    }

    public function issueInvoice(Request $request)
    {
        $id = decrypt($_COOKIE['backlog']);
        $backlog = Backlog::findOrFail($id);
        $result = $this->userInvoice($request, $backlog);

        $invoice = json_decode($result->getBody()->getContents());
        if (!$invoice->hasError) {

            $transaction = Transaction::findOrFail(json_decode(Crypt::decryptString($request->transaction_sign))->id);

            $transaction->uri = $invoice->result->billNumber; // uri = unique reference number
            $transaction->update();

            return redirect(config('urls.private') . "pbc/payinvoice/?invoiceId="
                . $invoice->result->id . "&redirectUri=" . $request->root() . "/invoice/show?billNumber=" . $transaction->uri);
        } else
            return abort('402');
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
//                $transaction->fanex_status = 'pending';
                $transaction->fanex_status = 'waiting';

                // todo** : do it after admin accepted the payment , in a specific func.**
                $upt_res = $this->CorpSendRequest($transaction, $transaction->user, $transaction->beneficiary, $transaction->backlog);

                if ($upt_res->CorpSendRequestResult->TransferRequestStatus->RESPONSE == 'Success') {
                    $transaction->fanex_status = 'accepted';
                    $transaction->upt_ref = $upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT;

                    $result = $this->CorpSendRequestConfirm($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT);

                    if ($result->CorpSendRequestConfirmResult->TransferConfirmStatus->RESPONSE == 'Success') {
                        $transaction->upt_status = 'successful';
                        $transaction->update();

                    } else {
                        $transaction->upt_status = 'failed'; //or rejected?
//                        $transaction->fanex_status = 'pending';
                        $transaction->update();
//                  $this->CorpCancelRequest($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT);
//                  $this->CorpCancelConfirm($upt_res->CorpSendRequestResult->TU_REFNUMBER_OUT); // todo: check it later
//                        return json_encode(array('status' => false, 'msg' => 'تایید ارسال حواله با خطا روبرو شد')); //upt request has problem.
                    }
                } else {
                    //if ($cancel_res)
//                    $transaction->fanex_status = 'pending'; // it's already on pending condition
                    $transaction->upt_status = 'failed'; //?
                    $transaction->update();
//                    return json_encode(array('status' => false, 'msg' => 'درخواست ارسال با خطا روبرو شد')); //upt request has problem.
                }
//                $transaction->update();

                if(Auth::user()->email) {
                    // Email to User
                    $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                    $beautymail->send('emails.invoice', [
                        'senderName' => 'FANEx Team',
                        'firstname' => Auth::user()->firstname . ' ' . Auth::user()->lastname,
                        'logo' => [
                            'path' => 'http://185.104.229.163:12800/vendor/beautymail/assets/images/sunny/logo.png',
                            'width' => 150,
                            'height' => 50
                        ],
                        'css' => ".footer-text {padding:0; margin: 0 !important; color: #999; font-family: Tahoma;}",
                        'transaction' => $transaction,
                        'invoice_result' => $invoice_result,
                        'transaction_status' => true
                    ], function ($message) use ($request) {
                        $message
                            ->from('fanex@fanap.ir')
                            ->to(Auth::user()->email, Auth::user()->firstname . ' ' . Auth::user()->lastname)
                            ->subject('Thank You!');
                    });
                }

                return view('dashboard.invoice', compact('invoice_result', 'transaction', 'finish_time'));

            } else {
                $transaction->bank_status = 'canceled';
                $transaction->fanex_status = 'rejected';
                $transaction->upt_status = 'failed';
                $transaction->payment_date = time();
                $transaction->update();
                if(Auth::user()->email) {
                    // Email to User
                    $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                    $beautymail->send('emails.invoice', [
                        'senderName' => 'FANEx Team',
                        'firstname' => Auth::user()->firstname . ' ' . Auth::user()->lastname,
                        'logo' => [
                            'path' => 'http://185.104.229.163:12800/vendor/beautymail/assets/images/sunny/logo.png',
                            'width' => 150,
                            'height' => 50
                        ],
                        'css' => ".footer-text {padding:0; margin: 0 !important; color: #999; font-family: Tahoma;}",
                        'transaction' => $transaction,
                        'invoice_result' => $invoice_result,
                        'transaction_status' => false
                    ], function ($message) use ($request) {
                        $message
                            ->from('fanex@fanap.ir')
                            ->to(Auth::user()->email, Auth::user()->firstname . ' ' . Auth::user()->lastname)
                            ->subject('Thank You!');
                    });
                }

                return view('dashboard.invoice', compact('invoice_result', 'transaction', 'finish_time'))->withErrors(['msg' => __('payment.transFailed')]);;
            }

        }
        $error = __('payment.transFailed');
        return view('dashboard.invoice', compact('error', 'finish_time'));
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
        if (!$transaction || $transaction->beneficiary_id != $beneficiary->id) {
            $transaction = new Transaction();

            $transaction->user_id = Auth::user()->id;
            $transaction->beneficiary_id = $beneficiary->id;
            $transaction->backlog_id = $id;
            if ($backlog->currency == 'TRY')
                $transaction->exchange_rate = $backlog->upt_exchange_rate;
            else
                $transaction->exchange_rate = $backlog->exchange_rate;
            $transaction->premium_amount = $backlog->premium_amount;
            $transaction->payment_amount = $backlog->payment_amount;
            $transaction->currency = $backlog->currency;
            $transaction->payment_type = $backlog->payment_type;
            $transaction->ttl = $backlog->ttl;
            $transaction->country = $backlog->country;
            $transaction->receiver_account = $beneficiary->account_number;
            $transaction->receiver_firstname = $beneficiary->firstname;
            $transaction->receiver_lastname = $beneficiary->lastname;

            $transaction->save();
        }
        return $transaction;
    }

    private function upload_file($file, $request, $bill_number, $file_type, $is_image = false)
    {
        $path = config('path.factors_pdf') . $request['user_id'] . '/' . $bill_number;

        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $store = $file->store($path);
    }
}
