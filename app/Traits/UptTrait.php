<?php


namespace App\Traits;

use App\Backlog;
use App\Beneficiary;
use App\Transaction;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use SoapClient;
use SoapHeader;
use SoapParam;
use SoapVar;

trait UptTrait
{
    public function ListOfAvailableCountries()
    {
        $upt_resp = $this->CorpGetCountryData()->CorpGetCountryDataResult;

        if ($upt_resp->COUNTRYSTATUS->RESPONSE == 'Success') {
            $country_list = $upt_resp->COUNTRYLIST->WSCountry;
        }


    }

    public function UPTGetTExchangeData($amount, $from, $to)
    {
        $upt_resp = $this->CorpGetCurrencyRate($amount, $from, $to)->CorpGetCurrencyRateResult;
        $response_array = array();
        if ($upt_resp->CURRENCYRATESTATUS->RESPONSE == 'Success') {
            $response_array['currency_rate'] = $upt_resp->OUTCURRENCYRATE;
            $response_array['out'] = $upt_resp->OUTPARITY;
        }
        return $response_array;
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

//        $return = $client->__SoapCall('CorpGetCountryData', array());
        $return = $client->CorpGetCountryData();

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

        $body_params = array('obj' => array(
            'FROMCURRENCY' => $from,
            'TOCURRENCY' => $to,
            'TARGETTRANSACTIONTYPECODE' => "002",
            'AMOUNT' => $amount
        ));

        $return = $client->CorpGetCurrencyRate($body_params);

        return $return;
    }

    public function CorpSendRequest(Transaction $transaction , User $user , Beneficiary $beneficiary , Backlog $backlog)
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
//        $client = new SoapClient($url, array("soap_version" => SOAP_1_2, "trace" => 1));
        $client = new SoapClient($url);

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'CORRESPONDENT_PARITY'=>'0',
            'CORRESPONDENT_EXPENSE'=>'0',
            'CORRESPONDENT_COMMISSION'=>'0', // these three parameter weren't on document and didn't used in postman even.but here, it seems necessary


            'SENDER_COUNTRY_CODE' => 'IR', // todo:later it should be detect automatically
            'SENDER_NATIONALITY' => 'IR', // todo: " " " "
            'SENDER_NAME' => Auth::user()->firstname, //todo : auth user name / $user->firstname
            'SENDER_SURNAME' => Auth::user()->lastname,
//            'SENDER_NAME' => 'SEMaH CAN',
//            'SENDER_SURNAME' =>'sAKAR',
//            'BENEFICIARY_COUNTRY_CODE' => $backlog->country,// todo: "to"
            'BENEFICIARY_COUNTRY_CODE' => 'TR',// todo: "to"
            'BENEFICIARY_NAME' => $beneficiary->firstname, //todo : bnf firstname
            'BENEFICIARY_SURNAME' => $beneficiary->lastname, // todo: bnf lastname
//            'BENEFICIARY_NAME' => 'Neslihan', //todo : bnf firstname
//            'BENEFICIARY_SURNAME' => 'Elver', // todo: bnf lastname
            'TRANSACTION_TYPE' => '001', // todo:which type we have to use?!
//            'MONEY_TAKEN_CURRENCY' => 'EUR', // todo ? I think it is EUR
            'MONEY_TAKEN'=>'0',
//            'MONEY_TAKEN_CURRENCY' => 'TRY', // todo ? I think it is EUR
//            'AMOUNT' => $backlog->payment_amount, // todo ?
            'AMOUNT' => 100, // todo ?
//            'AMOUNT_CURRENCY' => $backlog->currency, // currency
            'AMOUNT_CURRENCY' => 'TRY', // currency
        ));

        $return = $client->CorpSendRequest($body_params);
//        $return = $client->__SoapCall('CorpSendRequest', $body_params);

//        dd($return);
        return $return;
    }

    public function CorpSendRequestConfirm($upt_ref)
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'TU_REFNUMBER' => $upt_ref
        ));

        $return = $client->CorpSendRequestConfirm($body_params);

        return $return;
    }

    public function CorpCancelRequest($upt_ref)
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'UPT_REF' => $upt_ref,
            'TRANSACTION_TYPE' => 'G' //according to payment method. G for send transactions , O for payment ????
        ));

        $return = $client->CorpCancelRequest($body_params);

        return $return;
    }
    
    public function CorpCancelConfirm($upt_ref)
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'UPT_REF' => $upt_ref,
            'TRANSACTION_TYPE' => 'G' //according to payment method. G for send transactions , O for payment ????
        ));

        $return = $client->CorpCancelConfirm($body_params);

        return $return;
    }

    public function UptGetTransferList($upt_ref)
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "2818",
            'Password' => "1"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'UPTREF' => $upt_ref,
        ));

        $return = $client->GetTransferList($body_params);

        return $return;
    }
}