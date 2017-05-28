<?php

namespace App\Http\Controllers;

use App\Traits\DotinTrait;
use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserInformationController extends Controller
{
    use TokenTrait;
    use DotinTrait;
    use PlatformTrait;

    public function __construct()
    {
        $this->middleware('checkToken', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store user additional info to db, and register user to platform
        //registerwithSSo after authorization in datin

        //check header with middleware

//        $this->validate($request,[            //validate the form inputs if need to
//            '*' => 'required',
//            'email' => 'email',
//            'password' => 'min:3|confirmed',
//        ]);
        $dotin_response = $this->dotinCredential($request->account_number , $request->mobile);
        $dotin_result = json_decode($dotin_response->getBody()->getContents());

        if($dotin_result[0]->auth){
            //requestwithtoken
            $sso_response = $this->registerWithSSO($request);
            $sso_result = json_decode($sso_response->getBody()->getContents());

            if($sso_result->active){

                $follow_res = $this->followBusiness($request->bearerToken());

//                dd($follow_res);
                $user = new User;

                $user->firstname = $dotin_result->firsname;
                $user->lastname = $dotin_result->lastname;
                $user->userId = $sso_result->userId;

                $user->save();http://sandbox.fanapium.com:8080/nzh/follow/?businessId=22&follow=true

                return response()->view('beneficiary', $data, 200)->header('authorization', 'Bearer ' . $request->bearerToken());
            }
        }
        /*
         * 1. datin.
         * 2.register user to platform
         * 3. save user data , given from datin and platform (userId)
         */



//        User::create($request->all());

        return redirect('producer');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
