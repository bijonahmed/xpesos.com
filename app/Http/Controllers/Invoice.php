<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
//session_start();
class Invoice extends Controller {
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Session::get('user_id');
           // echo "===".$this->userid;
           if($this->userid == null) {
             return redirect('/');
           }
            return $next($request);
        });
    }
    public function index() {
        return view('admin.pages.invoice.invoicelist');
    }
    public function createInvoice(){
        $data['setting'] = DB::table('tbl_setting')->where('status', 1)->first();
        $data['lastOrderRow']= DB::table('tbl_order')->orderBy('tbl_order.OrderId', 'desc')->first();
        $data['item'] = DB::table('tbl_product')
                        ->select(DB::raw('tbl_product.product_id,tbl_product.product_name,tbl_product.product_code'))
                        ->where('status',1)
                        ->orderBy('tbl_product.product_id', 'asc')->get();
        return view('admin.pages.invoice.createinvoice', $data);
    }
   

    public function printInvoice($order_id){
       
       $data=array();
       $data['setting'] =DB::table('tbl_setting')->first();
       $data['lastOrderRow']= DB::table('tbl_order')->orderBy('tbl_order.OrderId', 'desc')->first();
       $data['order_id']= $order_id;
       return view('admin.pages.invoice.print_invoice', $data);
        
    }

    public function editInvoice($order_id){
	
       $data=array();
       $data['title'] = "Edit Invoice [$order_id]";
       $data['setting'] = DB::table('tbl_setting')->where('status', 1)->first();
       $data['lastOrderRow']= DB::table('tbl_order')
                            ->select(DB::raw('tbl_customer.address,tbl_customer.mobile,tbl_customer.customer_name,tbl_order.payment_method,tbl_order.due,
                            tbl_order.advance,tbl_order.total_amt,tbl_order.sub_total,tbl_order.select_method,
                            tbl_order.dvcharge,tbl_order.billing_details,tbl_order.shipping_details,tbl_order.status,
                            tbl_order.order_date,tbl_order.order_id,tbl_order.customer_id,tbl_order.OrderId'))
                            ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                            ->where('tbl_order.order_id', $order_id)->first();
      //echo '<pre>';
      //print_r($data['lastOrderRow']);exit;
       $data['item'] = DB::table('tbl_product')
                        ->select(DB::raw('tbl_product.product_id,tbl_product.product_name,tbl_product.product_code'))
                        ->where('status',1)
                        ->orderBy('tbl_product.product_id', 'asc')->get();
    return view('admin.pages.invoice.edit_invoice', $data);

    }

	

     function checkProductQty(Request $request){

        $product_id= $request->product_id;
        //Get Item Calcuation 
        $stockOut = DB::table('tbl_item_stock_out')
                        ->select(DB::raw('tbl_item_stock_out.order_qnty'))
                        ->where('tbl_item_stock_out.product_id', $product_id)
                        ->orderBy('tbl_item_stock_out.OrderId', 'desc')
                        ->get();
        $sOut = 0;
        foreach ($stockOut as $item) {
            $sOut += $item->order_qnty;
        }
       
        $data['stock_out']= $stockOut;
        $opening_stock = DB::table('tbl_item')->where('tbl_item.product_id', $product_id)->first();
        $purchase_data = DB::table('tbl_supplier_invoice_two')
                                  ->select(DB::raw('tbl_supplier_invoice_two.qnty'))
                                  ->leftJoin('tbl_item', 'tbl_item.item_id', '=', 'tbl_supplier_invoice_two.item_id')
                                  ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                                  ->where('tbl_item.product_id', $product_id)->sum('tbl_supplier_invoice_two.qnty');
 
        // get calculation
        $openingBalance= $opening_stock->qnty;
        $totalSelling= $sOut;
        $totalPurchase= $purchase_data;

        $totalStock = $openingBalance + $totalPurchase - $totalSelling; 
        
        if($request->qty > $totalStock){
            $stockdata=array();
            $stockdata['stockin']= $totalStock;
            $stockdata['msg']= "large";
            echo json_encode($stockdata);
        }


     }
    
    public function searchProductId($product_id) {
      $row = DB::table('tbl_product')
                ->where('product_id', $product_id)
                ->first();
        echo json_encode($row);
    }
    public function removeProductId($product_id) {
        $data = DB::table('tbl_temp')->where('product_id', $product_id)->delete();
        echo json_encode($data);
    }

    public function removeProductIdOrderwise(Request $request) {
        $data = DB::table('tbl_order_details')
                ->where('product_id', $request->product_id)
                ->where('order_id', $request->order_id)
                ->delete();
        echo json_encode($data);
    }
    //update invoice 

    function UpdateInvoice(Request $request){

        $customerdata=array();
        $customerdata['customer_id'] = $request->customer_id;
        $customerdata['customer_name'] = $request->customer_name;
        $customerdata['mobile'] = $request->mobile;
        $customerdata['address'] = $request->address;

        DB::table('tbl_customer')
                ->where('customer_id', $request->customer_id)
                ->update($customerdata);

        $orderdata=array();
        $orderdata['order_id'] = $request->order_id;
        $orderdata['billing_details'] = $request->billing_details;
        $orderdata['shipping_details'] = $request->shipping_details;
        $orderdata['payment_method'] = $request->payment_method;
        $orderdata['status'] = $request->status;
        $orderdata['select_method'] = $request->select_method;
        $orderdata['sub_total'] = $request->sub_total;
        $orderdata['dvcharge'] = $request->dvcharge;
        $orderdata['total_amt'] = $request->total_amt;
        $orderdata['advance'] = $request->advance;
        $orderdata['due'] = $request->due;
        
        DB::table('tbl_order')
        ->where('order_id', $request->order_id)
        ->update($orderdata);

        return redirect('/admin/invoice/edit_invoice/'.$request->order_id);

    }

    //create order invoice 
    public function SaveInvoice(Request $request) {

        if (!empty($request->mobile)) {
            $checkmobile = DB::table('tbl_customer')
                    ->where('mobile', $request->mobile)
                    ->first();
            if (empty($checkmobile->mobile)) {
                $data['customer_name'] = $request->customer_name;
                $data['mobile'] = $request->mobile;
                $data['address'] = $request->address;
                $data['customer_username'] = $request->mobile;
                $data['customer_password'] = md5($request->mobile);
                $data['regis_date'] = date("Y-m-d");
                $data['status'] = 1;
                $customerId = DB::table('tbl_customer')->insertGetId($data);
            }

            $data = array();
            $odata = array();
            $maxId = DB::table('tbl_order')->max('order_id');
            if (!empty($maxId)) {
                $odata['OrderId'] = sprintf('%06d', $maxId + 1);
            } else {
                $odata['OrderId'] = '000001';
            }
            $OrderId= $odata['OrderId'];
            if (!empty($customerId)) {
                $odata['customer_id'] = $customerId;
            } else {
                $odata['customer_id'] = $checkmobile->customer_id;
            }
            $odata['order_date'] = date("Y-m-d");
            $odata['status'] = 1;
            $odata['shipping_details'] = $request->shipping_details;
            $odata['billing_details'] = $request->billing_details;
            $odata['select_method'] = $request->select_method;
            $odata['dvcharge'] = $request->dvcharge;

            $odata['sub_total'] = $request->sub_total;
            $odata['total_amt'] = $request->total_amt;
            $odata['advance'] = $request->advance;
            $odata['due'] = $request->due;
            $odata['payment_method'] = $request->payment_method;    
            $orderId = DB::table('tbl_order')->insertGetId($odata);

            $user_id = Session::get('user_id');  
            $productlist = DB::table('tbl_temp')->where('user_id',$user_id)->get();

           foreach($productlist as $i){

            $data2 = array(
                'product_id' => $i->product_id,
                'quantity' => $i->qnty,
                'order_id' => $orderId,
                'price' => $i->price,
                'order_create_sts' =>1
            );
            DB::table('tbl_order_details')->insert($data2);

            $data3 = array(
                'OrderId' => $orderId,
                'product_id' => $i->product_id,
                'order_qnty' => $i->qnty,
                'status' => "Stock Out",
                'rdate' => date("Y-m-d")
            );
            DB::table('tbl_item_stock_out')->insert($data3);

          }

        DB::table('tbl_temp')->truncate();
        //Session::put('savemessages', 'Successfully Created Invoice');
       //return redirect('/admin/create-a-new-invoice');
       echo json_encode("Successfully Created Invoice");
       
      }
    }
    public function SaveOrderInvoice(Request $request) {
        $check_product_id =  DB::table('tbl_temp')->where('product_id', $request->product_id)->first();
        if(empty($check_product_id)){
            $suppdata = array();
            $suppdata['product_id'] = $request->product_id;
            $suppdata['user_id'] =  Session::get('user_id'); //
            $suppdata['qnty'] = $request->qnty;
            $suppdata['price'] = $request->price;
            $suppdata['description'] = $request->description;
            DB::table('tbl_temp')->insert($suppdata);
             echo json_encode("save");
        }else{
            DB::table('tbl_temp')->where('product_id', $request->product_id)->delete();
            $suppdata = array();
            $suppdata['product_id'] = $request->product_id;
            $suppdata['qnty'] = $request->qnty;
            $suppdata['user_id'] =  Session::get('user_id'); //
            $suppdata['price'] = $request->price;
            $suppdata['description'] = $request->description;
            DB::table('tbl_temp')->insert($suppdata);
               echo json_encode("exits");
            exit;
        }
    }
    //edot invoice list

    public function UpdateOrderInvoice(Request $request) {

        $odata = array();
        $odata['order_id'] = $request->order_id;
        $odata['product_id'] = $request->product_id;
        $odata['quantity'] = $request->qnty;
        $odata['price'] = $request->price;
        $odata['description'] = $request->description;
        $odata['order_create_sts']= 1;
        DB::table('tbl_order_details')->insert($odata);
        echo json_encode("save");

    }

    public function editInvoiceProductList(Request $request){
       // echo $request->orderId;
       if ($request->ajax()) {
        $output = '';
        $orderid = $request->orderId;//$request->get('query');
        $data = DB::table('tbl_order_details')
                            ->select(DB::raw('tbl_order_details.order_id,tbl_product.product_name,tbl_order_details.description,tbl_order_details.price,tbl_order_details.quantity,tbl_product.product_id,tbl_order_details.product_id,tbl_order_details.quantity'))
                            ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                            ->where('tbl_order_details.order_id',$orderid)
                            ->get();
      //echo '<pre>';
      //print_r($data);exit;
        $total_row = $data->count();
        $sl = 1;
        $sum = 0;
        if ($total_row > 0) {
            foreach ($data as $row) {
                $sum += $row->quantity * $row->price;
                $link = '<a onclick="removeProduct(' . $row->product_id . ',' . $row->order_id.')" href="#">Remove Item</a>';
                $itemId = $row->product_id;
                $t_result = $row->price * $row->quantity;
                $output .= "
        <tr>
        <td>" . $sl . "</td>
        <td><input type='hidden' name='product_id[]' value='$row->product_id'/>" . $row->product_name .'(' .$row->description.')' ."</td>
        <td><input type='hidden' name='quantity[]' value='$row->quantity'/>" . $row->quantity . "</td>
        <td><input type='hidden' name='price[]' value='$row->price'/>" . $row->price . "</td>
        <td> $t_result </td>
        <td>" . $link . "</td>
        </tr>
        ";
                $sl++;
            }
        } else {
            $output = "
       <tr>
        <td align='center' colspan='6'>No Data Found</td>
       </tr>
       ";
        }
        $data = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_sum' => $sum,
        );
        echo json_encode($data);
    }



    }
    public function IteminfobyInvoice(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query == '') {
                $data = DB::table('tbl_temp')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_temp.product_id')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            $sum = 0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $sum += $row->qnty * $row->price;
                    $rowcheck = DB::table('tbl_temp')
                                    ->where('product_id', $row->product_id)->first();
                    $link = '<a onclick="getbyId(' . $row->product_id . ')" href="#">Remove Item</a>';
                    if (!empty($rowcheck->item_id)) {
                        DB::table('tbl_temp')->where('product_id', $row->product_id)->delete();
                        $ordata = array();
                        $ordata['OrderId'] = $rowcheck->OrderId;
                        $ordata['product_id'] = $rowcheck->product_id;
                        $ordata['qnty'] = $rowcheck->qnty;
                        $ordata['price'] = $rowcheck->price;
                        $ordata['description'] = $rowcheck->description;
                        DB::table('tbl_temp')->insert($ordata);
                    }
                    $itemId = $row->product_id;
                    $t_result = $row->price * $row->qnty;
                  
                    $output .= "
            <tr>
            <td>" . $sl . "</td>
            <td><input type='hidden' name='product_id[]' value='$row->product_id'/>" . $row->product_name .'(' .$row->description.')' ."</td>
            <td><input type='hidden' name='qnty[]' value='$row->qnty'/>" . $row->qnty . "</td>
            <td><input type='hidden' name='price[]' value='$row->price'/>" . $row->price . "</td>
            <td> $t_result </td>
            <td>" . $link . "</td>
            </tr>
            ";
                    $sl++;
                }
            } else {
                $output = "
           <tr>
            <td align='center' colspan='6'>No Data Found</td>
           </tr>
           ";
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'total_sum' => $sum,
            );
            echo json_encode($data);
        }
    }
    // end order invoice 
    public function searchbyInvoice(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_order')
                        ->select(DB::raw('tbl_order.total_amt,tbl_order.advance,tbl_order.due,tbl_order_details.order_create_sts,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
                        ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                        ->where('tbl_order.OrderId', 'like', '%' . $query . '%')
                        ->where('tbl_order_details.order_create_sts',1)
                        ->orderBy('tbl_order.OrderId', 'desc')
                        ->groupBy('tbl_order.order_id')
                        ->get();
            } else {
                $data = DB::table('tbl_order')
                        ->select(DB::raw('tbl_order.total_amt,tbl_order.advance,tbl_order.due,tbl_order_details.order_create_sts,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
                        ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                        ->where('tbl_order_details.order_create_sts',1)
                        ->where('tbl_order_details.order_create_sts',1)
                        ->orderBy('tbl_order.OrderId', 'desc')
                        ->groupBy('tbl_order.order_id')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $status = $row->status;
                    if ($status == 1) {
                        $status = 'Recived Order';
                    } elseif ($status == 2) {
                        $status = 'Confirm Order';
                    } elseif ($status == 3) {
                        $status = 'Shipped Order';
                    } elseif ($status == 4) {
                        $status = 'Complete Order';
                    } elseif ($status == 5) {
                        $status = 'Cancel Order';
                    } elseif ($status == 6) {
                        $status = 'Hold Order';
                    }
                    $editpage = "invoice/edit_invoice/" . $row->order_id;
                    $edit = '<a href="' . $editpage . '">Edit Invoice</a>';
                    $printurl = "invoice/print_invoice/" . $row->order_id;
                    $Print = '<a href="' . $printurl . '">Print Preview</a>';



                    $output .= '
            <tr>
             <td>' . $sl . '</td>
             <td>' . $row->OrderId . '</td>
             <td>' . '৳'. $row->total_amt . '</td>
             <td>' . '৳'. $row->advance . '</td>
             <td>' . '৳'. $row->due . '</td>

             <td>' . date("d-M-Y",strtotime($row->order_date)) . '</td>
             <td style="background-color:green; color: white;text-align: center;">' . $status . '</td>
             <td>' . $edit . ' || ' . $Print . '</td>
            </tr>';
                    $sl++;
                }
            } else {
                $output = '
           <tr>
            <td align="center" colspan="6">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        }
    }
 


    public function saveSubCategory(Request $request) {
        if (!empty($request->sub_cat_id)) {
            $data['category_id'] = $request->category_id;
            $data['sub_cat_name'] = $request->sub_cat_name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_subcategory')
                    ->where('sub_cat_id', $request->sub_cat_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['category_id'] = $request->category_id;
            $data['slug'] = $request->slug;
            $data['sub_cat_name'] = $request->sub_cat_name;
            $data['status'] = $request->status;
            DB::table('tbl_subcategory')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }
    public function searchCategoryRow($categoryId) {
        $row = DB::table('tbl_category')
                ->where('category_id', $categoryId)
                ->first();
        echo json_encode($row);
    }
}