<?php


namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

use SoapClient;
use SoapHeader;

trait UptTrait
{
    public function CorpGetCountryData()
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/','WsSystemUserInfo',$user_param, false);

        $client->__setSoapHeaders($header);

        $return = $client->__SoapCall('CorpGetCountryData', array());

        dd($return);


    }
}