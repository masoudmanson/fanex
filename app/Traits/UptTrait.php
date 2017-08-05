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

    public function CorpSendRequest(Transaction $transaction, User $user, Beneficiary $beneficiary, Backlog $backlog)
    {
        $url = 'https://uptuat3.aktifbank.com.tr/ISV/TU/WebServices/V1_2/CorpService.asmx?wsdl';
        $client = new SoapClient($url, array("soap_version" => SOAP_1_2, "trace" => 1));
//        $client = new SoapClient($url);

        $user_param = array(
            'Username' => "2818", //9590
            'Password' => "1" //
        );

        $header = new SoapHeader('http://tempuri.org/', 'WsSystemUserInfo', $user_param);

        $client->__setSoapHeaders($header);

        $body_params = array('obj' => array(
            'SENDER_COUNTRY_CODE' => 'IR', // todo:later it should be detect automatically
            'SENDER_NATIONALITY' => 'IR', // todo: " " " "

            'SENDER_CITIZENSHIP_NO' => '14695448',
            'SENDER_ID_TYPE' => 'pasport',
            'SENDER_ID_NO'=>'3',

            'SENDER_NAME' => 'pooria',
            'SENDER_SURNAME' => 'pahlevani',
            'BENEFICIARY_COUNTRY_CODE' => 'TR',// todo: "to"
            'BENEFICIARY_NAME' => 'Akif', //todo : bnf firstname
            'BENEFICIARY_SURNAME' => 'Selcuk', // todo: bnf lastname
            'BENEFICIARY_GSM_COUNTRY_CODE' => '0090',
            'BENEFICIARY_GSM_NO' => '5057181936',
            'BENEFICIARY_IBAN' => 'TR290006400000164310007808',
            'TRANSACTION_TYPE' => '002', // todo:which type we have to use?!
            'AMOUNT' => '1000', // todo ?
            'AMOUNT_CURRENCY' => 'TRY',
            'MONEY_TAKEN' => '0',

            'CORRESPONDENT_PARITY' => '0',
            'CORRESPONDENT_EXPENSE' => '0',
            'CORRESPONDENT_COMMISSION' => '0',
        ));
        //'CORRESPONDENT_PARITY' => '0',
        //'CORRESPONDENT_EXPENSE' => '0',
        //'CORRESPONDENT_COMMISSION' => '0',

//            'MONEY_TAKEN_CURRENCY' => 'TRY',
//            'CORRESPONDENT_COMMISSION'=>0,
//            'AMOUNT' => $backlog->payment_amount, // todo ?


//        <tem:
//        SENDER_COUNTRY_CODE > IR</tem:SENDER_COUNTRY_CODE >
//            <tem:SENDER_CUSTOMER_ID ></tem:SENDER_CUSTOMER_ID >
//            <tem:SENDER_NATIONALITY > IR</tem:SENDER_NATIONALITY >
//            <tem:SENDER_CITIZENSHIP_NO ></tem:SENDER_CITIZENSHIP_NO >
//            <tem:SENDER_ID_PROVIDER_COUNTRY ></tem:SENDER_ID_PROVIDER_COUNTRY >
//            <tem:SENDER_ID_TYPE ></tem:SENDER_ID_TYPE >
//            <tem:SENDER_ID_NO > 3</tem:SENDER_ID_NO >
//            <tem:SENDER_NAME > Pooria</tem:SENDER_NAME >
//            <tem:SENDER_SURNAME > Pahlevani</tem:SENDER_SURNAME >
//            <tem:SENDER_MOTHER_NAME ></tem:SENDER_MOTHER_NAME >
//            <tem:SENDER_FATHER_NAME ></tem:SENDER_FATHER_NAME >
//            <tem:SENDER_BIRTHDATE ></tem:SENDER_BIRTHDATE >
//            <tem:SENDER_BIRTHPLACE ></tem:SENDER_BIRTHPLACE >
//            <tem:SENDER_GSM_COUNTRY_CODE ></tem:SENDER_GSM_COUNTRY_CODE >
//            <tem:SENDER_GSM_NO ></tem:SENDER_GSM_NO >
//            <tem:SENDER_EMAIL ></tem:SENDER_EMAIL >
//            <tem:SENDER_ADRESS ></tem:SENDER_ADRESS >
//            <tem:SENDER_GENDER ></tem:SENDER_GENDER >
//            <tem:SENDER_ID_PROVIDER_PLACE ></tem:SENDER_ID_PROVIDER_PLACE >
//            <tem:SENDER_ID_GENERATED_DATE ></tem:SENDER_ID_GENERATED_DATE >
//            <tem:SENDER_POSTAL_CODE ></tem:SENDER_POSTAL_CODE >
//            <tem:SENDER_HOME_PHONE_NO ></tem:SENDER_HOME_PHONE_NO >
//            <tem:MONEY_RESOURCE ></tem:MONEY_RESOURCE >
//            <tem:SEND_REASON ></tem:SEND_REASON >
//            <tem:BENEFICIARY_COUNTRY_CODE > TR</tem:BENEFICIARY_COUNTRY_CODE >
//            <tem:BENEFICIARY_NAME > Akif</tem:BENEFICIARY_NAME >
//            <tem:BENEFICIARY_SURNAME > Kenger</tem:BENEFICIARY_SURNAME >
//            <tem:BENEFICIARY_GSM_COUNTRY_CODE > 0090</tem:BENEFICIARY_GSM_COUNTRY_CODE >
//            <tem:BENEFICIARY_GSM_NO > 5057181936</tem:BENEFICIARY_GSM_NO >
//            <tem:BENEFICIARY_EMAIL ></tem:BENEFICIARY_EMAIL >
//            <tem:BENEFICIARY_FATHER_NAME ></tem:BENEFICIARY_FATHER_NAME >
//            <tem:BENEFICIARY_BIRTHDATE ></tem:BENEFICIARY_BIRTHDATE >
//            <tem:NARRATIVE ></tem:NARRATIVE >
//            <tem:BENEFICIARY_BANK_BIC_CODE ></tem:BENEFICIARY_BANK_BIC_CODE >
//            <tem:BENEFICIARY_BANK_CODE ></tem:BENEFICIARY_BANK_CODE >
//            <tem:BENEFICIARY_BRANCH_CODE ></tem:BENEFICIARY_BRANCH_CODE >
//            <tem:BENEFICIARY_ACCOUNT_NO ></tem:BENEFICIARY_ACCOUNT_NO >
//            <tem:BENEFICIARY_IBAN > TR290006400000164310007808</tem:BENEFICIARY_IBAN >
//            <tem:BENEFICIARY_CREDITCARD_NO ></tem:BENEFICIARY_CREDITCARD_NO >
//            <tem:BENEFICIARY_CORPORATION_CODE ></tem:BENEFICIARY_CORPORATION_CODE >
//            <tem:BENEFICIARY_OFFICE_CODE ></tem:BENEFICIARY_OFFICE_CODE >
//            <tem:TRANSACTION_TYPE > 002</tem:TRANSACTION_TYPE >
//            <tem:SECURITY_QUESTION_ID ></tem:SECURITY_QUESTION_ID >
//            <tem:SECURITY_QUESTION_ANSWER ></tem:SECURITY_QUESTION_ANSWER >
//            <tem:MONEY_TAKEN > 0</tem:MONEY_TAKEN >
//            <tem:MONEY_TAKEN_CURRENCY ></tem:MONEY_TAKEN_CURRENCY >
//            <tem:AMOUNT > 100</tem:AMOUNT >
//            <tem:AMOUNT_CURRENCY >TRY</tem:AMOUNT_CURRENCY >
//            <tem:OFFICE_REFERENCE_CODE ></tem:OFFICE_REFERENCE_CODE >
//            <tem:EFT_TYPE ></tem:EFT_TYPE >

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