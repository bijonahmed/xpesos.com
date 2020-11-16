<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Customer extends Controller
{
    public function customerlists()
    {
        $this->AuthCheck();
        $data = array();
        return view('admin.pages.customer.customerlist', $data);
    }
    public function customerledger()
    {
        $this->AuthCheck();
        $data = array();
        $data['customer'] = DB::table('tbl_customer')->orderBy('tbl_customer.customer_id', 'asc')->get();
        return view('admin.pages.customer.customerledger', $data);
    }
    public function Customerorder(Request $request)
    {

        if ($request->ajax()) {
            $fromdate = date("Y-m-d", strtotime($request->fdate));
            $todate = date("Y-m-d", strtotime($request->tdate));
            $customer_id = $request->customer_id;

            $report = array();
            $report = DB::table('tbl_order')
                ->select(DB::raw('SUM(tbl_order_details.price) as price,tbl_order.order_id,tbl_order.dvcharge,tbl_order.status,tbl_customer.mobile,tbl_order.order_date,tbl_order.OrderId,tbl_customer.customer_id,tbl_customer.customer_name'))
                ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                ->where('tbl_order.customer_id', $customer_id)
                ->whereBetween('tbl_order.order_date', [$fromdate, $todate])
                ->groupBy('tbl_order_details.order_id')
                ->orderBy('tbl_order.order_id', 'asc')
                ->get();
            echo json_encode($report);
        }

    }
    public function SaveCustomer(Request $request)
    {
        $this->AuthCheck();
        if (!empty($request->customer_id)) {
            // Update
            $data = array();
            $data['customer_id'] = $request->customer_id;
            $data['customer_name'] = $request->customer_name;
            $data['email'] = $request->email;
            $data['mobile'] = $request->mobile;
            $data['address'] = $request->address;
            $data['customer_username'] = $request->customer_username;
            $data['regis_date'] = date("Y-m-d");
            $data['status'] = $request->status;
            DB::table('tbl_customer')
                ->where('customer_id', $request->customer_id)
                ->update($data);
            $msg = array();
            $msg['msg'] = "Successfully Update";
            echo json_encode($msg);
        } else {
            // Insert
            $data = array();
            $data['customer_id'] = $request->customer_id;
            $data['customer_name'] = $request->customer_name;
            $data['email'] = $request->email;
            $data['mobile'] = $request->mobile;
            $data['address'] = $request->address;
            $data['customer_username'] = $request->customer_username;
            $data['customer_password'] = md5($request->customer_password);

            $data['regis_date'] = date("Y-m-d");
            $data['status'] = $request->status;
            DB::table('tbl_customer')->insert($data);
            $msg = array();
            $msg['msg'] = "Successfully Save";
            echo json_encode($msg);

        }
    }
    public function customerlist(Request $request)
    {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_customer')
                    ->where('tbl_customer.customer_name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_customer.email', 'like', '%' . $query . '%')
                    ->orWhere('tbl_customer.mobile', 'like', '%' . $query . '%')
                    ->orWhere('tbl_customer.address', 'like', '%' . $query . '%')
                    ->orderBy('tbl_customer.customer_id', 'asc')
                    ->get();
            } else {
                $data = DB::table('tbl_customer')
                    ->orderBy('tbl_customer.customer_id', 'asc')
                    ->get();
            }
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $status = $row->status;
                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }
                    $value = $row->customer_id;
                    $name = $row->customer_name ? $row->customer_name : 'N/A';
                    $email = $row->email ? $row->email : 'N/A';
                    $link = '<a onclick="getbyId(' . $row->customer_id . ')" href="#">Edit</a>';
                    //$link = '<a onclick="getbyId('.$row->post_id.')" href="#">Edit</a>';
                    $date = date('d-m-Y', strtotime($row->regis_date));
                    $output .= "
            <tr>
            <td> $sl </td>
            <td> $name </td>
            <td> $email </td>
            <td> $row->mobile </td>
            <td> $date </td>
            <td> $status </td>
            <td> $link </td>
            </tr>
            ";
                    $sl++;
                }

                $output = "
                <tr>
                 cccc
                </tr>
                ";

            } else {
                $output = "
           <tr>
            <td>No Data Found</td>
           </tr>
           ";
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        }
    }
    public function searchCustomer($customer_id)
    {
        $this->AuthCheck();
        $row = DB::table('tbl_customer')
            ->where('customer_id', $customer_id)
            ->first();
        echo json_encode($row);
    }
    public function AuthCheck()
    {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }
}
