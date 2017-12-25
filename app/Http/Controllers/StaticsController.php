<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMail;
use App\Traits\UptTrait;
use App\Traits\PlatformTrait;
use ZanySoft\LaravelPDF\PDF;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Mail;
use Redirect;
use Countries;

class StaticsController extends Controller
{
    use UptTrait;
    use PlatformTrait;

    public function __construct()
    {
    }

    /*
     * About Page
     */
    public function about()
    {
//        $data = $this->CorpGetCountryData();
//        $country_list = indexFormCountryList($data, session('applocale'));
//        $data = '';
//        $country_list = indexFormCountryList($data, session('applocale'));
        $result = $this->listProduct();
        $products = json_decode($result->getBody()->getContents())->result;
        $country_list = countryListByProduct($products,Countries::lookup(session('applocale'))['TR']);
        return view('statics.about', compact('country_list'));
    }

    /*
     * Terms And Conditions Page
     */
    public function terms()
    {
////        $data = $this->CorpGetCountryData();
////        $country_list = indexFormCountryList($data, session('applocale'));
//        $data = '';
//        $country_list = indexFormCountryList($data, session('applocale'));
        $result = $this->listProduct();
        $products = json_decode($result->getBody()->getContents())->result;
        $country_list = countryListByProduct($products,Countries::lookup(session('applocale'))['TR']);
        return view('statics.terms', compact('country_list'));
    }

    /*
     * Contact Page
     */
    public function contact()
    {
        Mapper::map(35.7285423, 51.8229013, ["styles" => '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]']);
        return view('statics.contact');
    }

    /*
     * Contact Page Send Mail
     */
    public function contactMail(ContactFormRequest $request)
    {
        $data_array = [
            'senderName' => 'FANEx Team',
            'firstname' => $request->get('name'),
            'logo' => [
                'path' => 'http://185.104.229.163:12800/vendor/beautymail/assets/images/sunny/logo.png',
                'width' => 150,
                'height' => 50
            ],
            'css' => ".footer-text {padding:0; margin: 0 !important; color: #999; font-family: Tahoma;}",
        ];

        $view = View::make('emails.contact', $data_array);
        $contents = $view->render();
        $result = $this->sendMail('Thank You!',$request->get('email'),$contents);

        return \Redirect::route('contact')->with('message', 'Thanks for contacting us!');
    }
}
