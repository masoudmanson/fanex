<?php

namespace App\Http\Controllers;

use App\Traits\UptTrait;
use Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\PlatformTrait;

class HomeController extends Controller
{
    use UptTrait;
    use PlatformTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('checkToken');
        $this->middleware('checkTokenHome');
        $this->middleware('checkUserHome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

////        $data = $this->CorpGetCountryData();
//        $data = '';
//        $country_list = indexFormCountryList($data, session('applocale'));

        $result = $this->listProduct();
        $products = json_decode($result->getBody()->getContents())->result;
        $country_list = countryListByProduct($products,Countries::lookup(session('applocale'))['TR']);
        return view('index', compact('user', 'country_list'));
    }
}
