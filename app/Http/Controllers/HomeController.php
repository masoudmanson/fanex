<?php

namespace App\Http\Controllers;

use App\Country;
use App\Traits\UptTrait;
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

        $upt_country_list = $data->CorpGetCountryDataResult->COUNTRYLIST->WSCountry;

        $country_list = array();

        foreach ($upt_country_list as $key => $value) {
            $country = Country::findByCountryCode($value->COUNTRYCODEOUT)->first();
            if(isset($country->id)){
                $value->Enaible = true;
                $country_list[$value->COUNTRYCODEOUT] = $value;
            }
            else
            {
                $value->Enaible = false;
                $country_list[$value->COUNTRYCODEOUT] = $value;
            }
        }

        return view('index', compact('user', 'country_list'));
    }

}
