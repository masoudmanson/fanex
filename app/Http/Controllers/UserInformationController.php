<?php

namespace App\Http\Controllers;

use App\Identifier;
use App\Traits\DotinTrait;
use App\Traits\IdentifierTrait;
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
    use IdentifierTrait;

    public function __construct()
    {
        $this->middleware('checkToken', ['only' => ['index','store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $additional_data = $request->session()->get('redirect_uri');

        $identifiers = Identifier::available()->get();

        return view('statics.additional', compact('identifiers','additional_data'));
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
        $request->headers->set('authorization', 'Bearer ' . $request->cookie('token')['access']);

        $identifier_json_response = $this->Identifier_detector($request);
        $identifier_response = json_decode($identifier_json_response, true);

        if (!$identifier_response['hasError']) {
            $identity = $identifier_response['result'];

            $result = $this->followBusiness($request->bearerToken());
            $follow_res = json_decode($result->getBody()->getContents());

            //todo : when user must registered in platform?!
//            $result = $this->getCurrentPlatformUser($request->cookie('token')['access']);
//            $platform_user = json_decode($result->getBody()->getContents());
            $user = User::firstOrNew(array('userId' => $identity['userId']));
            $user->userId = $identity['userId'];

            if(!isset($identity['firstName']) || !isset($identity['lastName']))
                return abort(401);
            else {
                $user->firstname = $identity['firstName'];
                $user->lastname = $identity['lastName'];
            }
            //todo ... other data
            $user->save();
            //todo : save or update
            Auth::attempt();
//            Auth::login($user);
            //todo : check again if user was in his first time
            return redirect($request->additional);
            /*
             * 1. datin.
             * 2.register user to platform
             * 3. save user data , given from datin and platform (userId)
             */
        }
        else
           return abort(401);

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Identifier $identifier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $identifier)
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
