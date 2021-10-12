<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->except(['getLogout', 'getLogin', 'postLogin']);
    }

    public function index()
    {
        return view('admin.index');
    }

    public function getRegister()
    {
        if(Auth::guard('admin')->check())
        {
            return redirect()->route('admin.auth.index');
        }

        Session::put('signup-active',true);
        return view('admin.auth.register');
    }

    public function postRegister(Request $request)
    {
        if(Auth::guard('admin')->check())
        {
            return redirect()->route('admin.auth.index');
        }

        $inputData = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        Session::put('signupInformations',$inputData);

        $attributes = [
            'username' => 'Bir kullanıcın olmalı.',
            'email'=> 'Geçerli bir email girin',
            'password' => 'Parola geçerli değil.'
        ];

        $messages = [];

        $rules = [
            'username' => 'required|max:40',
            'email' => 'required|email|unique:admins|max:191',
            'password' => 'required|min:6'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if($validator->fails())
        {
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        $formData = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'enabled' => 0,
            'email_token' => Str::random(30) . time(),
        ];

        $newAdmin = Admin::create($formData);

        Session::put('userRegistered',true);
        Session::forget('signupInformations');

        if($newAdmin) {
            return redirect()->route('admin.auth.index');
        } else {
            return redirect()->route('admin.auth.register');
        }
    }

    public function getLogin() {
        if(Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function postLogin(Request $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'enabled' => 1,
        ];
        $attributes = [
            'email' => 'Email alanı zorunludur!',
            'password' => 'Şifrenizi girin',
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        // if(Auth::guard('admin')->attempt($credentials, $request->remember_token)) {
        //     $auth = Auth::guard('admin')->user();
        //     $admin = Admin::find($auth->id);
        //     $admin -> last_login = Carbon::now();
        //     $admin -> save();

        //     return redirect()->route('dashboard');
        // } else {
        //     return redirect()->route('admin.auth.login')->withErrors([__('auth.failed')]);
        // }
    }


}
