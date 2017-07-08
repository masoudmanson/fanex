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
        $html =
<<<'ENDHTML'
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="Group%209.png" style="width:100%; max-width:100px;">
                            </td>
                            
                            <td>
                                شماره فاکتور: 123<br>
                                تاریخ: 17 تیر 1396<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                سامانه برخط ارسال حواله بین المللی FANEx<br>
                                ایران، تهران، پارک علم و فناوری پردیس<br>
                                خ نوآوری 12، پلاک 123، ساختمان فناپ
                            </td>
                            
                            <td>
                                صرافی پاسارگاد<br>
                                pasargadexchange.com<br>
                                feedback@fanex.ir
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td>
                    <h1>فرم درخواست صدور حواله</h1>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Website design
                </td>
                
                <td>
                    $300.00
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Hosting (3 months)
                </td>
                
                <td>
                    $75.00
                </td>
            </tr>
            
            <tr class="item last">
                <td>
                    Domain name (1 year)
                </td>
                
                <td>
                    $10.00
                </td>
            </tr>
            
            <tr class="total">
                <td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
ENDHTML;
        $pdf->loadHTML($html);
        return $pdf->download();
    }
}
