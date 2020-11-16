<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class AuthLogin extends Controller
{

    public function index()
    {
        return view('fronted.login.authlogin');
    }


    public function CheckLoginVendor(Request $request)
    {
        $username = $request->username;
        $password = md5($request->password);

        $result = DB::table('tbl_user')
            ->where('username', $username)
            ->where('password', $password)
            ->where('status', 1)
            ->first();
        if (!empty($result)) {
            Session::put('username', $result->username);
            Session::put('name', $result->name);
            Session::put('user_id', $result->user_id);
            Session::put('userid', $result->user_id);
            Session::put('role_id', $result->role_id);
            Session::put('username', $result->username);
            Session::put('company', $result->company);
            Session::put('company_slug', $result->company_slug);
            return redirect('/dashboard');
        } else {
            Session::put('messages', 'Email or Password Invalid..');
            return redirect('/vendor-login-registration');
        }
    }

    public function checkLogin(Request $request)
    {

        $username = $request->username;
        $password = md5($request->password);

        $result = DB::table('tbl_user')
            ->where('username', $username)
            ->where('password', $password)
            ->where('status', 1)
            ->first();
        if (!empty($result)) {
            Session::put('username', $result->username);
            Session::put('name', $result->name);
            Session::put('user_id', $result->user_id);
            Session::put('userid', $result->user_id);
            Session::put('role_id', $result->role_id);
            Session::put('username', $result->username);
            Session::put('company', $result->company);
            Session::put('company_slug', $result->company_slug);
            return redirect('/dashboard');
        } else {
            Session::put('messages', 'Email or Password Invalid..');
            return redirect('/auth');
        }
    }

    public function logoutOut()
    {

        $userid = Session::get('user_id');
        Session::flush();
        unset($userid);
        return redirect('/')->send();
    }

    public function logoutOutCustomer()
    {
        session_unset();
        Session::flush();
        return redirect('/')->send();
    }
}
