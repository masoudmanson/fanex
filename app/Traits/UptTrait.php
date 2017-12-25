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
        //return $country_list;
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
//        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL'; // test server
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
//            'Username' => "2818", //test user
//            'Password' => "1"  //test pass
            'Username' => "9590",
            'Password' => "Fanex@123456!"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, false);

        $client->__setSoapHeaders($header);

//        $return = $client->__SoapCall('CorpGetCountryData', array());
        $return = $client->CorpGetCountryData();

        return $return;

    }

    public function CorpGetCurrencyRate($amount = 0, $from = 'EUR', $to = 'TRY')
    {
//        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
//            'Username' => "2818",
//            'Password' => "1"
            'Username' => "9590",
            'Password' => "Fanex@123456!"
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

    public function CorpSendRequest(Transaction $transaction, User $user, Beneficiary $beneficiary, Backlog $backlog)
    {
//        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_2, "trace" => 1));

        $user_param = array(
//            'Username' => "2818",
//            'Password' => "1"
            'Username' => "9590",
            'Password' => "Fanex@123456!"
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param, true);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'CORRESPONDENT_PARITY' => '0',
            'CORRESPONDENT_EXPENSE' => '0',
            'CORRESPONDENT_COMMISSION' => '0', // these three parameter weren't on document and didn't used in postman even.but here, it seems necessary
//            'SENDER_CITIZENSHIP_NO' => '14695448',
//            'SENDER_ID_TYPE' => 'pasport',
//            'SENDER_ID_NO'=>'3',

            'SENDER_COUNTRY_CODE' => 'IR', // todo:later it should be detect automatically
            'SENDER_NATIONALITY' => 'IR', // todo: " " " "

            'SENDER_NAME' => Auth::user()->firstname_latin,
            'SENDER_SURNAME' => Auth::user()->lastname_latin,
            'BENEFICIARY_COUNTRY_CODE' => 'TR',// todo: "to". (like above line)
            'BENEFICIARY_NAME' => $beneficiary->firstname,
            'BENEFICIARY_SURNAME' => $beneficiary->lastname,
            'BENEFICIARY_GSM_COUNTRY_CODE' => '0090',
//            'BENEFICIARY_GSM_NO' => '5314093654', //farzad sarseyfi mobile
            'BENEFICIARY_GSM_NO' => $beneficiary->tel, //farzad sarseyfi mobile
//            'BENEFICIARY_IBAN' => 'TR290006400000164310007808', //example test
            'BENEFICIARY_IBAN' => $beneficiary->iban_code,

            'TRANSACTION_TYPE' => '002', // todo:which type we have to use?!
            'MONEY_TAKEN' => '0',
//            'MONEY_TAKEN_CURRENCY' => 'TRY', // todo ? I think it is EUR
            'AMOUNT' => $transaction->premium_amount,
            'AMOUNT_CURRENCY' => $transaction->currency, // currency

            /* additional parameters */

//            "CORP_MONEY_ACCOUNTING_TAKEN_OUT"=>$transaction->premium_amount,
//            "CORP_MONEY_ACCOUNTING_TAKEN_EXC_RATE_OUT"=> 1,
//            "CORP_EXPENSE_ACCOUNTING_TAKEN_OUT"=> 0,
//            "CORP_EXPENSE_ACCOUNTING_TAKEN_EXC_RATE_OUT"=>1,
////            "CORP_EXPENSE_AMOUNT_OUT"=> (0.005 * $transaction->premium_amount) + 20,
//            "CORP_EXPENSE_AMOUNT_OUT"=> 0,
//            "CORP_MONEY_TAKEN_OUT"=> 0,
//            "CORP_MONEY_TAKEN_EXC_RATE_OUT"=> 0,
//            "CORP_AMOUNT_OUT"=> $transaction->premium_amount,
//            "CORP_AMOUNT_EXC_RATE_OUT"=> 0,

            /* additional parameters */
        ));


        $return = $client->CorpSendRequest($body_params);
//        $return = $client->__SoapCall('CorpSendRequest', $body_params);

        return $return;
    }

    public function CorpSendRequestConfirm($upt_ref)
    {
        //        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "9590",
            'Password' => "Fanex@123456!"
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
//        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "9590",
            'Password' => "Fanex@123456!"
//            'Username' => "2818",
//            'Password' => "1"
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
//        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?WSDL';
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "9590",
            'Password' => "Fanex@123456!"
//            'Username' => "2818",
//            'Password' => "1"
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
        //        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $url = 'https://upt.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_1, "trace" => 1));

        $user_param = array(
            'Username' => "9590",
            'Password' => "Fanex@123456!"
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