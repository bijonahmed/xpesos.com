<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Product;
use App\Models\Orders;

class AdminController extends Controller
{
    public function index()
    {
        $this->AuthCheck();
        $today = date("Y-m-d");
        $role_id = Session::get('role_id');
        $user_id = Session::get('user_id');
        $data = array(
            't_product' => Product::countingProduct(),
            't_order' => Orders::totalOrders($today,$role_id,$user_id),
            'recived' => Orders::recivedOrders($today,$role_id,$user_id),
            'confirm' => Orders::confirmOrders($today,$role_id,$user_id),
            'shipped' => Orders::shippedOrders($today,$role_id,$user_id),
            'complete' => Orders::completeOrders($today,$role_id,$user_id),
            'cancel' => Orders::cancelOrders($today,$role_id,$user_id),
            'hold' => Orders::holdOrders($today,$role_id,$user_id),
            'return' => Orders::returnOrders($today,$role_id,$user_id)
        );
        return view('admin.child', $data);
    }

    public function UpdateProfile()
    {
        $this->AuthCheck();
        $data = DB::table('tbl_setting')->first();
        return view('admin.pages.profile.profile', compact('data'));
    }

    public function contactdetails()
    {
        $this->AuthCheck();
        $data = DB::table('tbl_contact')->orderBy('contact_id', 'asc')->get();
        return view('admin.pages.contact.contactlist', compact('data'));
    }

    public function newsletterDetails()
    {
        $this->AuthCheck();
        $data = DB::table('tbl_newsletters')->orderBy('newsletters_id', 'asc')->get();
        return view('admin.pages.newsletter.newsletterlist', compact('data'));
    }

    public function AuthCheck()
    {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }
}
