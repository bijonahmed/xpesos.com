<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class ItemReport extends Controller {

    public function InSubCatWiseItemrpt(Request $request){
     
        $category_id= $_GET["category_id"];
        $sub_cat_id= $_GET["sub_cat_id"];
        $sub_in_sub_id= $_GET["sub_in_sub_id"];
        $fromdate= $_GET["fromdate"];
        $todate= $_GET["todate"];
       
        $fdate = date("Y-m-d",strtotime($fromdate));
        $tdate = date("Y-m-d",strtotime($todate));
        //$request->fromdate, $request->todate
        $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->where('tbl_product.category_id',$category_id)
                        ->where('tbl_product.sub_cat_id',$sub_cat_id)
                        ->where('tbl_product.sub_in_sub_id',$sub_in_sub_id)
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
      $output = '';
      $total_row = $data->count();
            $sl = 1;
             $opStock=0;
            $tselling=0;
            $tpurchase=0;
            $tqhand=0;
            $tvinstok=0;
            $tsellingprice=0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    //for selling price  
                    $findorders = DB::table('tbl_item_stock_out')
                             ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->where('tbl_item_stock_out.product_id', $row->product_id)
                             ->whereIn('tbl_order.status', [2, 3, 4])
                             ->get();
                             
                    $customerPrice = 0;
                    foreach ($findorders as $i) {
                        $customerPrice = $i->cus_price;
                    }
                    // for order qty
                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                           // ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->whereIn('tbl_order.status', [2, 3, 4])
                            ->get();
                            
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                  ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->leftJoin('tbl_supplier_invoice_one', 'tbl_supplier_invoice_one.supplier_invoice_id', '=', 'tbl_supplier_invoice_two.supplier_invoice_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                 // ->whereBetween('tbl_supplier_invoice_one.invoice_date', [$fdate, $tdate])
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $orginal_price=  DB::table('tbl_product')->select(DB::raw('tbl_product.orginal_price'))->where('tbl_product.product_id', $row->product_id)->first();
                                  
                    $pur=0;
                    $valueInStock=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }
                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_in_hand = $openingBalance + $totalPurchase -  $totalSelling ;
                     $valinStock= $qty_in_hand * $orginal_price->orginal_price;
                     $totalSellingPrice= $totalSelling * $customerPrice;
                      //Output Sum 
                     $opStock += $openingBalance;
                     $tselling += $totalSelling;
                     $tpurchase += $totalPurchase;
                     $tqhand += $qty_in_hand;
                     $tvinstok += $valinStock;
                     $tsellingprice += $totalSellingPrice;
                  
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $output .= "
            <tr>
            <td>$sl </td>
            <td> $row->product_code </td>
            <td> $row->product_name </td>
            <td><center> $openingBalance </center></td>
            <td><center> $totalSelling </center></td>
            <td><center> $totalPurchase </center></td>
            <td><center> $qty_in_hand </center></td>
            <td><center> $valinStock /=</center></td>
            <td><center> $totalSellingPrice /=</center> </td>
            </tr>";
                    $sl++;
                }
                $output .= "
                <tr style='color: green; font-weight: bold;'>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><center>$opStock</center></td>
                <td><center>$tselling</center></td>
                <td><center>$tpurchase</center></td>
                <td><center>$tqhand</center></td>
                <td><center>$tvinstok /=</center></td>
                <td><center>$tsellingprice /=</center> </td>
                </tr>";
            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
            );
            echo json_encode($data);

        }

    public function SubCatWiseItemrpt(Request $request){

        $category_id= $_GET["category_id"];
        $sub_cat_id= $_GET["sub_cat_id"];
        $fromdate= $_GET["fromdate"];
        $todate= $_GET["todate"];
       
        $fdate = date("Y-m-d",strtotime($fromdate));
        $tdate = date("Y-m-d",strtotime($todate));
        //print_r("$fdate ----- $tdate ");exit;

        $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->where('tbl_product.category_id',$category_id)
                        ->where('tbl_product.sub_cat_id',$sub_cat_id)
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
      $output = '';
      $total_row = $data->count();
            $sl = 1;
            $opStock=0;
            $tselling=0;
            $tpurchase=0;
            $tqhand=0;
            $tvinstok=0;
            $tsellingprice=0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    //for selling price  
                    $findorders = DB::table('tbl_item_stock_out')
                             ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->where('tbl_item_stock_out.product_id', $row->product_id)
                             ->whereIn('tbl_order.status', [2, 3, 4])
                             ->get();
                             
                    $customerPrice = 0;
                    foreach ($findorders as $i) {
                        $customerPrice = $i->cus_price;
                    }
                    // for order qty
                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            //->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->whereIn('tbl_order.status', [2, 3, 4])
                            ->get();
                            
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                  ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->leftJoin('tbl_supplier_invoice_one', 'tbl_supplier_invoice_one.supplier_invoice_id', '=', 'tbl_supplier_invoice_two.supplier_invoice_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                 // ->whereBetween('tbl_supplier_invoice_one.invoice_date', [$fdate, $tdate])
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $orginal_price=  DB::table('tbl_product')->select(DB::raw('tbl_product.orginal_price'))->where('tbl_product.product_id', $row->product_id)->first();
                                  
                    $pur=0;
                    $valueInStock=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }
                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_in_hand = $openingBalance + $totalPurchase -  $totalSelling ;
                     $valinStock= $qty_in_hand * $orginal_price->orginal_price;
                     $totalSellingPrice= $totalSelling * $customerPrice;
                     //Output Sum 
                     $opStock += $openingBalance;
                     $tselling += $totalSelling;
                     $tpurchase += $totalPurchase;
                     $tqhand += $qty_in_hand;
                     $tvinstok += $valinStock;
                     $tsellingprice += $totalSellingPrice;
                     
                  
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $output .= "
            <tr>
            <td>$sl </td>
            <td> $row->product_code </td>
            <td> $row->product_name </td>
            <td><center> $openingBalance </center></td>
            <td><center> $totalSelling </center></td>
            <td><center> $totalPurchase </center></td>
            <td><center> $qty_in_hand </center></td>
            <td><center> $valinStock /=</center></td>
            <td><center> $totalSellingPrice /=</center> </td>
            </tr>";
                    $sl++;
                }
                  $output .= "
                <tr style='color: green; font-weight: bold;'>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><center>$opStock</center></td>
                <td><center>$tselling</center></td>
                <td><center>$tpurchase</center></td>
                <td><center>$tqhand</center></td>
                <td><center>$tvinstok /=</center></td>
                <td><center>$tsellingprice /=</center> </td>
                </tr>";
            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
            );
            echo json_encode($data);

    }

    public function CatWiseItemrpt(Request $request){
   
        $category_id= $_GET["category_id"];
        $fromdate= $_GET["fromdate"];
        $todate= $_GET["todate"];
        
        $fdate = date("Y-m-d",strtotime($fromdate));
        $tdate = date("Y-m-d",strtotime($todate));
        //print_r("$fdate ----- $tdate ");exit;

        $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->where('tbl_product.category_id',$category_id)
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
      $output = '';
      $total_row = $data->count();
            $sl = 1;
            $opStock=0;
            $tselling=0;
            $tpurchase=0;
            $tqhand=0;
            $tvinstok=0;
            $tsellingprice=0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    //for selling price  
                    $findorders = DB::table('tbl_item_stock_out')
                             ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->where('tbl_item_stock_out.product_id', $row->product_id)
                             ->whereIn('tbl_order.status', [2, 3, 4])
                             ->get();
                             
                    $customerPrice = 0;
                    foreach ($findorders as $i) {
                        $customerPrice = $i->cus_price;
                    }
                    // for order qty
                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            //->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->whereIn('tbl_order.status', [2, 3, 4])
                            ->get();
                            
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                  ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->leftJoin('tbl_supplier_invoice_one', 'tbl_supplier_invoice_one.supplier_invoice_id', '=', 'tbl_supplier_invoice_two.supplier_invoice_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                 // ->whereBetween('tbl_supplier_invoice_one.invoice_date', [$fdate, $tdate])
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                    $orginal_price=  DB::table('tbl_product')->select(DB::raw('tbl_product.orginal_price'))->where('tbl_product.product_id', $row->product_id)->first();
                                  
                    $pur=0;
                    $valueInStock=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }
                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_in_hand = $openingBalance + $totalPurchase -  $totalSelling ;
                     $valinStock= $qty_in_hand * $orginal_price->orginal_price;
                     $totalSellingPrice= $totalSelling * $customerPrice;
                     
                     //Output Sum 
                     $opStock += $openingBalance;
                     $tselling += $totalSelling;
                     $tpurchase += $totalPurchase;
                     $tqhand += $qty_in_hand;
                     $tvinstok += $valinStock;
                     $tsellingprice += $totalSellingPrice;
                  
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $output .= "
            <tr>
            <td>$sl </td>
            <td> $row->product_code </td>
            <td> $row->product_name </td>
            <td><center> $openingBalance </center></td>
            <td><center> $totalSelling </center></td>
            <td><center> $totalPurchase </center></td>
            <td><center> $qty_in_hand </center></td>
            <td><center> $valinStock /=</center></td>
            <td><center> $totalSellingPrice /=</center> </td>
            </tr>";
                    $sl++;
                }
                
                $output .= "
                <tr style='color: green; font-weight: bold;'>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><center>$opStock</center></td>
                <td><center>$tselling</center></td>
                <td><center>$tpurchase</center></td>
                <td><center>$tqhand</center></td>
                <td><center>$tvinstok /=</center></td>
                <td><center>$tsellingprice /=</center> </td>
                </tr>";
            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
            );
            echo json_encode($data);

    }

    public function itemreportdefault(Request $request){

        $fromdate= $_GET["fromdate"];
        $todate= $_GET["todate"];
        
        $fdate = date("Y-m-d",strtotime($fromdate));
        $tdate = date("Y-m-d",strtotime($todate));
        //print_r("$fdate ----- $tdate ");exit;

        $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,tbl_product.product_name,tbl_product.product_id,tbl_product.product_code,tbl_item.item_id,tbl_item.status'))
                        ->where('tbl_product.product_name', 'like', '%' . $query . '%')
                        ->orwhere('tbl_product.product_code', 'like', '%' . $query . '%')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
            } else {
        $data = DB::table('tbl_item')
                        ->select(DB::raw('tbl_sub_in_sub_cat_name.sub_in_sub_cat_name,tbl_subcategory.sub_cat_name,
                                         tbl_category.category_name,tbl_item.rate_total,tbl_item.rate,tbl_item.qnty,
                                         tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,
                                         tbl_item.item_id,tbl_item.status'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                        ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                        ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                        ->orderBy('tbl_item.item_id', 'desc')
                        ->get();
            }
      $output = '';
      $total_row = $data->count();
            $sl = 1;
            $opStock=0;
            $tselling=0;
            $tpurchase=0;
            $tqhand=0;
            $tvinstok=0;
            $tsellingprice=0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    //for selling price  
                    $findorders = DB::table('tbl_item_stock_out')
                             ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                             ->where('tbl_item_stock_out.product_id', $row->product_id)
                             ->whereIn('tbl_order.status', [2, 3, 4])
                             ->get();
                             
                    $customerPrice = 0;
                    foreach ($findorders as $i) {
                        $customerPrice = $i->cus_price;
                    }
                    // for order qty
                    $find_product = DB::table('tbl_item_stock_out')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            //->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->leftJoin('tbl_order', 'tbl_order.order_id', '=', 'tbl_item_stock_out.OrderId')
                            ->where('tbl_item_stock_out.product_id', $row->product_id)
                            ->whereIn('tbl_order.status', [2, 3, 4])
                            ->get();
                            
                            
                    $orderQty = 0;
                    foreach ($find_product as $i) {
                        $orderQty += $i->order_qnty;
                    }
                    //purchase 
                    $purchase =   DB::table('tbl_item')
                                  ->leftJoin('tbl_supplier_invoice_two', 'tbl_supplier_invoice_two.item_id', '=', 'tbl_item.item_id')
                                  ->leftJoin('tbl_supplier_invoice_one', 'tbl_supplier_invoice_one.supplier_invoice_id', '=', 'tbl_supplier_invoice_two.supplier_invoice_id')
                                  ->where('tbl_item.product_id', $row->product_id)
                                 // ->whereBetween('tbl_supplier_invoice_one.invoice_date', [$fdate, $tdate])
                                  ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
                                  
                    $orginal_price=  DB::table('tbl_product')->select(DB::raw('tbl_product.orginal_price'))->where('tbl_product.product_id', $row->product_id)->first();
                                  
                    $pur=0;
                    $valueInStock=0;
                    foreach($purchase as $i){
                        $pur += $i->qnty;
                    }
                     $openingBalance = $row->qnty; 
                     $totalSelling = $orderQty;   
                     $totalPurchase = $pur;
                     $qty_in_hand = $totalPurchase -  $totalSelling ;
                     $valinStock= $qty_in_hand * $orginal_price->orginal_price;
                     $totalSellingPrice= $totalSelling * $customerPrice;

                     //Output Sum 
                     $opStock += $openingBalance;
                     $tselling += $totalSelling;
                     $tpurchase += $totalPurchase;
                     $tqhand += $qty_in_hand;
                     $tvinstok += $valinStock;
                     $tsellingprice += $totalSellingPrice;
                  
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $output .= "
            <tr>
            <td>$sl </td>
            <td> $row->product_code </td>
            <td> $row->product_name </td>
            <td><center> $openingBalance </center></td>
            <td><center> $totalSelling </center></td>
            <td><center> $totalPurchase </center></td>
            <td><center> $qty_in_hand </center></td>
            <td><center> $valinStock /=</center></td>
            <td><center> $totalSellingPrice /=</center> </td>
            </tr>";
                    $sl++;
                }

                $output .= "
                <tr style='color: green; font-weight: bold;'>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><center>$opStock</center></td>
                <td><center>$tselling</center></td>
                <td><center>$tpurchase</center></td>
                <td><center>$tqhand</center></td>
                <td><center>$tvinstok /=</center></td>
                <td><center>$tsellingprice /=</center> </td>
                </tr>";

            } else {
                $output = '
           <tr>
            <td align="center" colspan="9">No Data Found</td>
           </tr>
           ';
            }
            $data = array(
                'table_data' => $output,
            );
            echo json_encode($data);

    }
 
    public function AuthCheck() {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }

}