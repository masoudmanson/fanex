<?php

/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 5/6/17
 * Time: 10:24 AM
 */

use App\Country;

function adapterAssignment()
{
    return resolve(\App\Essentials\Adapter::class);
}

function is_base64($str)
{
    if (base64_encode(base64_decode($str, true)) === $str) {
        return true;
    } else {
        return false;
    }
}

function generateUniqueReferenceNumber()
{
    //todo: what rules has to be observe??
    // Available alpha characters
    $CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars = 'abcdefghijklmnopqrstuvwxyz';

    // generate a pin based on 2 * 7 digits + 2 random character
    $pin = mt_rand(1000000, 9999999) . $CHARS[rand(0, strlen($CHARS) - 1)]
        . mt_rand(1000000, 9999999)
        . $chars[rand(0, strlen($chars) - 1)];

    // shuffle the result
    $string = str_shuffle($pin);
    return ($string);
}

function twoStepExploder($string , $first_delimiter = '&' , $second_delimiter = '=') // for explode query string to add query
{
    $result = array();
    $first_exploded = explode($first_delimiter, $string);

    foreach ($first_exploded as $part) {
        $second_exploded = explode($second_delimiter, $part);
        $result[$second_exploded[0]] = $second_exploded[1];
    }

    return $result;
}

function indexFormCountryList($data) {
    $multiLangCountries = Countries::lookup(session('applocale'))->mapWithKeys(function($country, $key) {
        return $key == 'XK' ? [ 'KV' => $country ] : [ $key => $country ];
    });

    $upt_country_list = $data->CorpGetCountryDataResult->COUNTRYLIST->WSCountry;
    $country_list = array();

    foreach ($upt_country_list as $key => $value) {
        $country = Country::findByCountryCode($value->COUNTRYCODEOUT)->first();
        $result = array();
        if (isset($country->id) && $country->id > 0) {
            $result['enable'] = 1;
            $result['code'] = $value->COUNTRYCODEOUT;
            $result['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
            $result['currency'] = array();
            if (is_array($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit)) {
                foreach ($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit as $curr) {
                    if ($curr->TRANSACTION_TYPE == "008")
                        $result['currency'][$curr->CURRENCY] = __('index.'.$curr->CURRENCY);
                }
            } else {
                if (!empty($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY))
                    $result['currency'][$value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY] = __('index.'.$value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY);
                else
                    continue;
            }
            $country_list[$value->COUNTRYCODEOUT] = $result;
        } else {
            $result['enable'] = 0;
            $result['code'] = $value->COUNTRYCODEOUT;
            $result['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
            $result['currency'] = array();
            $country_list[$value->COUNTRYCODEOUT] = $result;
        }
    }

    arsort($country_list);
    return $country_list;
}
