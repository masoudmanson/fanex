<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use App\Traits\UptTrait;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
    use TokenTrait;
    use UptTrait;
    use PlatformTrait;

    public function __construct()
    {
        $this->middleware('checkToken'
//            [
//                'only' =>
//                    [
//                        'show',
//                        'index'
//                    ]
//            ]
        );

        $this->middleware('checkUser');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $transactions = $user->transaction;

        foreach ($transactions as $transaction) {
            if (empty($transaction->uri)) {
                if ($transaction->ttl > Carbon::now()) {
                    $transaction['can_pay'] = true;
                } else {
                    $transaction->bank_status = 'failed';
                    $transaction->fanex_status = 'rejected';
                    $transaction->upt_status = 'failed';
                    $transaction->update();
                }
            }
            else {
                $reference = $this->trackingInvoiceByBillNumber($transaction->uri);
                $invoice = json_decode($reference->getBody()->getContents());
                if(isset($invoice->result[0])) {
                    if ($invoice->result[0]->canceled) {
                        $transaction->bank_status = 'canceled';
                        $transaction->fanex_status = 'rejected';
                        $transaction->upt_status = 'failed';
                    } elseif ($invoice->result[0]->payed) {
                        $transaction->bank_status = 'successful';
//                        $transaction->fanex_status = 'successful'; //todo : how do I know?!
//                        $transaction->upt_status = 'successful'; //
                    }
                }
            }
        }
        if ($request->ajax())
            return response()->json(view('dashboard.index', compact('user', 'transactions'))->render());

        return view('dashboard.index', compact('user', 'transactions'));
    }

    public function notifications()
    {
        return view('dashboard.notifications');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function sendMoney(Beneficiary $beneficiary)
    {
        $data = $this->CorpGetCountryData();
        $country_list = indexFormCountryList($data, session('applocale'));
        return view('dashboard.send-money', compact('country_list', 'beneficiary'));
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
     * @param Request|ServerRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

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


    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $user = Auth::user();
        if($keyword == '') {
            $transactions = $user->transaction;
        }
        else {
            $transactions = Transaction::join('beneficiaries', 'transactions.beneficiary_id', '=', 'beneficiaries.id')
            ->where('transactions.user_id', '=', $user->id)
                ->where(function ($query) use ($keyword) {
                    $query->where('transactions.uri', 'like', "%$keyword%")
                        ->orWhere('transactions.premium_amount', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.firstname', 'like', "%$keyword%")
                        ->orWhere('beneficiaries.lastname', 'like', "%$keyword%");
                })->get();
        }
        if ($request->ajax())
            return view('partials.transaction-list-item', compact('transactions'));
    }

}
