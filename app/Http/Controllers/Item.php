<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Item extends Controller {

    public function itemlist() {
        $this->AuthCheck();
        $data['category'] = DB::table('tbl_category') ->where('status', 1)->orderBy('category_id', 'asc')->get();
        $data['sub_cat'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc')->get();
        $data['insub_cat'] = DB::table('tbl_sub_in_sub_cat_name')->orderBy('sub_in_sub_id', 'asc')->get();
        $data['product'] = DB::table('tbl_product')
                        ->select(DB::raw('tbl_product.product_id,tbl_product.product_name,tbl_product.product_code'))
                        ->where('status', 1)->get();
        return view('admin.pages.item.itemlist', $data);
    }
    
       public function itemreport() {
        $this->AuthCheck();
        $data['category'] = DB::table('tbl_category') ->where('status', 1)->orderBy('category_id', 'asc')->get();
        $data['sub_cat'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc')->get();
        $data['insub_cat'] = DB::table('tbl_sub_in_sub_cat_name')->orderBy('sub_in_sub_id', 'asc')->get();
        $data['product'] = DB::table('tbl_product')
                        ->select(DB::raw('tbl_product.product_id,tbl_product.product_name,tbl_product.product_code'))
                        ->where('status', 1)->get();
        return view('admin.pages.item.itemrpt', $data);
    }
    
    public function InSubCatWiseItem(Request $request){
        
        $category_id= $_GET["category_id"];
        $sub_cat_id= $_GET["sub_cat_id"];
        $sub_in_sub_id= $_GET["sub_in_sub_id"];
        
        $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_user.company,tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                        ->where('tbl_product.category_id',$category_id)
                        ->where('tbl_product.sub_cat_id',$sub_cat_id)
                        ->where('tbl_product.sub_in_sub_id',$sub_in_sub_id)
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
 
      $output = '';
      $qty=0;
      $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {

                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->get();
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                 ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $pur=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }

                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_result = $openingBalance + $totalPurchase -  $totalSelling ;
                     $qty += $qty_result;
                  
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $url = "item/item-report/" . $row->product_id;
                    $report = '<a target="_blank" href="' . $url . '">RPT ||</a>';
                    $link = '<a onclick="getbyId(' . $row->item_id . ')" href="#">Edit</a>';
                    $output .= '
                <tr>
                    <td style="text-align: center;">' . $sl . '</td>
                    <td style="text-align: left; color:green; font-weight: bold;">' . $row->company . '</td>
                    <td style="text-align: left;">' . $row->product_code . '</td>
                    <td style="text-align: left;">' . $row->product_name . '</td>
                    <td style="text-align: center;">' . $row->category_name . '</td>
                    <td style="text-align: center;">' . $row->sub_cat_name . '</td>
                    <td style="text-align: center;">' . $row->sub_in_sub_cat_name .'</td>
                    <td style="text-align: center;">' . $qty_result . '</td>
                    <td style="text-align: center;">' . $report . '</td>
                <td>' . $link . '</td>
                </tr>';
                    $sl++;
                }
                $output .= '
                <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; color: green; font-weight: bold;">Total</td>
            <td style="text-align: center; color: green; font-weight: bold;">'.$qty.'</td>
            <td style="text-align: center;"></td>
            <td></td>
            </tr>';  
            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        
    }
    
    public function SubCatWiseItem(Request $request){
        
        $category_id= $_GET["category_id"];
        $sub_cat_id= $_GET["sub_cat_id"];
        
        $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_user.company,tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                        ->where('tbl_product.sub_cat_id',$sub_cat_id)
                        ->where('tbl_product.category_id',$category_id)
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
 
      $output = '';
      $qty=0;
      $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {

                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->get();
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                 ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $pur=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }

                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_result = $openingBalance + $totalPurchase -  $totalSelling ;
                     $qty += $qty_result;
                  
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $url = "item/item-report/" . $row->product_id;
                    $report = '<a target="_blank" href="' . $url . '">RPT ||</a>';
                    $link = '<a onclick="getbyId(' . $row->item_id . ')" href="#">Edit</a>';
                    $output .= '
                <tr>
                <td style="text-align: center;">' . $sl . '</td>
                <td style="text-align: left; color:green; font-weight: bold;">' . $row->company . '</td>
                <td style="text-align: left;">' . $row->product_code . '</td>
                <td style="text-align: left;">' . $row->product_name . '</td>
                <td style="text-align: center;">' . $row->category_name . '</td>
                <td style="text-align: center;">' . $row->sub_cat_name . '</td>
                <td style="text-align: center;">' . $row->sub_in_sub_cat_name .'</td>
                <td style="text-align: center;">' . $qty_result . '</td>
                <td style="text-align: center;">' . $report . '</td>
                <td>' . $link . '</td>
                </tr>
                ';
                    $sl++;
                }

                $output .= '
                <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; color: green; font-weight: bold;">Total</td>
            <td style="text-align: center; color: green; font-weight: bold;">'.$qty.'</td>
            <td style="text-align: center;"></td>
            <td></td>
            </tr>';  

            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        
    }
    public function CatWiseItem(Request $request){
   
      $category_id= $_GET["category_id"];
      
      $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_user.company,tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                        ->where('tbl_product.category_id',$category_id)
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
 
      $output = '';
      $total_row = $data->count();
            $sl = 1;
            $qty=0;
            if ($total_row > 0) {
                foreach ($data as $row) {

                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->get();
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                 ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $pur=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }

                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_result = $openingBalance + $totalPurchase -  $totalSelling ;
                     $qty += $qty_result;

                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $url = "item/item-report/" . $row->product_id;
                    $report = '<a target="_blank" href="' . $url . '">RPT ||</a>';
                    $link = '<a onclick="getbyId(' . $row->item_id . ')" href="#">Edit</a>';
                    $output .= '
              <tr>
                <td style="text-align: center;">' . $sl . '</td>
                <td style="text-align: left; color:green; font-weight: bold;">' . $row->company . '</td>
                <td style="text-align: left;">' . $row->product_code . '</td>
                <td style="text-align: left;">' . $row->product_name . '</td>
                <td style="text-align: center;">' . $row->category_name . '</td>
                <td style="text-align: center;">' . $row->sub_cat_name . '</td>
                <td style="text-align: center;">' . $row->sub_in_sub_cat_name .'</td>
                <td style="text-align: center;">' . $qty_result . '</td>
                <td style="text-align: center;">' . $report . '</td>
                <td>' . $link . '</td>
                </tr>
             </tr>
            ';
                    $sl++;
                }

                $output .= '
                <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: left;"></td>
                <td style="text-align: left;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center; color: green; font-weight: bold;">Total</td>
                <td style="text-align: center; color: green; font-weight: bold;">'.$qty.'</td>
                <td style="text-align: center;"></td>
                <td></td>
                </tr>';  

            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
     
    }
    
//default loading 
    public function SearchbyIteminfo(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_user.company,tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_name,tbl_product.product_id,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->where('tbl_product.product_name', 'like', '%' . $query . '%')
                        ->orwhere('tbl_product.product_code', 'like', '%' . $query . '%')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
            } else {
                $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_user.company,tbl_subcategory.sub_cat_name,tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->where('tbl_item.status', 1)
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            $qty=0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                           // ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->whereIn('tbl_order.status', [2, 3, 4])
                            ->get();
                            
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                 ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $pur=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }

                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                   
                    $qty_result = $openingBalance + $totalPurchase -  $totalSelling ;
                    $qty += $qty_result;

                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $url = "item/item-report/" . $row->product_id;
                    $report = '<a target="_blank" href="' . $url . '">RPT ||</a>';
                    $link = '<a onclick="getbyId(' . $row->item_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td style="text-align: center;">' . $sl . '</td>
            <td style="text-align: left; color:green; font-weight: bold;">' . $row->company . '</td>
            <td style="text-align: left;">' . $row->product_code . '</td>
            <td style="text-align: left;">' . $row->product_name . '</td>
            <td style="text-align: center;">' . $row->category_name . '</td>
            <td style="text-align: center;">' . $row->sub_cat_name . '</td>
            <td style="text-align: center;">' . $row->sub_in_sub_cat_name .'</td>
            <td style="text-align: center;">' . $qty_result . '</td>
            <td style="text-align: center;">' . $report . '</td>
            <td>' . $link . '</td>
            </tr>
            ';
                    $sl++;
                }

                $output .= '
            <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center; color: green; font-weight: bold;">Total</td>
            <td style="text-align: center; color: green; font-weight: bold;">'.$qty.'</td>
            <td style="text-align: center;"></td>
            <td></td>
            </tr>';    

            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
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

    public function reportbyItem($product_id) {
        $this->AuthCheck();
        $data = array();
        
        $stockOut = DB::table('tbl_item_stock_out')
                      ->select(DB::raw('tbl_item_stock_out.OrderId,tbl_item_stock_out.OrderId,tbl_item_stock_out.rdate,tbl_item_stock_out.order_qnty,tbl_item_stock_out.product_id'))
                      ->where('tbl_item_stock_out.product_id', $product_id)
                      ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                      ->whereIn('tbl_order.status', [2, 3, 4])
                      ->get();
       
        $sOut = 0;
        foreach ($stockOut as $item) {
            $sOut += $item->order_qnty;
        }
        $data['sout']= $sOut;
        $data['stock_out']= $stockOut;
        $data['row'] = DB::table('tbl_product')
                        ->select(DB::raw('tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code'))
                        ->leftJoin('tbl_item', 'tbl_item.product_id', '=', 'tbl_product.product_id')
                        ->where('tbl_product.product_id', $product_id)->first();

        //$data['quantity'] = ($data['row']->qnty - $sOut);
        $data['opening_stock'] = DB::table('tbl_item')->where('tbl_item.product_id', $product_id)->first();

        $data['order_data'] = DB::table('tbl_order_details')
                        ->select(DB::raw('tbl_order.order_id,tbl_order.OrderId,tbl_order.order_date,tbl_order.status'))
                        ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
                        ->where('tbl_order_details.product_id', $product_id)
                        ->orderBy('tbl_order.order_id', 'desc')->get();
        
         $data['purchase_data'] = DB::table('tbl_supplier_invoice_two')
                                  ->select(DB::raw('tbl_supplier_invoice_two.qnty,tbl_supplier_invoice_one.invoice_date,tbl_supplier_invoice_one.supp_Invoice_id,tbl_supplier_invoice_one.supplier_invoice_id'))
                                  ->leftJoin('tbl_supplier_invoice_one', 'tbl_supplier_invoice_one.supplier_invoice_id', '=', 'tbl_supplier_invoice_two.supplier_invoice_id')
                                  ->leftJoin('tbl_item', 'tbl_item.item_id', '=', 'tbl_supplier_invoice_two.item_id')
                                  ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                                  ->where('tbl_item.product_id', $product_id)->sum('tbl_supplier_invoice_two.qnty');

        $data['purchase'] = DB::table('tbl_supplier_invoice_two')
                                  ->select(DB::raw('tbl_supplier_invoice_two.qnty,tbl_supplier_invoice_one.invoice_date,tbl_supplier_invoice_one.supp_Invoice_id,tbl_supplier_invoice_one.supplier_invoice_id'))
                                  ->leftJoin('tbl_supplier_invoice_one', 'tbl_supplier_invoice_one.supplier_invoice_id', '=', 'tbl_supplier_invoice_two.supplier_invoice_id')
                                  ->leftJoin('tbl_item', 'tbl_item.item_id', '=', 'tbl_supplier_invoice_two.item_id')
                                  ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                                  ->where('tbl_item.product_id', $product_id)->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();

        return view('admin.pages.item.itemreport', $data);
        //echo $product_id;
    }

    public function SaveItemProcessing(Request $request){
      $productlist= DB::table('tbl_product')
                    ->select(DB::raw('tbl_product.product_id,tbl_product.qty,tbl_product.orginal_price'))
                    ->where('tbl_product.status', 1)->get();
               foreach($productlist as $item){

                $checkitem= DB::table('tbl_item')
                            ->where('tbl_item.product_id', $item->product_id) //check product id
                            ->first();
                   if(empty($checkitem->product_id)){
                    $itemdata = array();
                    $itemdata['product_id'] = $item->product_id;
                    $itemdata['qnty'] = $item->qty;
                    $itemdata['rate'] = $item->orginal_price;
                    $itemdata['rate_total'] = $item->qty * $item->orginal_price;
                    $itemdata['status'] = 1;
                    DB::table('tbl_item')->insert($itemdata); 
                   }
               }     
        $success = "Item Processing Complete Successfully";
        echo json_encode($success);

    }

    public function SaveItem(Request $request) {
        $this->AuthCheck();
        $data = array();
        if (!empty($request->item_id)) {
            $data['item_id'] = $request->item_id;
            $data['product_id'] = $request->product_id;
            $data['rate_total'] = $request->rate_total;
            $data['rate'] = $request->rate;
            $data['qnty'] = $request->qnty;
            $data['status'] = $request->status;

            DB::table('tbl_item')
                    ->where('item_id', $request->item_id)
                    ->update($data);

            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['product_id'] = $request->product_id;
            $data['status'] = $request->status;
            $data['rate'] = $request->rate;
            $data['qnty'] = $request->qnty;
            $data['rate_total'] = $request->rate_total;
            DB::table('tbl_item')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function searchItemid($item_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_item')
                ->where('item_id', $item_id)
                ->first();
        echo json_encode($row);
    }

    public function searchbyitemName($mobile) {

        $check = DB::table('tbl_item')
                ->where('tbl_item.item_name', $mobile) //check mobile
                ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }

    public function AuthCheck() {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }

}