<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Report extends Controller {

    public function index() {
        $this->AuthCheck();
        $today = date("Y-m-d");
        $data = array();
        $data['sts']='';
        return view('admin.pages.orderreport.orderreport', $data);
    }

    public function mone_transaction_summary_report(Request $request){

      $fromdate = date("Y-m-d",strtotime($request->fromdate));
      $todate = date("Y-m-d",strtotime($request->todate)); 
      $cashIn=  DB::table('tbl_opening_balance')
                ->where('tbl_opening_balance.cash_type', 'Cash In')
                ->whereBetween('tbl_opening_balance.payment_date', [$fromdate, $todate])
                ->get();

      $cashOut= DB::table('tbl_opening_balance')
                ->where('tbl_opening_balance.cash_type', 'Cash Out')
                ->whereBetween('tbl_opening_balance.payment_date', [$fromdate, $todate])
                ->get();
      //cash in added 
      $confirmOrder = DB::table('tbl_order')
                ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                ->whereBetween('tbl_order.order_date', [$fromdate, $todate])
                ->where('tbl_order.status', 4)->get();
                
                
       // cash out
       $vendorPayment = DB::select( DB::raw("SELECT tbl_supplier.supplier_name, tbl_supplier.supplier_id,
                            SUM( tbl_supplier_invoice_one.total_amt ) AS totalAmt,SUM( tbl_supplier_invoice_one.due ) AS due
                            FROM `tbl_supplier_invoice_one` LEFT JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_invoice_one.supplier_id
                            WHERE 1 AND( invoice_date BETWEEN '$fromdate' AND '$todate' )
                            GROUP BY tbl_supplier_invoice_one.supplier_id ") );
       
       $totalExpense = DB::table('tbl_expense')
                      ->leftJoin('tbl_sub_exp_category', 'tbl_sub_exp_category.sub_category_id', '=', 'tbl_expense.sub_category_id')
                      ->leftJoin('tbl_bank', 'tbl_bank.bank_id', '=', 'tbl_expense.bank_id')
                      ->whereBetween('tbl_expense.payment_date', [$fromdate, $todate])->get();
       $salary = DB::table('tbl_salary')
                      ->leftJoin('tbl_employee', 'tbl_employee.employeeid', '=', 'tbl_salary.employeeid')
                      ->leftJoin('tbl_bank', 'tbl_bank.bank_id', '=', 'tbl_salary.bank_id')
                      ->whereBetween('tbl_salary.payment_date', [$fromdate, $todate])->get();
      
                
      $tconfimAmt=0;        
            foreach($confirmOrder as $i){
                if(!empty($i->quantity)){
                     $tconfimAmt += $i->cus_price * $i->quantity;
                }else{
                    $tconfimAmt += $i->cus_price * 1;
                }
            }
        //vendor    
       $vendorSum=0;
        foreach ($vendorPayment as $row) {
            $vendorSum += $row->totalAmt;
        }
        //exepnse
        $expsum=0;
        foreach ($totalExpense as $row) {
            $expsum += $row->amount;
        }
        //salry 
        $slrysum=0;
        foreach ($salary as $row) {
            $slrysum += $row->amount;
        }
 
      $in_row = $cashIn->count();
      $out_row = $cashOut->count();

   //############################################################################# Cash IN #####################################################
      $cashin_output='';
      $incash=0;
      $Ingrandtotal=0;
      $sl = 1;
      if ($in_row > 0) {
          foreach ($cashIn as $row) {
          $incash += $row->amount;
              $date = date("d-M-Y",strtotime($row->payment_date));
              $cashin_output .= "
              <tr>
              <td style='text-align: center;'> $sl </td>
              <td style='text-align: left;'> $row->reciver_name </td>
              <td style='text-align: left;'> $row->company_name </td>
              <td style='text-align: left;'> $row->mobile_no </td>
              <td style='text-align: left;'> $row->payment_type </td>
              <td style='text-align: right;'> $row->amount /= </td>
              </tr>";
              $sl++;
          }
          $Ingrandtotal= $incash + $tconfimAmt;
          $cashin_output .= "
          <tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>In Cash Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$incash /=</td>
          </tr>
          <tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Total Complete Order : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$tconfimAmt /=</td>
          </tr><tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Grand Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$Ingrandtotal /=</td>
          </tr>";

      } else {
          $cashin_output = "
     <tr>
      <td align='center' colspan='9'>No Data Found</td>
     </tr>
     ";
      }

//############################################################################# Cash Out #####################################################
      $cash_output='';
      $cashout=0;
      $Outgrandtotal=0;
      $sl = 1;
      if ($out_row > 0) {
          foreach ($cashOut as $row) {
          $cashout += $row->amount;
              $date = date("d-M-Y",strtotime($row->payment_date));
              $cash_output .= "
              <tr>
              <td style='text-align: center;'> $sl </td>
              <td style='text-align: left;'> $row->reciver_name </td>
              <td style='text-align: left;'> $row->company_name </td>
              <td style='text-align: left;'> $row->mobile_no </td>
              <td style='text-align: left;'> $row->payment_type </td>
              <td style='text-align: right;'> $row->amount /= </td>
              </tr>";
              $sl++;
          }

          $Outgrandtotal = ($vendorSum + $expsum + $slrysum + $cashout);
          
          $cash_output .= "
          <tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Cash Out Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$cashout /=</td>
          </tr><tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Vendor Payment Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$vendorSum /=</td>
          </tr><tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Expense Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$expsum /=</td>
          </tr><tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Salary Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$slrysum /=</td>
          </tr><tr>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: center;'></td>
          <td style='text-align: left; color: green; font-size: 15px; font-weight: bold;'>Grand Total : </td>
          <td style='text-align: right; color: green; font-size: 15px; font-weight: bold;'>$Outgrandtotal /=</td>
          </tr>";

      } else {
          $cash_output = "
     <tr>
      <td align='center' colspan='9'>No Data Found</td>
     </tr>
     ";
      }
    $currentBalace= ($Ingrandtotal - $Outgrandtotal);
// Output
      $data = array(
          'cash_in_data' => $cashin_output,
          'cash_out_data' => $cash_output,
          'currentBalace' => $currentBalace
      );
    echo json_encode($data);

    }

    public function orderReport(Request $request){
       
        $fromdate = date("Y-m-d",strtotime($request->fromdate));
        $todate = date("Y-m-d",strtotime($request->todate)); 
        $status = $request->status;
    
        $report=  DB::table('tbl_order')
                ->select(DB::raw('tbl_customer.mobile,tbl_order.status,tbl_customer.mobile,tbl_order.order_date,tbl_order.OrderId'))
                ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                ->where('tbl_order.status', $status)
                ->whereBetween('tbl_order.order_date', [$fromdate, $todate])
                ->get();
                $total_row = $report->count();
                $output='';
                $result='';
                $cusPriceSum=0;
                $sellingSum = 0;
                $customer_sum=0;
                $sl = 1;
                if ($total_row > 0) {
                    foreach ($report as $row) {
                    $countOrder= DB::table('tbl_order_details')->where('tbl_order_details.order_id', $row->OrderId)->get();
                    $customerPrice = DB::table('tbl_order_details')
                                ->where('tbl_order_details.order_id', $row->OrderId)->get();
                 $qtyCount = 0;
               
                 foreach($countOrder as $key=>$value){
                    if($value->quantity==""){
                         $qtyCount += 1;
                    }else{
                         $qtyCount += $value->quantity;
                    }
                  
                 }
                 $sellingSum += $qtyCount;
                 //Customer Price Calcuation
                 $cusPrice=0;
                 //$customer_sum=0;
                 foreach ($customerPrice as $i) {
                        if(!empty($i->quantity)){
                              $cusPrice += $i->quantity * $i->cus_price;
                        }else{
                              $cusPrice += 1 * $i->cus_price;
                        }
                    }
                    $customer_sum += $cusPrice;
                 
                    $date = date("d-M-Y",strtotime($row->order_date));
                      if($row->status == '2'){
                        $sts = 'Confirm Order';
                      }elseif($row->status == '3'){
                        $sts = 'Shipped Order';
                      }elseif($row->status == '4'){
                        $sts = 'Complete Order';
                      }
                    $output .= "
                    <tr>
                    <td style='text-align: center;'> $sl </td>
                    <td style='text-align: center;'> $row->OrderId </td>
                    <td style='text-align: center;'> $row->mobile </td>
                    <td style='text-align: center;'> $date </td>
                    <td style='text-align: center;'> $qtyCount </td>
                    <td style='text-align: center;'> $cusPrice/=</td>
                    <td style='text-align: center;'> $sts </td>
                    </tr>";
                    $sl++;
                }
                   
                    $output .= "
                    <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center; color: green; font-size: 15px; font-weight: bold;'>Grand Total : </td>
                    <td style='text-align: center; color: green; font-size: 15px; font-weight: bold;'>$sellingSum </td>
                    <td style='text-align: center; color: green; font-size: 15px; font-weight: bold;'>$customer_sum/=</td>
                    <td style='text-align: center;'></td>
                    </tr>";

                } else {
                    $output = "
               <tr>
                <td align='center' colspan='9'>No Data Found</td>
               </tr>
               ";
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