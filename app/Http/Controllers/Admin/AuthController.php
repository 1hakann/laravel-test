<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $guard = 'admin';
    protected $redirectTo = '/admin/register';
    protected $loginPath = '/admin/login';

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
            'password' => 'Parola geçerli değil.',
            'remember_token' => 'Kabul Etmelisiniz',
        ];

        $messages = [];

        $rules = [
            'username' => 'required|max:40',
            'email' => 'required|email|unique:admins|max:191',
            'password' => 'required|min:6',
            'remember_token' => 'accepted',
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
            return redirect()->route('admin.auth.login')->with('messages','Üye olduğunuz için teşekkürler '. $request->username );
        } else {
            return redirect()->route('admin.auth.register')->with('messages','Bir hata meydana geldi.');
        }
    }

    public function getLogin() {
        if(Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return redirect($this->loginPath)->with('error', 'Admin can not found!');
        }

        if (Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect('admin/dashboard');
        }

        return redirect($this->loginPath)
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Incorrect email address or password']);
    }
}
