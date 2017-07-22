<?php

namespace App\Http\Controllers;

use App\Identifier;
use App\Traits\DotinTrait;
use App\Traits\PlatformTrait;
use App\Traits\TokenTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserInformationController extends Controller
{
    use TokenTrait;
    use DotinTrait;
    use PlatformTrait;

    public function __construct()
    {
        $this->middleware('checkToken', ['only' => ['store']]);
    }

    public function test()
    {
        $test = new Identifier();
        dd($test);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $identifiers = Identifier::available()->get();

        return view('statics.additional', compact('identifiers'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


//        $this->validate($request,[            //validate the form inputs if need to
//            '*' => 'required',
//            'email' => 'email',
//            'password' => 'min:3|confirmed',
//        ]);
        $request->headers->set('authorization', 'Bearer ' . $request->cookie('token')['access']);

//        $dotin_response = $this->dotinCredential($request->account_number, $request->mobile);
//        $dotin_result = json_decode($dotin_response->getBody()->getContents());

//        if ($dotin_result[0]->auth) {
            $result = $this->followBusiness($request->bearerToken());
            $follow_res = json_decode($result->getBody()->getContents());

            //todo
            $result = $this->getCurrentPlatformUser($request->cookie('token')['access']);
            $platform_user = json_decode($result->getBody()->getContents());
            $user = User::firstOrNew(array('userId' => $platform_user->result->userId));
            $user->userId = $platform_user->result->userId;

            if (isset($platform_user->result->firstName)) // todo : get from user if platform doesn't have first/last name
                $user->firstname = $platform_user->result->firstName;
            else
//                $user->firstname = $dotin_result[0]->message->firstname;
                $user->firstname = 'test';

            if (isset($platform_user->result->lastName)) // todo : get from user if platform doesn't have first/last name
                $user->lastname = $platform_user->result->lastName;
            else
//                $user->lastname = $dotin_result[0]->message->lastname;
                $user->lastname = 'test';

            if (isset($platform_user->result->cellphoneNumber)) // todo : get from user if platform doesn't have first/last name
                $user->mobile = $platform_user->result->cellphoneNumber;
            else
//                $user->lastname = $dotin_result[0]->message->lastname;
                $user->mobile = '0';


            $user->save();

            //todo : save or update

            Auth::login($user);
            //todo : check again if user was in his first time

            return redirect()->route('createOrSelect');
//        }

//        }
        /*
         * 1. datin.
         * 2.register user to platform
         * 3. save user data , given from datin and platform (userId)
         */

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Identifier $identifier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $identifier)
    {
        $identifier = Identifier::findOrFail($identifier);
        $identifier = $identifier->toArray();
        if ($request->ajax())
            return view('partials.identifier-form', compact('identifier'));
        return view('identifier', compact('identifier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
