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

//        $data = $this->CorpGetCountryData();
        $data = '';
//        $country_list = indexFormCountryList($data, session('applocale'));

        $result = $this->listProduct();
        $products = json_decode($result->getBody()->getContents())->result;

        $response = array();
        $response['TR'] = array();
//        $response['TR']['enable'] = (int)$product->enable;
        $response['TR']['enable'] = 1;
        $response['TR']['code'] = 'TR';
        $response['TR']['name'] = Countries::lookup(session('applocale'))['TR'];

        foreach ($products as $product){
            $response['TR']['currency'][$product->description] = [
                'type' => $product->description,
                'name' => __('index.'.$product->description),
                'sign' => __('index.sign.'.$product->description),
                'product_id' => $product->entityId
            ];
        }
        $country_list = $response;
        return view('index', compact('user', 'country_list'));
    }
}
