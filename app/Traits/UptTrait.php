<?php


namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

use SoapClient;
use SoapHeader;
use SoapParam;
use SoapVar;

trait UptTrait
{
    public function ListOfAvailableCountries()
    {
        $upt_resp = $this->CorpGetCountryData()->CorpGetCountryDataResult;

        if($upt_resp->COUNTRYSTATUS->RESPONSE == 'Success')
        {
            $country_list = $upt_resp->COUNTRYLIST->WSCountry ;
        }


    }
    
    public function CorpGetCountryData()
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

        $return = $client->__SoapCall('CorpGetCountryData', array());

        dd($return->CorpGetCountryDataResult->COUNTRYLIST->WSCountry[3]);
        return $return;

    }

    public function CorpGetCurrencyRate($amount = 0, $from = 'EUR', $to = 'TRY')
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' =>array(
            'FROMCURRENCY' => $from,
            'TOCURRENCY' => $to,
            'TARGETTRANSACTIONTYPECODE' => "002",
            'AMOUNT' => $amount
        ));


        $return = $client->CorpGetCurrencyRate($body_params);

        return $return;
    }
}