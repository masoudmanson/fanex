<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang(Request $request ,$lang)
    {
        if (array_key_exists($lang, Config::get('app.locales'))) {
            Session::put('applocale', $lang);
        }
        return redirect()->back()->withInput($request->all());
    }
}