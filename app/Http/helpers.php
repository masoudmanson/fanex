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