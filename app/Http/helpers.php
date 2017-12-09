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

function twoStepExploder($string, $first_delimiter = '&', $second_delimiter = '=') // for explode query string to add query
{
    $result = array();
    $first_exploded = explode($first_delimiter, $string);

    foreach ($first_exploded as $part) {
        $second_exploded = explode($second_delimiter, $part);
        $result[$second_exploded[0]] = $second_exploded[1];
    }

    return $result;
}

function countryListByProduct($products,$country_name)
{
    $response = array();
    $response['TR'] = array();
//        $response['TR']['enable'] = (int)$product->enable;
    $response['TR']['enable'] = 1;
    $response['TR']['code'] = 'TR';
    $response['TR']['name'] = $country_name;

    foreach ($products as $product) {
        $response['TR']['currency'][$product->description] = [
            'type' => $product->description,
            'name' => __('index.' . $product->description),
            'sign' => __('index.sign.' . $product->description),
            'product_id' => $product->entityId
        ];
    }
    return $response;
}

function indexFormCountryList($data, $lang)
{
    $multiLangCountries = Countries::lookup($lang)->mapWithKeys(function ($country, $key) {
        return $key == 'XK' ? ['KV' => $country] : [$key => $country];
    });

//    $upt_country_list = $data->CorpGetCountryDataResult->COUNTRYLIST->WSCountry;
//    $country_list = array();
//
//    foreach ($upt_country_list as $key => $value) {
//        $country = Country::findByCountryCode($value->COUNTRYCODEOUT)->first();
//        $result = array();
//        if (isset($country->id) && $country->id > 0) {
//            $result['enable'] = 1;
//            $result['code'] = $value->COUNTRYCODEOUT;
//            $result['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
//            $result['currency'] = array();
//            if (is_array($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit)) {
//                foreach ($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit as $curr) {
//                    if ($curr->TRANSACTION_TYPE == "008")
//                        $result['currency'][$curr->CURRENCY] = __('index.' . $curr->CURRENCY);
//                }
//            } else {
//                if (!empty($value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY))
//                    $result['currency'][$value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY] = __('index.' . $value->CURRENTPAYMENTLIMITS->WSCountryCurrentLimit->CURRENCY);
//                else
//                    continue;
//            }
//            $country_list[$value->COUNTRYCODEOUT] = $result;
//        } else {
//            $result['enable'] = 0;
//            $result['code'] = $value->COUNTRYCODEOUT;
//            $result['name'] = $multiLangCountries[$value->COUNTRYCODEOUT];
//            $result['currency'] = array();
//            $country_list[$value->COUNTRYCODEOUT] = $result;
//        }
//    }
//
//    arsort($country_list);

    $country_name = Countries::lookup($lang)['TR'];
    $country_list = array(
        "TR" => array(
            "enable" => 1,
            "code" => "TR",
            "name" => $country_name,
            "currency" => array(
                "EUR" => array(
                    'type' => 'EUR',
//                    'name' => 'Euro',
                    'name' => __('index.EUR'),
                    'sign' => '€'
                ),
                "TRY" => array(
                    'type' => 'TRY',
//                    'name' => 'Tukish Lira',
                    'name' => __('index.TRY'),
                    'sign' => '₺'
                )
            )
        )
    );


    return $country_list;
}

function countries($lang)
{
    return $countries = Countries::lookup($lang)->mapWithKeys(function ($country, $key) {
        return $key == 'XK' ? ['KV' => $country] : [$key => $country];
    });
}