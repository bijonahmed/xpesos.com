<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Employee extends Controller {
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ Department ++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function departmentlist() {
        $this->AuthCheck();
        $data = array();
        return view('admin.pages.employee.departmentlist', $data);
    }
    public function SaveDepartment(Request $request) {
        $this->AuthCheck();
        if (!empty($request->dpt_id)) {
            $data = array();
            $data['dpt_id'] = $request->dpt_id;
            $data['dpt_name'] = $request->dpt_name;
            $data['status'] = $request->status;
            DB::table('tbl_deparmtnet')
                    ->where('dpt_id', $request->dpt_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['dpt_name'] = $request->dpt_name;
             $data['status'] = $request->status;
            DB::table('tbl_deparmtnet')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }
    public function searchByProductId($product_id) {
        $data = array();
        $data['category'] = DB::table('tbl_category')->orderBy('category_id', 'asc')->get();
        $data['subcategory'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc')->get();
        $data['subincategory'] = DB::table('tbl_sub_in_sub_cat_name')->orderBy('sub_in_sub_id', 'asc')->get();
        $data['data'] = DB::table('tbl_product')->where('product_id', $product_id)->orderBy('product_id', 'asc')->first();
        return view('admin.pages.product.editproduct', $data);
    }
    public function departmentslist(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_deparmtnet')
                        ->where('tbl_deparmtnet.dpt_name', 'like', '%' . $query . '%')
                        ->orderBy('tbl_deparmtnet.dpt_id', 'asc')
                        ->get();
            } else {
                $data = DB::table('tbl_deparmtnet')
                        ->orderBy('tbl_deparmtnet.dpt_id', 'desc')
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
                    $value = $row->dpt_id;
                    $link = '<a onclick="getbyId(' . $row->dpt_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->dpt_name . '</td>
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
    public function searchbydptname($dptname){
         $check = DB::table('tbl_deparmtnet')
                ->where('tbl_deparmtnet.dpt_name', $dptname) //check mobile
                ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
   
  public function searchDptId($dpt_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_deparmtnet')
                ->where('dpt_id', $dpt_id)
                ->first();
        echo json_encode($row);
    }
    
    
     public function searchDesigantionId($designation_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_designation')
                ->where('designation_id', $designation_id)
                ->first();
        echo json_encode($row);
    }

    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ Designation ++++++++++++++++++++++++++++++++++++++++++++++++++++
     public function designationlist() {
        $this->AuthCheck();
        $data = array();
        return view('admin.pages.employee.designationlist', $data);
    }
    
   public function SaveDesignation(Request $request) {
        $this->AuthCheck();
        if (!empty($request->designation_id)) {
            $data = array();
            $data['designation_id'] = $request->designation_id;
            $data['designation_name'] = $request->designation_name;
            $data['status'] = $request->status;
            DB::table('tbl_designation')
                    ->where('designation_id', $request->designation_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['designation_name'] = $request->designation_name;
            $data['status'] = $request->status;
            DB::table('tbl_designation')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }
    public function desigantionlist(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_designation')
                        ->where('tbl_designation.designation_name', 'like', '%' . $query . '%')
                        ->orderBy('tbl_designation.designation_id', 'asc')
                        ->get();
            } else {
                $data = DB::table('tbl_designation')
                        ->orderBy('tbl_designation.designation_id', 'desc')
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
                    $value = $row->designation_id;
                    $link = '<a onclick="getbyId(' . $row->designation_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->designation_name . '</td>
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
     public function searchbydesignationname($dname){
         $check = DB::table('tbl_designation')
                ->where('tbl_designation.designation_name', $dname) //check mobile
                ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ Employee List +++++++++++++++++++++++++++++++++++++++++++++
    
    public function employeelist(){
        $this->AuthCheck();
        $data = array();
        $data['designation'] = DB::table('tbl_designation')->orderBy('tbl_designation.designation_id', 'desc')->get();
        $data['department'] = DB::table('tbl_deparmtnet')->orderBy('tbl_deparmtnet.dpt_id', 'desc')->get();
        return view('admin.pages.employee.employeelist', $data);
        
    }
    
    public function SaveEmployee(Request $request) {
        $this->AuthCheck();
        $data = array();
        if (!empty($request->employeeid)) {
            $data['employeeid'] = $request->employeeid;
            $data['employeename'] = $request->employeename;
            $data['address'] = $request->address;
            $data['email'] = $request->email;
            $data['mobile'] = $request->mobile;
            $data['joindate'] = date("Y-m-d",strtotime($request->joindate));
            $data['salary'] = $request->salary;
            $data['dpt_id'] = $request->dpt_id;
            $data['designation_id'] = $request->designation_id;
            $data['status'] = $request->status;

            $photo = $request->file('photo');
            if (!empty($photo)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo = $imageUrl;
                    $img = substr($photo, 6);
                    $data['photo'] = $img;
                    DB::table('tbl_employee')
                            ->where('employeeid', $request->employeeid)
                            ->update($data);
                }
            }

            DB::table('tbl_employee')
                    ->where('employeeid', $request->employeeid)
                    ->update($data);
         $success = "Successfully Update";
           // return reidrect("admin/employee-list");
         echo json_encode($success);
        } else {
            $data = array();
            $data['employeeid'] = $request->employeeid;
            $data['employeename'] = $request->employeename;
            $data['address'] = $request->address;
            $data['email'] = $request->email;
            $data['mobile'] = $request->mobile;
            $data['joindate'] = date("Y-m-d",strtotime($request->joindate));
            $data['salary'] = $request->salary;
            $data['dpt_id'] = $request->dpt_id;
            $data['designation_id'] = $request->designation_id;
            $data['status'] = $request->status;
            
            $photo = $request->file('photo');
            if (!empty($photo)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo = $imageUrl;
                    $img = substr($photo, 6);
                    $data['photo'] = $img;
                    DB::table('tbl_employee')->insert($data);
                }
            }else{
                 DB::table('tbl_employee')->insert($data);
          
            //return reidrect("admin/employee-list");
            //return redirect('/auth')->send();
            }
            $success = "Successfully Save";
            echo json_encode($success);
           
        }
    }
    
    public function employeelistInfo(Request $request){
        
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_employee')
                        ->where('tbl_employee.employeename', 'like', '%' . $query . '%')
                        ->orwhere('tbl_employee.email', 'like', '%' . $query . '%')
                        ->orwhere('tbl_employee.mobile', 'like', '%' . $query . '%')
                        ->orderBy('tbl_employee.employeeid', 'asc')
                        ->get();
            } else {
                $data = DB::table('tbl_employee')
                        ->orderBy('tbl_employee.employeeid', 'desc')
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
                    $value = $row->employeeid;
                    $link = '<a onclick="getbyId(' . $row->employeeid . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->employeename . '</td>
            <td>' . $row->mobile . '</td>
            <td>' . $row->salary . '</td>
            <td><img class="img thumbnail" src="' . $row->photo . '" style="height: 50%px; width: 50px;" /></td>
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
     public function searchbyMobile($mobile){
         $check = DB::table('tbl_employee')
                ->where('tbl_employee.mobile', $mobile) //check mobile
                ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    
    public function searchemployeeId($employeeid){
         $this->AuthCheck();
        $row = DB::table('tbl_employee')
                ->where('employeeid', $employeeid)
                ->first();
        echo json_encode($row);
    }
    
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ salarylist +++++++++++++++++++++++++++++++++++++++++++++++++
    
    public function salarylist(){
        
        $this->AuthCheck();
        $data = array();
        $data['employeelist'] = DB::table('tbl_employee')
                ->where('status', 1)
                ->get();
   
        return view('admin.pages.employee.salarylist', $data);
        
    }
    
    
    public function createSlarySheet(Request $request){
        $this->CheckSalaryDate(date("Y-m-d",strtotime($request->pay_date)));
        $employeeid = $request->employeeid;
        foreach ($employeeid as $empid) {
                 $data['pay_date']= date("Y-m-d",strtotime($request->pay_date));
                 $data['employeeid']= $empid;
                 $data['month']= date("m",strtotime($request->pay_date));;
                 DB::table('tbl_salary')->insert($data);
        }
         return redirect('/admin/salary-list');
        
    }
    
    public function CheckSalaryDate($chkdate){
            $checkdate= DB::table('tbl_salary')->where('pay_date', $chkdate)->first();
           // echo $checkdate->pay_date;exit;
            if(!empty($checkdate->pay_date)){
                DB::table('tbl_salary')->where('pay_date', $checkdate->pay_date)->delete();
            }
    }
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ SlarySheetInfo ++++++++++++++++++++++++++++++++++++++++++++++++++++
     public function SlarySheetInfo(Request $request){
        
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_salary')
                        ->where('tbl_salary.employeeid', 'like', '%' . $query . '%')
                        ->orwhere('tbl_employee.employeename', 'like', '%' . $query . '%')
                         ->orwhere('tbl_employee.mobile', 'like', '%' . $query . '%')
                        ->leftJoin('tbl_employee', 'tbl_employee.employeeid', '=', 'tbl_salary.employeeid')
                        ->orderBy('tbl_salary.salary_id', 'asc')
                        ->get();
            } else {
                $data = DB::table('tbl_salary')
                        ->leftJoin('tbl_employee', 'tbl_employee.employeeid', '=', 'tbl_salary.employeeid')
                        ->orderBy('tbl_salary.salary_id', 'asc')
                        ->get();
            }
            
            $total_row = $data->count();
            $sl = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $value = $row->employeeid;
                    $link = '<a onclick="getbyId(' . $row->employeeid . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
             <td>' . date("Y-M",strtotime($row->pay_date)) . '</td>
            <td>' . $row->employeename . '</td>
            <td>' . $row->mobile . '</td>
            <td>' . $row->salary . '</td>
         
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
    
    
    public function AuthCheck() {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }
}
