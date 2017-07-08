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
    public function proformaPdf()
    {
        $pdf = App::make('dompdf.wrapper');
        $html = '';
        $html .= '
                <div class="row p-0 m-0">
                    <div class="col-xs-12 p-0">
                        <h2 class="dash-subtitle">'.__('payment.prfSubtitle').'</h2>
                        <div class="proforma-wrapper mb-4">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="" alt="Fanex Logo">
                                </div>
                                <div class="col-xs-8 right-align">
                                    <p>Date: '.__('payment.invDate', ['dateEn' => '7 July 2017', 'dateFa' => '17 تیر 1396']).'</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>Money Transfer Application</h2>

                                    <p>Transferring <span>1,500 EUR</span> by following Applicant to specified
                                        beneficiary:</p>

                                    <div class="proforma-heading">
                                        Applicant\'s Identification
                                    </div>

                                    <ul>
                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Mr./Ms./Co.:</p></div>
                                            <div class="col-xs-12 col-sm-6">Masoud Amjadi</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Pass/Id./Reg.No:</p></div>
                                            <div class="col-xs-12 col-sm-6">1640113886</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Date of Birth</p></div>
                                            <div class="col-xs-12 col-sm-6">26 June 1991</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Place of Birth</p></div>
                                            <div class="col-xs-12 col-sm-6">Iran</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Address</p></div>
                                            <div class="col-xs-12 col-sm-6">#13, Zaratash Alley, Ghoddosi St., Ghasr
                                                Sq., Tehran, Iran
                                            </div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Postal Code</p></div>
                                            <div class="col-xs-12 col-sm-6">12326-45879</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Tel</p></div>
                                            <div class="col-xs-12 col-sm-6">021 548 5874</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Mobile</p></div>
                                            <div class="col-xs-12 col-sm-6">0914 840 1824</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Email Address</p></div>
                                            <div class="col-xs-12 col-sm-6">masoudmanson@gmail.com</div>
                                        </li>

                                    </ul>

                                    <div class="proforma-heading">
                                        Beneficiary Details
                                    </div>

                                    <ul>
                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Name:</p></div>
                                            <div class="col-xs-12 col-sm-6">Name</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Country:</p></div>
                                            <div class="col-xs-12 col-sm-6">Country
                                            </div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Address:</p></div>
                                            <div class="col-xs-12 col-sm-6">Address
                                            </div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Tel:</p></div>
                                            <div class="col-xs-12 col-sm-6">Tel</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Fax:</p></div>
                                            <div class="col-xs-12 col-sm-6">Fax</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Bank Name:</p></div>
                                            <div class="col-xs-12 col-sm-6">Bank Name</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Branch Name/ Address:</p></div>
                                            <div class="col-xs-12 col-sm-6">Branch Name/ Address</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>Swift Code</p></div>
                                            <div class="col-xs-12 col-sm-6">Swift Code</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>iBan Code</p></div>
                                            <div class="col-xs-12 col-sm-6">iBan Code</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        return $pdf->loadHTML($html, 'A4', 'portrait')->download('bye.pdf');
    }
}
