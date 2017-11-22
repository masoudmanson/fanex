<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 7/18/17
 * Time: 3:37 PM
 */

namespace App\Traits;

use App\Authorized;
use App\Identifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait IdentifierTrait
{

    public function Identifier_detector(Request $request)
    {
        $id = $request->authorizer;
        $identifier = Identifier::findOrFail($id);
        return call_user_func(array($this, $identifier->name . '_identification'), $request);
    }

    public function fanapium_identification($request)
    {
        $token = $request->cookie('token')['access'];
        $result = $this->getCurrentPlatformUser($token);
        $platform_user = json_decode($result->getBody()->getContents());

        if (!$platform_user->hasError) {
            $platform_user->result->firstName_latin = $request->firstname;
            $platform_user->result->lastName_latin = $request->lastname;
            $platform_user->result->identifier_id  = $request->authorizer;
            $platform_user->result->mobile  = $platform_user->result->cellphoneNumber;
            return json_encode(array('hasError' => $platform_user->hasError, 'result' => $platform_user->result), true);
        }
        return json_encode(array('hasError' => $platform_user->hasError, 'message' => $platform_user->message, 'code' => $platform_user->errorCode), true);
    }

    public function pasargad_identification($request)
    {
        $token = $request->cookie('token')['access'];
        $result = $this->getCurrentPlatformUser($token);
        $platform_user = json_decode($result->getBody()->getContents());

        if (!$platform_user->hasError) {

            $user = Authorized::where('identifier_id', '=', $request->authorizer)
                ->where('identity_number', '=', $request->identity_number)
                ->where('mobile', '=', $request->mobile)
                ->first();
            if($user){
                $platform_user->result->firstName_latin = $request->firstname;
                $platform_user->result->lastName_latin  = $request->lastname;
                $platform_user->result->identifier_id  = $request->authorizer;
                $platform_user->result->mobile  = $request->mobile;
            }
            else
                return json_encode(array('hasError' => true , 'message' =>"you're not authorized" , 'code'=>401),true);
            return json_encode(array('hasError' => $platform_user->hasError, 'result' => $platform_user->result), true);
        }
        return json_encode(array('hasError' => $platform_user->hasError , 'message' =>$platform_user->message , 'code'=>$platform_user->errorCode),true);
    }

    public function other_identification($request)
    {
        $token = $request->cookie('token')['access'];
        $result = $this->getCurrentPlatformUser($token);
        $platform_user = json_decode($result->getBody()->getContents());

        if (!$platform_user->hasError) {
            $data = [
              'firstname' => $request->firstname,
              'lastname' => $request->lastname,
              'mobile' => $request->mobile,
              'identifier_id' => $request->authorizer,
              'identity_number' => $request->identity_number,
            ];

            $user = Authorized::create($data);

            if($user){
                $platform_user->result->firstName_latin = $request->firstname;
                $platform_user->result->lastName_latin  = $request->lastname;
                $platform_user->result->identifier_id  = $request->authorizer;
                $platform_user->result->mobile  = $request->mobile;
                $platform_user->result->identity_number  = $request->identity_number;
            }
            else
                return json_encode(array('hasError' => true , 'message' =>"you're not authorized" , 'code'=>401),true);
            return json_encode(array('hasError' => $platform_user->hasError, 'result' => $platform_user->result), true);
        }
        return json_encode(array('hasError' => $platform_user->hasError , 'message' =>$platform_user->message , 'code'=>$platform_user->errorCode),true);
    }

    public function dotin_identification()
    {

    }
}