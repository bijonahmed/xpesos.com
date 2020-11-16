<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
//session_start();
class Order extends Controller {
    public function index() {
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.orderlist', compact('data'));
    }
    public function ConfirmOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.confirmorderlist', compact('data'));
    }
    public function ShippedOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.shippedorderlist', compact('data'));
    }
    public function CompletedOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.Completeorderlist', compact('data'));
    }
    
    public function HoldOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.Holdorderlist', compact('data'));
    }
    
     public function CancelOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.CancelOrderlist', compact('data'));
    }
    
    public function ReturnOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.ReturnOrderlist', compact('data'));
    }
    
     public function RecivedOrder(){
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.order.RecivedOrderlist', compact('data'));
    }
     
    public function searchbyOrderStatus(Request $request){
        
        $this->AuthCheck();
        if ($request->ajax()) {

            $user_id = Session::get('user_id');
            $role_id = Session::get('role_id');

            $output = '';
            $query = $request->get('query');
            $orderStatus = $request->get('orderStatus');
            if ($query != '') {

             if($role_id == 1){
                $data = DB::table('tbl_order')
                ->select(DB::raw('tbl_user.company,tbl_user.mobile vmobile,tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
                 ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                 ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                 ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                 ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                 ->where('tbl_order.status', $orderStatus)
                 ->where('tbl_order.OrderId', 'like', '%' . $query . '%')
                 ->orWhere('tbl_customer.mobile', 'like', '%' . $query . '%')
                 ->orWhere('tbl_order.order_date', 'like', '%' . $query . '%')
                 ->orderBy('tbl_order.OrderId', 'desc')
                 ->groupby('tbl_order_details.order_id')
                 ->get();

             }else{
                $data = DB::table('tbl_order')
                ->select(DB::raw('tbl_user.company,tbl_user.mobile vmobile,tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
                 ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                 ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                 ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                 ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                 ->where('tbl_product.user_id',$user_id)
                 ->where('tbl_order.status', $orderStatus)
                 ->where('tbl_order.OrderId', 'like', '%' . $query . '%')
                 ->orWhere('tbl_customer.mobile', 'like', '%' . $query . '%')
                 ->orWhere('tbl_order.order_date', 'like', '%' . $query . '%')
                 ->orderBy('tbl_order.OrderId', 'desc')
                 ->groupby('tbl_order_details.order_id')
                 ->get();
             }

            } else {

                if($role_id == 1){
                    $data = DB::table('tbl_order')
                    ->select(DB::raw('tbl_user.company,tbl_user.mobile vmobile,tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
                    ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                    ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                    ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                    ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                    ->where('tbl_order.status', $orderStatus)
                    ->orderBy('tbl_order.OrderId', 'desc')
                    ->groupby('tbl_order_details.order_id')
                    ->get();
                }else{
                    $data = DB::table('tbl_order')
                    ->select(DB::raw('tbl_user.company,tbl_user.mobile vmobile,tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
                    ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
                    ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
                    ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                    ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                    ->where('tbl_product.user_id',$user_id)
                    ->where('tbl_order.status', $orderStatus)
                    ->orderBy('tbl_order.OrderId', 'desc')
                    ->groupby('tbl_order_details.order_id')
                    ->get();

                }

              
            }
            $total_row = $data->count();
            $sl = 1;
            //1= Recived Order,2= Confirm Order, 3= Shipped Order,4= Complete Order,5= Cancel Order, 6= Hold Order.
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
                    } elseif ($status == 7) {
                        $status = 'Return Order';
                    }
                    $link = '<a onclick="getbyId(' . $row->order_id . ')" href="#">&nbsp;<i class="fa fa-file-o"> Invoice</i></a>';
                    $output .= '
            <tr>
             <td>' . $sl . '</td>
             <td>' . $row->company .'('.$row->vmobile .')'. '</td>
             <td>' . $row->OrderId . '</td>
             <td>' . $row->mobile . '</td>
             <td>' . $row->order_date . '</td>
             <td style="background-color:green; color: white;text-align: center;">' . $status . '</td>
             <td>' . $link . '</td>
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
     
function searchbySingleOrder(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {

            $user_id = Session::get('user_id');
            $role_id = Session::get('role_id');

            $output = '';
            $query = $request->get('query');
            if ($query != '') {
 $data = DB::table('tbl_order')
    ->select(DB::raw('tbl_user.company,tbl_user.mobile  as vmobile,tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
     ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
     ->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
     ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
     ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
     ->where('tbl_product.user_id',$user_id)
     ->where('tbl_order.OrderId', 'like', '%' . $query . '%')
     ->orWhere('tbl_customer.mobile', 'like', '%' . $query . '%')
     ->orWhere('tbl_order.order_date', 'like', '%' . $query . '%')
     ->orderBy('tbl_order.OrderId', 'desc')
     ->groupby('tbl_order_details.order_id')
     ->get();               
          } else {
			$today = date("Y-m-d");
			$data = DB::table('tbl_order')
				   ->select(DB::raw('tbl_user.company,tbl_user.mobile as vmobile,tbl_customer.mobile,tbl_order.order_id,tbl_order.order_date,tbl_order.OrderId,tbl_order.status'))
					->leftJoin('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
					->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
					->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
					->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
					->where('tbl_order.order_date', $today)
					->orderBy('tbl_order.OrderId', 'desc')
					->groupby('tbl_order_details.order_id')
					->get();
    }
               
            

            $total_row = $data->count();
            $sl = 1;
            //1= Recived Order,2= Confirm Order, 3= Shipped Order,4= Complete Order,5= Cancel Order, 6= Hold Order.
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
                    } elseif ($status == 7) {
                        $status = 'Return Order';
                    }
   $role_id = Session::get('role_id');
   if($role_id == 1){
    $link = '<a onclick="getbyId(' . $row->order_id . ')" href="#">&nbsp;<i class="fa fa-file-o"> Invoice</i></a>';
   }else{
    $link = '';
   }
                     
                    $output .= '
            <tr>
             <td>' . $sl . '</td>
             <td>' . $row->company .'('.$row->vmobile .')'. '</td>
             <td>' . $row->OrderId . '</td>
             <td>' . $row->order_date . '</td>
             <td style="background-color:green; color: white;text-align: center;">' . $status . '</td>
             <td>' . $link . '</td>
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
        $this->AuthCheck();
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
        $this->AuthCheck();
        $row = DB::table('tbl_category')
                ->where('category_id', $categoryId)
                ->first();
        echo json_encode($row);
    }
    public function AuthCheck() {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }
}
