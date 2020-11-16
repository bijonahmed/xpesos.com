<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Brand extends Controller
{

    public function addBrand()
    {
        $this->AuthCheck();
        $data = DB::table('tbl_brand')->orderBy('brand_id', 'asc');
        return view('admin.pages.brand.brandlist', compact('data'));
    }

     
    public function searchByBrandist(Request $request)
    {
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_brand')
                    ->select(DB::raw('tbl_brand.sort,tbl_brand.photo,tbl_brand.brand_id,tbl_brand.brand_name, tbl_brand.slug, tbl_brand.status'))
                    ->where('tbl_brand.brand_name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_brand.status', 'like', '%' . $query . '%')
                    ->orderBy('tbl_brand.brand_id', 'asc')
                    ->get();
            } else {
                $data = DB::table('tbl_brand')
                    ->select(DB::raw('tbl_brand.sort,tbl_brand.photo,tbl_brand.brand_id,tbl_brand.brand_name, tbl_brand.slug, tbl_brand.status'))
                //->where('status',1)
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
                    $role_id = Session::get('role_id');
		            if($role_id == 1){
                    $link = '<a onclick="getbyId(' . $row->brand_id . ')" href="#">Edit</a>';
                    }else{
                        $link = 'No Edit';
                    }           
       

                    $output .= '
            <tr>
                <td>' . $sl . '</td>
                <td>' . $row->brand_name . '</td>
                <td>' . $row->sort . '</td>
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
 
  

    public function brandCategory(Request $request)
    {
        $this->AuthCheck();
        $data = array();
        if (!empty($request->brand_id)) {
            $data['brand_id'] = $request->brand_id;
            $data['brand_name'] = $request->brand_name;
            $data['slug'] = $request->slug;
            $data['sort'] = $request->sort;
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
                    DB::table('tbl_brand')
                        ->where('brand_id', $request->brand_id)
                        ->update($data);
                }
            }

            DB::table('tbl_brand')
                ->where('brand_id', $request->brand_id)
                ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['brand_name'] = $request->brand_name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            $data['sort'] = $request->sort;
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
                    DB::table('tbl_brand')->insert($data);
                }
            }else{
                DB::table('tbl_brand')->insert($data);
            }
            
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    
 

    public function searchCategoryRow($categoryId)
    {
        $this->AuthCheck();
        $row = DB::table('tbl_brand')
            ->where('brand_id', $categoryId)
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
