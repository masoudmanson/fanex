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
        $this->middleware('checkToken', ['only' => ['index', 'store']]);
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

        return view('statics.additional', compact('identifiers', 'additional_data'));
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

            $user = User::firstOrNew(array('userId' => $identity['userId']));
            $user->userId = $identity['userId'];
//            if(!isset($identity['firstName']) || !isset($identity['lastName']))
//                return abort(401);
            if (isset($identity['firstName']) && isset($identity['lastName'])) {
                $user->firstname = $identity['firstName'];
                $user->lastname = $identity['lastName'];
            }
            $user->firstname_latin = $identity['firstName_latin'];
            $user->lastname_latin = $identity['lastName_latin'];

            //todo ... other data
            if (isset($identity['identifier_id']))
                $user->identifier_id = $identity['identifier_id'];
            if (isset($identity['mobile']))
                $user->mobile = $identity['mobile'];
            if (isset($identity['identity_number']))
                $user->identity_number = $identity['identity_number'];

            if (Identifier::find($user->identifier_id)->name == 'other')
                $user->is_authorized = 0;
            else
                $user->is_authorized = 1;

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
        } else
            return abort(650);

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

}
