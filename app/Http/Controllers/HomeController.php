<?php

namespace App\Http\Controllers;

use App\Country;
use App\Traits\UptTrait;
use Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use UptTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('checkToken');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $data = $this->CorpGetCountryData();
        $multiLangCountries = Countries::lookup(session('applocale'));
        $upt_country_list = $data->CorpGetCountryDataResult->COUNTRYLIST->WSCountry;
        $country_list = array();

        foreach ($upt_country_list as $key => $value) {
            if($value->COUNTRYCODEOUT == "KV")
                continue;
            $country = Country::findByCountryCode($value->COUNTRYCODEOUT)->first();
            $test = array();
            if (isset($country->id) && $country->id > 0) {
                $test['enable'] = 1;
                $test['code'] = $value->COUNTRYCODEOUT;
                $test['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
                $test['currency'] = array();
                if (is_array($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit)) {
                    foreach ($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit as $curr) {
                        if ($curr->TRANSACTION_TYPE == "008")
                            $test['currency'][$curr->CURRENCY] = __('index.'.$curr->CURRENCY);
                    }
                } else {
                    if (!empty($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY))
                        $test['currency'][$value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY] = __('index.'.$value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY);
                    else
                        continue;
                }
                $country_list[$value->COUNTRYCODEOUT] = $test;
            } else {
                $test['enable'] = 0;
                $test['code'] = $value->COUNTRYCODEOUT;
                $test['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
                $test['currency'] = array();
                $country_list[$value->COUNTRYCODEOUT] = $test;
            }
        }
        arsort($country_list);

        return view('index', compact('user', 'country_list'));
    }

}
