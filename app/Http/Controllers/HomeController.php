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

        $country_list = $data->CorpGetCountryDataResult->COUNTRYLIST->WSCountry;

//        $countries = new Country();
//
//        foreach ($countries as $country)
//        {
//            if ()
//        }

        return view('index',compact('user','country_list'));
    }

}
