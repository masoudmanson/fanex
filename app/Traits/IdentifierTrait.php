<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 7/18/17
 * Time: 3:37 PM
 */

namespace App\Traits;

use App\Identifier;
use Illuminate\Http\Request;

trait IdentifierTrait
{

    public function Identifier_detector(Request $request)
    {
        $id = $request->authorizer;
        $identifier = Identifier::findOrFail($id);
        return call_user_func(array($this, $identifier->name . '_identification'), $request->cookie('token')['access']);
    }

    public function fanapium_identification($token)
    {
        $result = $this->getCurrentPlatformUser($token);
        $platform_user = json_decode($result->getBody()->getContents());

        if (!$platform_user->hasError) {
            return json_encode(array('hasError' => $platform_user->hasError , 'result' =>$platform_user->result),true);
        }
        return json_encode(array('hasError' => $platform_user->hasError , 'message' =>$platform_user->message , 'code'=>$platform_user->errorCode),true);
    }

    public function dotin_identification()
    {

    }
}