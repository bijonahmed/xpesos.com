<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Picqer;
use Session;

class OrderAdmin extends Controller
{

    /*
    bar code video link : https://www.youtube.com/watch?v=ZgwpxgpRjQk
    manual https://github.com/picqer/php-barcode-generator
     */

    public function searchOrderRow($order_id)
    {
        echo $order_id;
        exit;
        $this->AuthCheck();
        $row = DB::table('tbl_order')
            ->select(DB::raw('tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
            ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
            ->where('order_id', $order_id)->first();
        echo json_encode($row);
    }

    public function searchOrder($OrderId)
    {

        $this->AuthCheck();
        $data = array();
        $data['title'] = "Order ID: $OrderId";
        $data['setting'] = DB::table('tbl_setting')->where('status', 1)->first();
        $data['multipleorder'] = DB::table('tbl_order')
			->select(DB::raw('tbl_order.order_id,tbl_order.OrderId,tbl_order.order_date,tbl_order.select_method,tbl_order.billing_details,
			tbl_order.shipping_details,tbl_order.dvcharge,tbl_order.status,tbl_customer.mobile'))
            ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
            ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
            ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
        //->where('tbl_order_details.order_create_sts',1)
            ->where('tbl_order.order_id', $OrderId)->orderBy('tbl_order.OrderId', 'desc')->first();

        $data['order'] = DB::table('tbl_order_details')
            ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
        // ->where('tbl_order_details.order_create_sts',2)
            ->where('tbl_order_details.order_id', $OrderId)->get();
        $oId = $data['multipleorder'];
        $verfiyOrderId = "OrderID: $oId->OrderId";
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $data['barcode_orderId'] = $generator->getBarcode($verfiyOrderId, $generator::TYPE_CODE_128);
		$data['setting'] = $services = DB::table('tbl_setting')->where('status', 1)->first();
        return view('admin.pages.order.multipleorderlist', $data);
    }

    public function UpdateOrderInfo(Request $request)
    {
        $data['order_id'] = $request->order_id;
        $data['status'] = $request->status;
        $data['dvcharge'] = $request->dvcharge;
        $data['select_method'] = $request->select_method;
        $data['billing_details'] = $request->billing_details;
        $data['shipping_details'] = $request->shipping_details;

        if ($request->status == '5' || $request->status == '6' || $request->status == '7') {
            $rdata = array();
            $rdata['order_qnty'] = '0';
            DB::table('tbl_item_stock_out')
                ->where('OrderId', $request->order_id)
                ->update($rdata);
        }

        DB::table('tbl_order')
            ->where('order_id', $request->order_id)
            ->update($data);
        $success = "Successfully Update";
        echo json_encode($success);
    }

    public function AuthCheck()
    {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }

}
