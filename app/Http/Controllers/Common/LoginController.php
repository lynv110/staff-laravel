<?php

namespace App\Http\Controllers\Common;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function getForm(){
        if (Staff::isLogged()){
            return redirect(route('_dashboard'));
        }
        return view('common.login');
    }

    public function doLogin(){
        $rules = [
            'username' => 'required|between:5,95',
            'password' => 'required'
        ];

        $messages = [
            'username.required'    => trans('login.error_username'),
            'username.between'    => trans('login.error_username'),
            'password.required'    => trans('login.error_password'),
        ];

        $validator = Validator::make(Request::all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('_login'))
                ->withErrors($validator)
                ->withInput();
        }else{
            if (Staff::login(Request::input('username'),Request::input('password'))){
                return redirect(route('_dashboard'));
            }else{
                Session::flash('flash_error', trans('login.error_login'));
                return redirect(route('_login'));
            }
        }
    }

    public function doLogout(){
        Staff::logout();
        return redirect(route('_login'));
    }
}