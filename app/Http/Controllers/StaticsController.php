<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMail;
use App\Traits\UptTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Mail;
use Redirect;

class StaticsController extends Controller
{
    use UptTrait;

    public function __construct()
    {
    }

    /*
     * About Page
     */
    public function about()
    {
        $data = $this->CorpGetCountryData();
        $country_list = indexFormCountryList($data, session('applocale'));
        return view('statics.about', compact('country_list'));
    }

    /*
     * Terms And Conditions Page
     */
    public function terms()
    {
        $data = $this->CorpGetCountryData();
        $country_list = indexFormCountryList($data, session('applocale'));
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
    public function sendMail(ContactFormRequest $request)
    {
        $content = [
            'title'=> $request->get('name'),
            'body'=> $request->get('contactText'),
            'button' => 'Go to Fanex'
        ];
        $receiverAddress = $request->get('email');
        Mail::to($receiverAddress)->send(new ContactMail($content));

        return \Redirect::route('contact')->with('message', 'Thanks for contacting us!');
    }


    /**
     * @return mixed
     */
    public function pdf()
    {
        $pdf = App::make('dompdf.wrapper');
        $html =
<<<'ENDHTML'
<html>
<body>
<h1>Hello Masoud</h1>
</body>
</html>
ENDHTML;
        $pdf->loadHTML($html);
        return $pdf->download();
    }
}
