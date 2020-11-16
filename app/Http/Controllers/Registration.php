<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Category;
use App\Models\Setting;


class Registration extends Controller
{

    public function index()
    {
        $data = array();
        $data['title'] = "Login / User Registration";
        $data['setting'] = Setting::first();
        $data['category'] = Category::where('status', 1)->get();
        return view('fronted.pages.customer_registration', $data);
    }

    public function sellerRegistration()
    {
        $data = array();
        $data['title'] = "Seller Registration";
        $data['setting'] = Setting::first();
        $data['category'] = Category::where('status', 1)->get();
        return view('vendor.seller_registration', $data);
    }

    public function custoerLogin()
    {
        $data = array();
        $data['title'] = "Customer Login";
        $data['setting'] = Setting::first();
        $data['category'] = Category::where('status', 1)->get();
        return view('fronted.pages.customer_login', $data);
    }

    public function Logincustoer()
    {
        $data = array();
        $data['title'] = "Customer Login";
        $data['setting'] = Setting::first();
        $data['category'] = Category::where('status', 1)->get();
        return view('fronted.pages.cus_login_by_mobile', $data);
    }

    public function saveSellerRegistration(Request $request)
    {
        $data = array(
            'name' => $request->f_name.' '.$request->l_name,
            'company' => $request->company,
            'company_slug'=> $request->company_slug,
            'email' => $request->email,
            'storePhone' => $request->storePhone,
            'address' => $request->address,
            'username' => $request->username,
            'password' => md5($request->password),
            'date' => date("Y-m-d"),
            'status' => 0,
            'role_id' => 2,
            'verificationCode' => $request->verificationCode,
            'country' => $request->country,
            'city_town' => $request->city_town,
            'state_country' => $request->state_country,
            'postCodeZip' => $request->postCodeZip,
            'storePhone' => $request->storePhone,
         );

        DB::table('tbl_user')->insert($data);
        Session::put('registration_message', 'Successfully Complete Registration');
        return redirect('/seller-registration');
        //echo json_encode($success);

    }

    public function saveCustomerRegistration(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;
        $data['address'] = $request->address;

        $data['customer_username'] = $request->customer_username;
        $data['customer_password'] = md5($request->customer_password);
        $data['regis_date'] = date("Y-m-d");
        $data['status'] = 1;

        DB::table('tbl_customer')->insert($data);
        $success = "Successfully Save";
        Session::put('registration_message', 'Successfully Complete Registration . Please Login.');
        return redirect('/customer-login-registration');
        //echo json_encode($success);

    }


    public function checkCustomerCredential(Request $request)
    {

        $username = $request->customer_username;
        $password = md5($request->customer_password);
        $result = DB::table('tbl_customer')
            ->where('customer_username', $username)
            ->where('customer_password', $password)
            ->where('status', 1)
            ->first();

        if (!empty($result)) {
            Session::put('customer_name', $result->customer_name);
            Session::put('customer_username', $result->customer_username);
            Session::put('customer_id', $result->customer_id);
            $data = "yes";
        } else {
            Session::put('messages', 'Username or Password Invalid..');
            $data = "no";
        }
        echo json_encode($data);
    }
    public function CheckLoginCustomer(Request $request)
    {
        $username = $request->customer_username;
        $password = md5($request->customer_password);
        $result = DB::table('tbl_customer')
            ->where('customer_username', $username)
            ->where('customer_password', $password)
            ->where('status', 1)
            ->first();

        if (!empty($result)) {
            Session::put('customer_name', $result->customer_name);
            Session::put('customer_username', $result->customer_username);
            Session::put('customer_id', $result->customer_id);
            return redirect('/customer-panel');
        } else {
            Session::put('messages', 'Username or Password Invalid..');
            return redirect('/customer-login-registration');
        }
    }

    public function CheckLoginCustomerByMobile(Request $request)
    {

        $mobile = $request->mobile;
        $password = md5($request->customer_password);
        $result = DB::table('tbl_customer')
            ->where('mobile', $mobile)
            ->where('customer_password', $password)
            ->where('status', 1)
            ->first();

        if (!empty($result)) {
            Session::put('customer_name', $result->customer_name);
            Session::put('mobile', $result->mobile);
            Session::put('customer_id', $result->customer_id);
            return redirect('/customer-panel');
        } else {
            Session::put('messages', 'Username or Password Invalid..');
            return redirect('/login-customer');
        }
    }

    public function checSellerkuserName($username)
    {
        $response = DB::table('tbl_user')->where('username', $username)->first();
        if ($response) {
            $data = "yes";
        } else {
            $data = "no";
        }
        echo json_encode($data);
    }


    public function checkuserName($username)
    {
        $response = DB::table('tbl_customer')->where('customer_username', $username)->first();
        if ($response) {
            $data = "yes";
        } else {
            $data = "no";
        }
        echo json_encode($data);
    }

    public function checkEmail($username)
    {
        $response = DB::table('tbl_customer')->where('email', $username)->first();
        if ($response) {
            $data = "yes";
        } else {
            $data = "no";
        }
        echo json_encode($data);
    }


    public function checkSellerEmail($username)
    {
        $response = DB::table('tbl_user')->where('email', $username)->first();
        if ($response) {
            $data = "yes";
        } else {
            $data = "no";
        }
        echo json_encode($data);
    }



    public function checkSellerMobile($mobile)
    {
        $response = DB::table('tbl_user')->where('mobile', $mobile)->first();
        if ($response) {
            $data = "yes";
        } else {
            $data = "no";
        }
        echo json_encode($data);
    }


    public function checkMobile($mobile)
    {
        $response = DB::table('tbl_customer')->where('mobile', $mobile)->first();
        if ($response) {
            $data = "yes";
        } else {
            $data = "no";
        }
        echo json_encode($data);
    }
}
