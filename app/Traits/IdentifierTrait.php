<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 7/18/17
 * Time: 3:37 PM
 */

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

trait IdentifierTrait
{

    public function fanapium_identification($acc, $mobile)
    {
//        $body["Account_number"] = "8615239123"; //$request->acc
//        $body["Mobile_number"] = "09167871238"; //$request->mobile

        $client = new Client();
        $res = $client->get('http://localhost:3000/auth', [ //
        ]);

        return $res;
    }
}