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
//        $multiLangCountries = Countries::lookup(session('applocale'));
        $upt_country_list = $data->CorpGetCountryDataResult->COUNTRYLIST->WSCountry;
//        dd($multiLangCountries);

        $country_list = array();
//
//        foreach ($upt_country_list as $key => $value) {
//            $country = Country::findByCountryCode($value->COUNTRYCODEOUT)->first();
//            $test = array();
//            if(isset($country->id)){
//                $test['enable'] = true;
//                $test['code'] = $value->COUNTRYCODEOUT;
//                $test['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
//                $test['currency'] = $value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit;
////                $value->Enable = true;
//
//                $country_list[$value->COUNTRYCODEOUT] = $test;
//            }
//            else
//            {
////                $value->Enable = false;
//                $test['enable'] = false;
//                $test['code'] = $value->COUNTRYCODEOUT;
//                $test['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
//                $country_list[$value->COUNTRYCODEOUT] = $test;
//            }
//        }

        return view('index', compact('user', 'country_list'));
    }

}
