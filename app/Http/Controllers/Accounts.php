<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
//session_start();
class Accounts extends Controller {
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
  public function salarySheet(){
    $data['title']= "Salary Sheet";
    $data['employee'] = DB::table('tbl_employee')->where('status', 1)->get();
    $data['bank'] = DB::table('tbl_bank')->orderBy('tbl_bank.bank_id', 'asc')->get();
    return view('admin.pages.accounts.salary_sheet', $data);
    }
    public function profitLoss(){
        $data['title']= "Profit Loss Report";
        return view('admin.pages.accounts.profitloss', $data);
    }
    public function detailseReport(){
        $data['title']= "Details Report";
        return view('admin.pages.accounts.detailsreport', $data);
    }
    public function partyPayment(){
        $data['title']= "Party Payment";
        $data['vendor'] = DB::table('tbl_supplier')->orderBy('tbl_supplier.supplier_id', 'asc')->get();
        $data['bank'] = DB::table('tbl_bank')->orderBy('tbl_bank.bank_id', 'asc')->get();
        return view('admin.pages.accounts.partypaymentlist', $data);
    }
    public function expense(){
        $data['title']= "Expense";
        $data['vendor'] = DB::table('tbl_supplier')->orderBy('tbl_supplier.supplier_id', 'asc')->get();
        $data['expenseCategory'] = DB::table('tbl_sub_exp_category')->where('status',1)->get();
        $data['bank'] = DB::table('tbl_bank')->orderBy('tbl_bank.bank_id', 'asc')->get();
        return view('admin.pages.accounts.expenselist', $data);
    }
    public function moneyTransection() {
        $data['title']= "Opening Balance";
        $data['bank'] = DB::table('tbl_bank')->orderBy('tbl_bank.bank_id', 'asc')->get();
        $data['data'] = DB::table('tbl_setting')->first();
        return view('admin.pages.accounts.moneyTransection', $data);
    }
    public function expenseRow($expense_id){
        $data = DB::table('tbl_expense')
                ->leftJoin('tbl_sub_exp_category', 'tbl_sub_exp_category.sub_category_id', '=', 'tbl_expense.sub_category_id')
                ->where('tbl_expense.expense_id',$expense_id)
                ->first();
        echo json_encode($data);
    }
    public function subExpenserow($sub_category_id){
        $row = DB::table('tbl_sub_exp_category')
                        ->where('sub_category_id', $sub_category_id)->first();
        echo json_encode($row);
    }
    public function SalaryRow($salary_id){
        $data = DB::table('tbl_salary')
                ->leftJoin('tbl_employee', 'tbl_employee.employeeid', '=', 'tbl_salary.employeeid')
                ->where('tbl_salary.salary_id', $salary_id)
                ->first();
                echo json_encode($data);
    }
    public function editPartyPayment($party_payment_id){
        $data = DB::table('tbl_party_payment')
        ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_party_payment.supplier_id')
        ->where('tbl_party_payment.party_payment_id',$party_payment_id)
        ->first();
        echo json_encode($data);
    }

    public function openinigBalanceRow($op_balanceid){
        $data = DB::table('tbl_opening_balance')
        ->where('tbl_opening_balance.op_balanceid',$op_balanceid)
        ->first();
        echo json_encode($data);
    }

    public function EmpSalaryRow($employeeid){
        $data = DB::table('tbl_salary')
        ->where('tbl_salary.employeeid',$employeeid)
        ->first();
        echo json_encode($data);

    }

