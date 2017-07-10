<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 5/21/17
 * Time: 11:48 AM
 */

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

trait DotinTrait
{

    public function dotinCredential($acc, $mobile)
    {
        $body["Account_number"] = "8615239123"; //$request->acc
        $body["Mobile_number"] = "09167871238"; //$request->mobile

        $token = "ABCASDNKCDEF";

        $client = new Client();
        $res = $client->get('http://localhost:3000/auth', [ //er:euro to rial
        ]);

        return $res;
    }
}