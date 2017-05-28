<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 5/6/17
 * Time: 10:24 AM
 */

function adapterAssignment() {

    return resolve(\App\Essentials\Adapter::class);

}

function is_base64($str){
    if ( base64_encode(base64_decode($str, true)) === $str){
        return true;
    } else {
        return false;
    }
}

function generateUniqueReferenceNumber(){
    //todo: what rules has to be observe??
    // Available alpha caracters
    $CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars = 'abcdefghijklmnopqrstuvwxyz';

    // generate a pin based on 2 * 7 digits + 2 random character
    $pin = mt_rand(1000000, 9999999). $CHARS[rand(0, strlen($CHARS) - 1)]
        . mt_rand(1000000, 9999999)
        . $chars[rand(0, strlen($chars) - 1)];

    // shuffle the result
    $string = str_shuffle($pin);
    return ($string);
}