    public function MakeDetailsReport(Request $request){
        $fromdate = date("Y-m-d",strtotime($request->fdate));
        $todate = date("Y-m-d",strtotime($request->tdate));
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

       # ===================================================== For Vendor Payment =============================================
        $vendor_output='';
        $vendorSum=0;
        $vendordue=0;
        foreach ($vendorPayment as $row) {
            $vendorSum += $row->totalAmt;
            $vendordue += $row->due;
            $vendor_output .= "
            <tr>
              <td class='text-left'>$row->supplier_name</td>
              <td class='text-center'>$row->totalAmt</td>
              <td class='text-center'>$row->due</td>
              <td class='text-center'></td>
              <td class='text-center'></td>
              
            </tr>";
        }
        $vendor_output .= "<tr><td></td> 
                        <td style='color: green; font-weight: bold; font-size: 15px; text-align: center;'>TK. $vendorSum</td>
                          <td style='color: green; font-weight: bold; font-size: 15px; text-align: center;'>TK. $vendordue</td>
                    </tr>";
                    
         # ===================================================== For Expense =============================================
         $expense_output='';
         $expenseSum=0;
         $oututsum=0;
         foreach ($totalExpense as $row) {
            if($row->payment_type=="Cash"){
                $bank="-";
                $checkno="-";
            }elseif($row->payment_type=="Bank"){
                $bank= $row->bank_name;
                $checkno= "Chaque No: ".$row->chaque_no;;
            }else{
                echo "Nothing";
            }
            $date= date("d-M-Y",strtotime($row->payment_date));
            $amount=number_format($row->amount);
            $expenseSum+=$row->amount;
            $oututsum=number_format($expenseSum);
            if(!empty($row->reamrks)){
                $rmks= '<b>['.$row->reamrks.']</b>';
            }else{
                $rmks="";
            }
             $expense_output .= "
             <tr>
             <td class='text-left'>$row->sub_category_name $rmks</td>
             <td class='text-center'>$row->payment_type</td>
             <td class='text-center'>$bank<br>$checkno</td>
             <td class='text-center'>$date</td>
             <td class='text-center'>$amount</td>
           </tr>";
         }
         $expense_output .= "<tr><td colspan='4'></td> 
                        <td style='color: green; font-weight: bold; font-size: 15px; text-align: center;'>TK. $expenseSum</td>
                    </tr>";
        # ===================================================== For Salary =============================================
            $salary_output='';
            $salarySum=0;
            $oututsum=0;
            foreach ($salary as $row) {
            if($row->payment_type=="Cash"){
                $bank="-";
                $checkno="-";
            }elseif($row->payment_type=="Bank"){
                $bank= $row->bank_name;
                $checkno= "Chaque No: ".$row->chaque_no;;
            }else{
                echo "Nothing";
            }
            $date= date("d-M-Y",strtotime($row->payment_date));
            $amount=number_format($row->amount);
            $salarySum+=$row->amount;
            $oututsum=number_format($salarySum);
                $salary_output .= "
                <tr>
                <td class='text-left'>$row->employeename</td>
                <td class='text-center'>$row->payment_type</td>
                <td class='text-center'>$bank<br>$checkno</td>
                <td class='text-center'>$date</td>
                <td class='text-center'>$amount</td>
            </tr>";
            }
            $salary_output .= "<tr><td colspan='4'></td> 
                        <td style='color: green; font-weight: bold; font-size: 15px; text-align: center;'>TK. $salarySum</td>
                    </tr>";
        #====================================================== Total Sum =========================================
        $grandTotal= ($vendorSum + $expenseSum + $salarySum);
        $vpayment = number_format($vendorSum);
        $expensesum = number_format($expenseSum);
        $ssum = number_format($salarySum);
        $gtotal= number_format($grandTotal);
        $totalCalOutput='';
        $totalCalOutput .="<br><table width='100%' border='0' class='table-striped'>
        <tr>
          <td>Total Vendor Payment</td>
          <td class='text-right'>$vpayment</td>
        </tr>
        <tr>
          <td>Total Expense</td>
          <td class='text-right'>$expensesum</td>
        </tr>
        <tr>
          <td>Total Salary</td>
          <td class='text-right'>$ssum</td>
        </tr>
        <tr style='background-color: green; color: white; font-size: 30px;'>
        <td>Total</td>
        <td class='text-right'>$gtotal</td>
      </tr>
      </table>";
        #=============================================== all table output ========================================== 
        $data = array(
            'expense' => $expense_output, // Expense data assign this array
            'vendorpayment' => $vendor_output, // Vendor Payment data assign this array
            'salary' => $salary_output, // For Salary data assign this array
            'toalSum' => $totalCalOutput, // For Salary data assign this array
        );
             echo json_encode($data);
    }
    public function profitLossCalculation(Request $request){
        if ($request->ajax()) {
            $output = '';
            $fromdate = date("Y-m-d",strtotime($request->fdate));
            $todate = date("Y-m-d",strtotime($request->tdate));
            $confirmOrder = DB::table('tbl_order')
                            ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                            ->whereBetween('tbl_order.order_date', [$fromdate, $todate])
                            ->where('tbl_order.status', 4)->get();
            $tconfimAmt=0;        
            foreach($confirmOrder as $i){
                if(!empty($i->quantity)){
                     $tconfimAmt += $i->cus_price * $i->quantity;
                }else{
                    $tconfimAmt += $i->cus_price * 1;
                }
            }

            $totalPurchase = DB::table('tbl_supplier_invoice_one')->whereBetween('tbl_supplier_invoice_one.invoice_date', [$fromdate, $todate])->sum('tbl_supplier_invoice_one.total_amt');
            $totalExpense = DB::table('tbl_expense')->whereBetween('tbl_expense.payment_date', [$fromdate, $todate])->sum('tbl_expense.amount');
            $totalSalary = DB::table('tbl_salary')->whereBetween('tbl_salary.payment_date', [$fromdate, $todate])->sum('tbl_salary.amount');
            $calculation = ($tconfimAmt - $totalPurchase - $totalExpense - $totalSalary);
            $finalresult = number_format($calculation);
            $confirmAmt= number_format($tconfimAmt);
            $purchase= number_format($totalPurchase);
            $expense= number_format($totalExpense);
            $salary= number_format($totalSalary);
            $output .= "
             <tr>
               <td class='text-center'>$confirmAmt</td>
               <td class='text-center'>$purchase</td>
               <td class='text-center'>$expense </td>
               <td class='text-center'>$salary</td>
               <td class='text-center' style='color: red; font-weight: bold; font-size: 25px;'>Tk.$finalresult</td>
             </tr>";
            }
            $data = array(
                'table_data' => $output,
            );
            echo json_encode($data);
        }
    public function searchbySalary(Request $request){
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_salary')
                        ->select(DB::raw('tbl_salary.payment_type,tbl_employee.employeename,tbl_salary.payment_date,tbl_salary.amount,tbl_salary.salary_id'))
                        ->leftJoin('tbl_employee', 'tbl_employee.employeeid', '=', 'tbl_salary.employeeid')
                        ->where('tbl_employee.employeename', 'like', '%' . $query . '%')
                        ->orderBy('tbl_salary.employeeid', 'desc')
                        ->get();
            } else {
                $data = DB::table('tbl_salary')
                        ->select(DB::raw('tbl_salary.payment_type,tbl_employee.employeename,tbl_salary.payment_date,tbl_salary.amount,tbl_salary.salary_id'))
                        ->leftJoin('tbl_employee', 'tbl_employee.employeeid', '=', 'tbl_salary.employeeid')
                        ->orderBy('tbl_salary.employeeid', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
            $edit = '<a onclick="getbyId(' . $row->salary_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
             <td>' . $sl . '</td>
             <td>' . $row->employeename . '</td>
             <td>' . date("d-M-Y",strtotime($row->payment_date)) . '</td>
             <td>' . '৳'. $row->amount . '</td>
             <td>' . $row->payment_type . '</td>
             <td>' . $edit .  '</td>
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

    public function searchbyOpeningBalance(Request $request){
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_opening_balance')
                        ->where('tbl_opening_balance.company_name', 'like', '%' . $query . '%')
                        ->orwhere('tbl_opening_balance.email', 'like', '%' . $query . '%')
                        ->orwhere('tbl_opening_balance.mobile_no', 'like', '%' . $query . '%')
                        ->orderBy('tbl_opening_balance.op_balanceid', 'desc')
                        ->get();
            } else {
                $data = DB::table('tbl_opening_balance')
                        ->orderBy('tbl_opening_balance.op_balanceid', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
            $edit = '<a onclick="getbyId(' . $row->op_balanceid . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
             <td>' . $sl . '</td>
              <td>' . $row->reciver_name . '</td>
             <td>' . $row->company_name . '</td>
             <td>' . $row->email . '</td>
             <td>' . $row->mobile_no . '</td>
             <td>' . date("d-M-Y",strtotime($row->payment_date)) . '</td>
             <td>' . '৳'. $row->amount . '</td>
             <td>' . $row->cash_type . '</td>
             <td>' . $edit .  '</td>
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

    public function searchbyExpenes(Request $request){
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_expense')
                        ->select(DB::raw('tbl_expense.payment_type,tbl_sub_exp_category.sub_category_name,tbl_expense.payment_date,tbl_expense.amount,tbl_expense.expense_id'))
                        ->leftJoin('tbl_sub_exp_category', 'tbl_sub_exp_category.sub_category_id', '=', 'tbl_expense.sub_category_id')
                        ->where('tbl_sub_exp_category.sub_category_name', 'like', '%' . $query . '%')
                        ->orderBy('tbl_expense.expense_id', 'desc')
                        ->get();
            } else {
                $data = DB::table('tbl_expense')
                        ->select(DB::raw('tbl_expense.payment_type,tbl_sub_exp_category.sub_category_name,tbl_expense.payment_date,tbl_expense.amount,tbl_expense.expense_id'))
                        ->leftJoin('tbl_sub_exp_category', 'tbl_sub_exp_category.sub_category_id', '=', 'tbl_expense.sub_category_id')
                        ->orderBy('tbl_expense.expense_id', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
            $edit = '<a onclick="getbyId(' . $row->expense_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
             <td>' . $sl . '</td>
             <td>' . $row->sub_category_name . '</td>
             <td>' . date("d-M-Y",strtotime($row->payment_date)) . '</td>
             <td>' . '৳'. $row->amount . '</td>
             <td>' . $row->payment_type . '</td>
             <td>' . $edit .  '</td>
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
    public function searchbyPartyPayment(Request $request){
          if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_party_payment')
                        ->select(DB::raw('tbl_party_payment.payment_type,tbl_supplier.supplier_name,tbl_party_payment.payment_date,tbl_party_payment.amount,tbl_party_payment.party_payment_id'))
                        ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_party_payment.supplier_id')
                        ->where('tbl_supplier.supplier_name', 'like', '%' . $query . '%')
                        ->where('tbl_supplier.supplier_phone', 'like', '%' . $query . '%')
                        ->where('tbl_party_payment.payment_type', 'like', '%' . $query . '%')
                        ->orderBy('tbl_party_payment.party_payment_id', 'desc')
                        ->get();
            } else {
                $data = DB::table('tbl_party_payment')
                        ->select(DB::raw('tbl_party_payment.payment_type,tbl_supplier.supplier_name,tbl_party_payment.payment_date,tbl_party_payment.amount,tbl_party_payment.party_payment_id'))
                        ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_party_payment.supplier_id')
                        ->orderBy('tbl_party_payment.party_payment_id', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
            $edit = '<a onclick="getbyId(' . $row->party_payment_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
             <td>' . $sl . '</td>
             <td>' . $row->supplier_name . '</td>
             <td>' . date("d-M-Y",strtotime($row->payment_date)) . '</td>
             <td>' . '৳'. $row->amount . '</td>
             <td>' . $row->payment_type . '</td>
             <td>' . $edit .  '</td>
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
    public function SaveSalary(Request $request){
        $data = array();
        if (!empty($request->salary_id)) {
              if($request->payment_type=="cash"){
                  //If Cash
                  $data['employeeid'] = $request->employeeid;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['reamrks'] = $request->reamrks;
                  $data['status'] = $request->status;
                  $data['bank_id'] = '';
                  $data['chaque_no'] = '';
              }else{
                  //If Bank
                  $data['employeeid'] = $request->employeeid;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['bank_id'] = $request->bank_id;
                  $data['chaque_no'] = $request->chaque_no;
                  $data['status'] = $request->status;
              }
              DB::table('tbl_salary')
                      ->where('salary_id', $request->salary_id)
                      ->update($data);
             echo json_encode("Successfully update");
        }else{
            if($request->payment_type=="cash"){
                  //If Cash
                  $data['employeeid'] = $request->employeeid;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['reamrks'] = $request->reamrks;
                  $data['status'] = $request->status;
                  $data['bank_id'] = '';
                  $data['chaque_no'] = '';
              }else{
                  //If Bank
                  $data['employeeid'] = $request->employeeid;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['bank_id'] = $request->bank_id;
                  $data['chaque_no'] = $request->chaque_no;
                  $data['status'] = $request->status;
                  $data['reamrks'] = $request->reamrks;
              }
              DB::table('tbl_salary')->insert($data);
              echo json_encode("Successfully Save");
        }
    }
    public function SavePartyPayment(Request $request){
        $data = array();
              if (!empty($request->party_payment_id)) {
                    if($request->payment_type=="cash"){
                        //If Cash
                        $data['supplier_id'] = $request->supplier_id;
                        $data['payment_type'] = $request->payment_type;
                        $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                        $data['amount'] = $request->amount;
                        $data['reamrks'] = $request->reamrks;
                        $data['status'] = $request->status;
                        $data['bank_id'] = '';
                        $data['chaque_no'] = '';
                    }else{
                        //If Bank
                         $data['supplier_id'] = $request->supplier_id;
                        $data['payment_type'] = $request->payment_type;
                        $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                        $data['amount'] = $request->amount;
                        $data['bank_id'] = $request->bank_id;
                        $data['chaque_no'] = $request->chaque_no;
                        $data['status'] = $request->status;
                    }
                    DB::table('tbl_party_payment')
                            ->where('party_payment_id', $request->party_payment_id)
                            ->update($data);
                   echo json_encode("Successfully update");
              }else{
                  if($request->payment_type=="cash"){
                        //If Cash
                         $data['supplier_id'] = $request->supplier_id;
                        $data['payment_type'] = $request->payment_type;
                        $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                        $data['amount'] = $request->amount;
                        $data['reamrks'] = $request->reamrks;
                        $data['status'] = $request->status;
                        $data['bank_id'] = '';
                        $data['chaque_no'] = '';
                    }else{
                        //If Bank
                        $data['supplier_id'] = $request->supplier_id;
                        $data['payment_type'] = $request->payment_type;
                        $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                        $data['amount'] = $request->amount;
                        $data['bank_id'] = $request->bank_id;
                        $data['chaque_no'] = $request->chaque_no;
                        $data['status'] = $request->status;
                        $data['reamrks'] = $request->reamrks;
                    }
                    DB::table('tbl_party_payment')->insert($data);
                    echo json_encode("Successfully Save");
              }
    }

    public function SaveOpeningBalance(Request $request){
        $data = array();
        if (!empty($request->op_balanceid)) {
              if($request->payment_type=="cash"){
                  //If Cash
                  $data['reciver_name'] = $request->reciver_name;
                  $data['company_name'] = $request->company_name;
                  $data['email'] = $request->email;
                  $data['mobile_no'] = $request->mobile_no;
                  $data['address'] = $request->address;
                  $data['payment_type'] = $request->payment_type;
                  $data['cash_type'] = $request->cash_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['reamrks'] = $request->reamrks;
                  $data['status'] = $request->status;
                  $data['bank_id'] = '';
                  $data['chaque_no'] = '';
              }else{
                  //If Bank
                  $data['reciver_name'] = $request->reciver_name;
                  $data['company_name'] = $request->company_name;
                  $data['email'] = $request->email;
                  $data['mobile_no'] = $request->mobile_no;
                  $data['address'] = $request->address;
                  $data['payment_type'] = $request->payment_type;
                  $data['cash_type'] = $request->cash_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['bank_id'] = $request->bank_id;
                  $data['reamrks'] = $request->reamrks;
                  $data['chaque_no'] = $request->chaque_no;
                  $data['status'] = $request->status;
              }
              DB::table('tbl_opening_balance')
                      ->where('op_balanceid', $request->op_balanceid)
                      ->update($data);
             echo json_encode("Successfully update");
        }else{
            if($request->payment_type=="cash"){
                  //If Cash
                  $data['reciver_name'] = $request->reciver_name;
                  $data['company_name'] = $request->company_name;
                  $data['email'] = $request->email;
                  $data['mobile_no'] = $request->mobile_no;
                  $data['address'] = $request->address;
                  $data['payment_type'] = $request->payment_type;
                  $data['cash_type'] = $request->cash_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['reamrks'] = $request->reamrks;
                  $data['status'] = $request->status;
                  $data['bank_id'] = '';
                  $data['chaque_no'] = '';
              }else{
                  //If Bank
                  $data['reciver_name'] = $request->reciver_name;
                  $data['company_name'] = $request->company_name;
                  $data['email'] = $request->email;
                  $data['mobile_no'] = $request->mobile_no;
                  $data['address'] = $request->address;
                  $data['payment_type'] = $request->payment_type;
                  $data['cash_type'] = $request->cash_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['bank_id'] = $request->bank_id;
                  $data['chaque_no'] = $request->chaque_no;
                  $data['status'] = $request->status;
                  $data['reamrks'] = $request->reamrks;
              }
              DB::table('tbl_opening_balance')->insert($data);
              echo json_encode("Successfully Save");
        }

    }

    public function SaveExpense(Request $request){
        $data = array();
        if (!empty($request->expense_id)) {
              if($request->payment_type=="cash"){
                  //If Cash
                  $data['sub_category_id'] = $request->subcategory_id;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['reamrks'] = $request->reamrks;
                  $data['status'] = $request->status;
                  $data['bank_id'] = '';
                  $data['chaque_no'] = '';
              }else{
                  //If Bank
                  $data['sub_category_id'] = $request->subcategory_id;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['bank_id'] = $request->bank_id;
                  $data['chaque_no'] = $request->chaque_no;
                  $data['status'] = $request->status;
                  $data['reamrks'] = $request->reamrks;
              }
              DB::table('tbl_expense')
                      ->where('expense_id', $request->expense_id)
                      ->update($data);
             echo json_encode("Successfully update");
        }else{
            if($request->payment_type=="cash"){
                  //If Cash
                  $data['sub_category_id'] = $request->subcategory_id;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['reamrks'] = $request->reamrks;
                  $data['status'] = $request->status;
                  $data['bank_id'] = '';
                  $data['chaque_no'] = '';
              }else{
                  //If Bank
                  $data['sub_category_id'] = $request->subcategory_id;
                  $data['payment_type'] = $request->payment_type;
                  $data['payment_date'] = date("Y-m-d",strtotime($request->payment_date));
                  $data['amount'] = $request->amount;
                  $data['bank_id'] = $request->bank_id;
                  $data['chaque_no'] = $request->chaque_no;
                  $data['status'] = $request->status;
                  $data['reamrks'] = $request->reamrks;
              }
              DB::table('tbl_expense')->insert($data);
              echo json_encode("Successfully Save");
        }
    }
    public function SaveExpenseCat(Request $request){
         $data = array();
        if (!empty($request->sub_category_id)) {
            $data['sub_category_id'] = $request->sub_category_id;
            $data['sub_category_name'] = $request->sub_category_name;
            $data['status'] = $request->status;
            DB::table('tbl_sub_exp_category')
                    ->where('sub_category_id', $request->sub_category_id)
                    ->update($data);
            return redirect('/admin/expense');
        } else {
            $data = array();
            $data['sub_category_name'] = $request->sub_category_name;
            $data['status'] = $request->status;
            DB::table('tbl_sub_exp_category')->insert($data);
            return redirect('/admin/expense');
        }
    }
    public function updateOpeningBalance(Request $request) {
      //  $this->AuthCheck();
        $data = array();
        $data['openinig_balance_comments'] = $request->openinig_balance_comments;
        $data['openinig_balance'] = $request->openinig_balance;
        $data['openinig_balance_date'] = date("Y-m-d");
        DB::table('tbl_setting')
                ->where('setting_id', $request->setting_id)
                ->update($data);
        Session::put('update_msg', 'Successfully Update');
        return redirect('/admin/opening-balance');
    }
}