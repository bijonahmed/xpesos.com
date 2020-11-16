<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Supplier extends Controller {

    public function supplierlists() {
        $this->AuthCheck();
        $data = array();
        return view('admin.pages.supplier.supplierlist', $data);
    }

    public function supplierInvoicelist() {
        $this->AuthCheck();
        $data = array();
        $data['customer'] = DB::table('tbl_supplier')->orderBy('tbl_supplier.supplier_id', 'asc')->get();
        return view('admin.pages.supplier.supplierInvoicelist', $data);
    }
    
     public function vendorledger() {
        $this->AuthCheck();
        $data = array();
        $data['vendor']= DB::table('tbl_supplier')->orderBy('tbl_supplier.supplier_id', 'asc')->get();
        return view('admin.pages.supplier.vendorledger', $data);
    }

      public function VendorPurchaseInvoice(Request $request){
        
        if ($request->ajax()) {
            $fromdate = date("Y-m-d",strtotime($request->fdate));
            $todate = date("Y-m-d",strtotime($request->tdate));
            $supplier_id= $request->supplier_id;
            
        $report=array();
        $report=  DB::select( DB::raw("SELECT tbl_supplier_invoice_one.due,tbl_supplier_invoice_one.total_amt,tbl_supplier_invoice_one.invoice_date,tbl_supplier_invoice_one.supp_Invoice_id,tbl_supplier.supplier_name FROM tbl_supplier_invoice_one 
                  LEFT JOIN tbl_supplier ON tbl_supplier.supplier_id=tbl_supplier_invoice_one.supplier_id
                  WHERE 1 AND tbl_supplier_invoice_one.supplier_id = '$supplier_id' 
                  AND (invoice_date BETWEEN '$fromdate' AND '$todate') ORDER BY tbl_supplier_invoice_one.supplier_invoice_id DESC ") );
            echo json_encode($report);
        }
        
    }

    public function searchInvoice($supplier_id) {
        //echo $supplier_id;exit;
        $this->AuthCheck();
        $data = array();
        $data['setting'] = DB::table('tbl_setting')->first();
        $data['item'] = DB::table('tbl_item')
                        ->select(DB::raw('tbl_item.item_id,tbl_product.product_name,tbl_product.product_code'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->orderBy('tbl_item.item_id', 'asc')->get();
        $data['supplider_row'] = DB::table('tbl_supplier')->where('supplier_id', $supplier_id)->orderBy('tbl_supplier.supplier_id', 'asc')->first();
        $data['title'] = $data['supplider_row']->supplier_name;
        return view('admin.pages.supplier.supplierInvoice', $data);
    }

    public function customerledger() {
        $this->AuthCheck();
        $data = array();
        $data['customer'] = DB::table('tbl_customer')->orderBy('tbl_customer.customer_id', 'asc')->get();
        return view('admin.pages.customer.customerledger', $data);
    }

    public function PrintSupplierInvoice($supplier_invoice_id) {

        $supplier_id = DB::table('tbl_supplier_invoice_one')->where('supplier_invoice_id', $supplier_invoice_id)->first();
        $this->AuthCheck();
        $data = array();
        $data['title'] = "Print Invoice";
        $data['setting'] = DB::table('tbl_setting')->first();
        $data['supplier_invoice_id'] = $supplier_invoice_id;
        $data['supp_Invoice_id'] = $supplier_id->supp_Invoice_id;
        $data['grand_total'] = $supplier_id->grand_total;
        $data['shipping_cost'] = $supplier_id->shipping_cost;
        $data['total_amt'] = $supplier_id->total_amt;
        $data['advance'] = $supplier_id->advance;
        $data['due'] = $supplier_id->due;
        $data['supplider_row'] = DB::table('tbl_supplier')->where('supplier_id', $supplier_id->supplier_id)->orderBy('tbl_supplier.supplier_id', 'asc')->first();
        $data['item'] = DB::table('tbl_item')
                        ->select(DB::raw('tbl_item.item_id,tbl_product.product_name,tbl_product.product_code'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->orderBy('tbl_item.item_id', 'asc')->get();
        return view('admin.pages.supplier.printinvoice', $data);
    }

    public function getInvoiceEdit($supplier_invoice_id) {
        //echo $supplier_invoice_id;
        $supplier_id = DB::table('tbl_supplier_invoice_one')->where('supplier_invoice_id', $supplier_invoice_id)->first();
        $this->AuthCheck();
        $data = array();
        $data['title'] = "Edit Invoice - $supplier_id->supp_Invoice_id";
        $data['setting'] = DB::table('tbl_setting')->first();
        $data['supplier_invoice_id'] = $supplier_invoice_id;
        $data['supp_Invoice_id'] = $supplier_id->supp_Invoice_id;
        $data['manual_sp_invoice_id'] = $supplier_id->manual_sp_invoice_id;
        $data['grand_total'] = $supplier_id->grand_total;
        $data['shipping_cost'] = $supplier_id->shipping_cost;
        $data['total_amt'] = $supplier_id->total_amt;
        $data['advance'] = $supplier_id->advance;
        $data['due'] = $supplier_id->due;
        $data['supplider_row'] = DB::table('tbl_supplier')->where('supplier_id', $supplier_id->supplier_id)->orderBy('tbl_supplier.supplier_id', 'asc')->first();
        $data['item'] = DB::table('tbl_item')
                        ->select(DB::raw('tbl_item.item_id,tbl_product.product_name,tbl_product.product_code'))
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->orderBy('tbl_item.item_id', 'asc')->get();
        Session::put('supInvoiceId', $supplier_invoice_id);
        return view('admin.pages.supplier.editInvoice', $data);
    }

    public function Customerorder(Request $request) {

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

    public function UpdateInvoiceParticular(Request $request) {
        $data = array();
        $data['supp_Invoice_id'] = $request->supp_Invoice_id;
        $data['manual_sp_invoice_id'] = $request->manual_sp_invoice_id;
        $data['grand_total'] = $request->grand_total;
        $data['shipping_cost'] = $request->shipping_cost;
        $data['advance'] = $request->advance;
        $data['total_amt'] = $request->total_amt;
        $data['due'] = $request->due;

        DB::table('tbl_supplier_invoice_one')
                ->where('supp_Invoice_id', $request->supp_Invoice_id)
                ->update($data);
        return redirect('/admin/supplier/editSupplierInvoice/' . $request->supp_Invoice_id);
    }

    public function SaveInvoice(Request $request) {
        $data = array();
        $data['supplier_id'] = $request->supplier_id;
        $data['status'] = '1'; //
        $data['invoice_date'] = date("Y-m-d");
        $data['manual_sp_invoice_id'] = $request->manual_sp_invoice_id;
        $data['grand_total'] = $request->grand_total;
        $data['shipping_cost'] = $request->shipping_cost;
        $data['advance'] = $request->advance;
        $data['total_amt'] = $request->total_amt;
        $data['due'] = $request->due;
        $last_id = DB::table('tbl_supplier_invoice_one')->insertGetId($data);
        $supplier_invoice_id = sprintf("%06d", $last_id);

        $sdata = array();
        $sdata['supp_Invoice_id'] = $supplier_invoice_id;
        DB::table('tbl_supplier_invoice_one')
                ->where('supplier_invoice_id', $last_id)
                ->update($sdata);

        // Remove Temp Data
        $user_id = Session::get('user_id');
        DB::table('tbl_invoice_draft')->where('user_id', $user_id)->delete();

        $itemid = $request->itemid;
        $qnty = $request->qnty;
        $rate = $request->rate;
        $total = $request->total;

        $temp = count($itemid);
        for ($i = 0; $i < $temp; $i++) {
            $data2 = array(
                'supplier_invoice_id' => $supplier_invoice_id,
                'item_id' => $itemid[$i],
                'qnty' => $qnty[$i],
                'rate' => $rate[$i],
                'total' => $total[$i],
            );
            DB::table('tbl_supplier_invoice_two')->insert($data2);
 
        }

        return redirect('/admin/supplier/supplier-invoice/' . $request->supplier_id);
    }

    public function UpdateSupplierInvoice(Request $request) {
        $suppdata = array();
        $supInvoiceId = Session::get('supInvoiceId');
        $suppdata['supplier_invoice_id'] = $supInvoiceId;
        $suppdata['item_id'] = $request->item_id;
        $suppdata['qnty'] = $request->qnty;
        $suppdata['rate'] = $request->rate;
        $suppdata['total'] = $request->total;
        DB::table('tbl_supplier_invoice_two')->insert($suppdata);
        $msg = array();
        $msg['msg'] = "Successfully Save";
        echo json_encode($msg);
    }

    public function SaveSupplierInvoice(Request $request) {
        $suppdata = array();
        $suppdata['user_id'] = Session::get('userid');
        $suppdata['item_id'] = $request->item_id;
        $suppdata['qnty'] = $request->qnty;
        $suppdata['rate'] = $request->rate;
        $suppdata['total'] = $request->total;
        DB::table('tbl_invoice_draft')->insert($suppdata);
        $msg = array();
        $msg['msg'] = "Successfully Save";
        echo json_encode($msg);
    }

    public function removeItem() {
        $supId = $_GET['supplier_invoice_id']; //$request->supplier_invoice_id;
        $itemId = $_GET['item_id'];//$request->item_id;
        $this->AuthCheck();
        $data = DB::table('tbl_supplier_invoice_two')->where('supplier_invoice_id', $supId)->where('item_id', $itemId)->delete();
        echo json_encode($data);
    }

    public function EditIteminfobyInvoice(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $supInvoiceId = Session::get('supInvoiceId');
            if ($query == '') {
                $data = DB::table('tbl_supplier_invoice_two')
                        ->select(DB::raw('tbl_item.item_id,tbl_supplier_invoice_two.qnty,tbl_supplier_invoice_two.rate,
                        tbl_supplier_invoice_two.total,tbl_product.product_code,tbl_product.product_name,tbl_supplier_invoice_two.supplier_invoice_id'))
                        //->where('tbl_invoice_draft.user_id', $userid)
                        ->where('tbl_supplier_invoice_two.supplier_invoice_id', $supInvoiceId)
                        ->leftJoin('tbl_item', 'tbl_item.item_id', '=', 'tbl_supplier_invoice_two.item_id')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->get();
            }


            $total_row = $data->count();
            $sl = 1;
            $sum = 0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $sum += $row->total;
                    $link = '<a onclick="editItemListId(' . $row->supplier_invoice_id . ',' . $row->item_id . ')" href="#">Remove Item</a>';
                    $itemId = $row->item_id;
                    $output .= "
            <tr>
            <td><center>" . $sl . "</center></td>
            <td><input type='hidden' name='itemid[]' value='$itemId'/><center>" . $row->product_name . "</center></td>
            <td><input type='hidden' name='qnty[]' value='$row->qnty'/><center>" . $row->qnty . "</center></td>
            <td><input type='hidden' name='rate[]' value='$row->rate'/><center>" . $row->rate . "</center></td>
            <td><input type='hidden' name='total[]' value='$row->total'/><center>" . $row->total . "</center></td>
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

        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');

            if ($query == '') {
                $userid = Session::get('user_id');
                $data = DB::table('tbl_invoice_draft')
                        ->select(DB::raw('tbl_item.item_id,tbl_invoice_draft.qnty,tbl_invoice_draft.rate,tbl_invoice_draft.total,tbl_product.product_code,tbl_product.product_name'))
                        ->where('tbl_invoice_draft.user_id', $userid)
                        ->leftJoin('tbl_item', 'tbl_item.item_id', '=', 'tbl_invoice_draft.item_id')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->get();
         
              
            $total_row = $data->count();
            $sl = 1;
            $sum = 0;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $sum += $row->total;
                    $rowcheck = DB::table('tbl_invoice_draft')
                                    ->where('item_id', $row->item_id)->first();
                    $link = '<a onclick="getbyId(' . $row->item_id . ')" href="#">Remove Item</a>';
                    if (!empty($rowcheck->item_id)) {
                        DB::table('tbl_invoice_draft')->where('item_id', $row->item_id)->delete();
                        $suppdata = array();
                        $suppdata['user_id'] = Session::get('userid');
                        $suppdata['item_id'] = $rowcheck->item_id;
                        $suppdata['qnty'] = $rowcheck->qnty;
                        $suppdata['rate'] = $rowcheck->rate;
                        $suppdata['total'] = $rowcheck->total;
                        DB::table('tbl_invoice_draft')->insert($suppdata);
                    }
                    $itemId = $row->item_id;
                    $output .= "
            <tr>
            <td>" . $sl . "</td>
            <td><input type='hidden' name='itemid[]' value='$itemId'/>" . $row->product_name . "</td>
            <td><input type='hidden' name='qnty[]' value='$row->qnty'/>" . $row->qnty . "</td>
            <td><input type='hidden' name='rate[]' value='$row->rate'/>" . $row->rate . "</td>
            <td><input type='hidden' name='total[]' value='$row->total'/>" . $row->total . "</td>
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
    }

    public function removeItemIdInvoice() {

        $item_id= $_GET['item_id'];
        $this->AuthCheck();
        $data = DB::table('tbl_invoice_draft')->where('item_id', $item_id)->delete();
        echo json_encode($data);
    }

    public function SaveSupplier(Request $request) {
        $this->AuthCheck();
        if (!empty($request->supplier_id)) {
            // Update
            $data = array();
            $data['supplier_id'] = $request->supplier_id;
            $data['supplier_name'] = $request->supplier_name;
            $data['supplier_contact_person_name'] = $request->supplier_contact_person_name;
            $data['supplier_email'] = $request->supplier_email;
            $data['supplier_phone'] = $request->supplier_phone;
            $data['supplier_address'] = $request->supplier_address;
            $data['reamrks'] = $request->reamrks;
            $data['status'] = $request->status;
            DB::table('tbl_supplier')
                    ->where('supplier_id', $request->supplier_id)
                    ->update($data);
            $msg = array();
            $msg['msg'] = "Successfully Update";
            echo json_encode($msg);
        } else {
            // Insert   
            $data = array();

            $data['supplier_name'] = $request->supplier_name;
            $data['supplier_contact_person_name'] = $request->supplier_contact_person_name;
            $data['supplier_email'] = $request->supplier_email;
            $data['supplier_phone'] = $request->supplier_phone;
            $data['supplier_address'] = $request->supplier_address;
            $data['reamrks'] = $request->reamrks;
            $data['status'] = $request->status;
            DB::table('tbl_supplier')->insert($data);
            $msg = array();
            $msg['msg'] = "Successfully Save";
            echo json_encode($msg);
        }
    }

    public function SuppInvoiceList(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_supplier_invoice_one')
                        ->where('tbl_supplier.supplier_name', 'like', '%' . $query . '%')
                        ->orwhere('tbl_supplier_invoice_one.supp_Invoice_id', 'like', '%' . $query . '%')
                        ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_supplier_invoice_one.supplier_id')
                        ->orderBy('tbl_supplier_invoice_one.supplier_invoice_id', 'asc')
                        ->get();
            } else {
                $data = DB::table('tbl_supplier_invoice_one')
                        ->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_supplier_invoice_one.supplier_id')
                        ->orderBy('tbl_supplier_invoice_one.supplier_invoice_id', 'asc')
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
                    $printurl = "supplier/searchSupplierInvoice/" . $row->supplier_invoice_id;
                    $link = '<a onclick="getbyId(' . $row->supplier_invoice_id . ')" href="#">Edit</a>';
                    $Print = '<a href="' . $printurl . '">Print Preview</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->supp_Invoice_id . '</td>
            <td>' . $row->supplier_name . '</td>
            <td>' . $row->invoice_date . '</td>
            <td>' . '৳' . number_format($row->grand_total) . '/=' . '</td>
            <td>' . $status . '</td>
            <td>' . $link . '</td>
            <td>' . $Print . '</td>
            </tr>
            ';
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

    public function supplierlist(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_supplier')
                        ->where('tbl_supplier.supplier_name', 'like', '%' . $query . '%')
                        ->orWhere('tbl_supplier.supplier_contact_person_name', 'like', '%' . $query . '%')
                        ->orWhere('tbl_supplier.supplier_email', 'like', '%' . $query . '%')
                        ->orWhere('tbl_supplier.supplier_phone', 'like', '%' . $query . '%')
                        ->orWhere('tbl_supplier.supplier_address', 'like', '%' . $query . '%')
                        ->orderBy('tbl_supplier.supplier_id', 'asc')
                        ->get();
            } else {
                $data = DB::table('tbl_supplier')
                        ->orderBy('tbl_supplier.supplier_id', 'asc')
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
                    $value = $row->supplier_id;
                    $name = $row->supplier_contact_person_name ? $row->supplier_contact_person_name : 'N/A';
                    $email = $row->supplier_email ? $row->supplier_email : 'N/A';
                    $link = '<a onclick="getbyId(' . $row->supplier_id . ')" href="#">Edit</a>';
                    //$link = '<a onclick="getbyId('.$row->post_id.')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->supplier_name . '</td>
            <td>' . $name . '</td>
            <td>' . $email . '</td>
            <td>' . $row->supplier_phone . '</td>
            <td>' . $row->supplier_address . '</td>
            <td>' . $status . '</td>
            <td>' . $link . '</td>
            </tr>
            ';
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

    public function searchItemId($item_id) {

        $this->AuthCheck();
        $row = DB::table('tbl_item')
                ->where('item_id', $item_id)
                ->first();
        echo json_encode($row);
    }

    public function searchSupplier($supplier_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_supplier')
                ->where('supplier_id', $supplier_id)
                ->first();
        echo json_encode($row);
    }

    public function searchbySupplierMobile($mobile) {

        $check = DB::table('tbl_supplier')
                ->where('tbl_supplier.supplier_phone', $mobile) //check mobile
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