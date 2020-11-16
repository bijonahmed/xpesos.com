<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use Response;
use App\Models\Category;
use App\Models\Setting;

class CustomerPanel extends Controller
{
    public function index()
    {
        $customer_id = Session::get('customer_id');
        //echo $customer_id;exit;
        if (!empty($customer_id)) {
            $this->AuthCheck();
            $data = array();
            $data['title'] = "Customer Dashboard";
            $data['singleorder'] = DB::table('tbl_order')->where('customer_id', $customer_id)->orderBy('tbl_order.order_id', 'desc')->get();
            $data['multipleorder'] = DB::table('tbl_order')
                ->where('customer_id', $customer_id)->orderBy('tbl_order.order_id', 'desc')->get();
            $data['data'] = $services = DB::table('tbl_customer')->where('customer_id', $customer_id)->where('status', 1)->first();
            $data['category'] = DB::table('tbl_category')->where('status', 1)->orderBy('tbl_category.sort', 'asc')->get();
            $data['slider'] = DB::table('tbl_slider')->where('status', 1)->orderBy('slider_id', 'asc')->get();
            return view('fronted.cus_dashboard.customerpanels', $data);
        } else {
            return redirect('/customer-login')->send();
        }
    }

    public function getCustomerList()
    {
        $this->AuthCheck();
        $customer_id = Session::get('customer_id');
        $data = array();
        $data['title'] = "Order List";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['order'] = DB::table('tbl_order')->where('customer_id', $customer_id)->orderBy('tbl_order.order_id', 'desc')->get();
        return view('fronted.cus_dashboard.orderlist', $data);
    }

    public function UpdateCustomerRegistration(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_id'] = $request->customer_id;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;
        $data['address'] = $request->address;
        $data['customer_username'] = $request->customer_username;
        DB::table('tbl_customer')
            ->where('customer_id', $request->customer_id)
            ->update($data);
        return redirect('/edit-customer-account');
    }
    public function getSingleOrder($orderId)
    {
        $customer_id = Session::get('customer_id');
        if (!empty($customer_id)) {
            $this->AuthCheck();
            $data = array();
            $data['title'] = "Signle Order-$orderId ";
            $data['singleorder'] = DB::table('tbl_order')
                ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order.product_id')
                ->where('OrderId', $orderId)->first();
            $data['data'] = $services = DB::table('tbl_customer')->where('customer_id', $customer_id)->where('status', 1)->first();
            return view('fronted.cus_dashboard.singleorder', $data);
        } else {
            return redirect('/customer-login')->send();
        }
    }

    public function editCustomerAccount()
    {
        $customer_id = Session::get('customer_id');
        $this->AuthCheck();
        $data = array();
        $data['title'] = "Edit Customer Account [$customer_id]";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['row'] = DB::table('tbl_customer')->where('customer_id', $customer_id)->first();
        return view('fronted.cus_dashboard.editCustomer', $data);
    }

    public function getCustomerOrder($orderId)
    {
        $customer_id = Session::get('customer_id');
        if (!empty($customer_id)) {
            $this->AuthCheck();
            $data = array();
            $data['title'] = "Order-$orderId ";
            $data['mulripleorder'] = DB::table('tbl_order')
                ->select(DB::raw('tbl_customer.mobile,tbl_order.shipping_details,tbl_order.order_date,tbl_order.OrderId'))
                ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                ->where('OrderId', $orderId)->first();
            $data['category'] = Category::all();
            $data['setting'] =  Setting::first();
            $data['productsInfo'] = DB::table('tbl_order')
                ->select(DB::raw('tbl_customer.mobile,tbl_order.shipping_details,tbl_product.product_name,tbl_product.product_code,tbl_order_details.quantity,tbl_order_details.price'))
                ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                ->where('OrderId', $orderId)->get();
            $data['data'] = $services = DB::table('tbl_customer')->where('customer_id', $customer_id)->where('status', 1)->first();
            return view('fronted.cus_dashboard.multipleorder', $data);
        } else {
            return redirect('/customer-login')->send();
        }
    }
    public function Updatepass(Request $request)
    {
        $data = array();
        $customer_password = $request->customer_password;
        $confirm_password = $request->confirm_password;

        if ($customer_password == $confirm_password) {
            $data['customer_id'] = $request->customer_id;
            $data['customer_password'] = md5($request->customer_password);
            DB::table('tbl_customer')
                ->where('customer_id', $request->customer_id)
                ->update($data);
            Session::put('msg', 'Successfully updated');
        } else {
            Session::put('msg', 'Password not mateching');
            return redirect('/edit-customer-account')->send();
        }
        return redirect('/edit-customer-account');
    }
    public function AuthCheck()
    {
        $customer_id = Session::get('customer_id');
        session_unset();
        if (empty($customer_id)) {
            session_unset($customer_id);
            return redirect('/customer-login')->send();
        }
    }
}
