<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Category as myCategory;
//session_start();

class Category extends Controller
{

    public function addCategory()
    {
        $this->AuthCheck();
        $data = DB::table('tbl_category')->orderBy('category_id', 'asc');
        return view('admin.pages.category.categorylist', compact('data'));
    }

    public function addsubCategory()
    {

        $this->AuthCheck();
        $data = array();
        $data['data'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc');
        $data['category'] = DB::table('tbl_category')->orderBy('category_id', 'asc')->get();
        return view('admin.pages.category.subcategorylist', $data);
    }

    public function specialCategory()
    {
        $this->AuthCheck();
        $data = array();
        $data['data'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc');
        $data['category'] = DB::table('tbl_category')->orderBy('category_id', 'asc')->get();
        return view('admin.pages.category.specialcategorylist', $data);
    }
    public function addsubinSubCategory()
    {

        $this->AuthCheck();
        $data = array();
        $data['category'] = DB::table('tbl_category')->orderBy('category_id', 'asc')->get();
        $data['sub_cat'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc')->get();
        return view('admin.pages.category.inSubategorylist', $data);
    }

    public function searchByCatList(Request $request)
    {
    $text = $request->get('query');
    $data= myCategory::categoryList($text);
    $total_row = count($data);
    $sl = 1;
    $output='';
    if ($total_row > 0) {
        foreach ($data as $row) {
            $status = $row->status;
            if ($status == 0) {
                $status = 'Inactive';
            } else {
                $status = 'Active';
            }
            $role_id = Session::get('role_id');
            if ($role_id == 1) {
                $link = '<a onclick="getbyId(' . $row->category_id . ')" href="#">Edit</a>';
            } else {
                $link = 'No Edit';
            }
            $output .= '
    <tr>
        <td>' . $sl . '</td>
        <td>' . $row->category_name . '</td>
        <td>' . $row->sort . '</td>
        <td><img class="img thumbnail" src="' . $row->photo . '" style="height: 50%px; width: 50px;" /></td>
        <td>' . $status . '</td>
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

    public function searchByinSubCatList(Request $request)
    {

        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $text = $request->get('query');
            $data= myCategory::insubcategoryList($text);
            $total_row = count($data);
            //$total_row = $data->count();
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
                    if ($role_id == 1) {
                        $link = '<a onclick="getbyId(' . $row->sub_in_sub_id . ')" href="#">Edit</a>';
                    } else {
                        $link = "No Edit";
                    }
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->category_name . '</td>
            <td>' . $row->sub_cat_name . '</td>
            <td>' . $row->sub_in_sub_cat_name . '</td>
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

    public function searchBySubCatList(Request $request)
    {

        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_subcategory')
                    ->select(DB::raw('tbl_subcategory.photo,tbl_subcategory.sub_cat_id,tbl_category.category_name,tbl_subcategory.sub_cat_name, tbl_subcategory.status'))
                    ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_subcategory.category_id')
                    ->where('tbl_category.category_name', 'like', '%' . $query . '%')
                    ->where('tbl_subcategory.sub_cat_name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_subcategory.status', 'like', '%' . $query . '%')
                    ->orderBy('tbl_subcategory.sub_cat_id', 'asc')
                    ->get();
            } else {
                $data = DB::table('tbl_subcategory')
                    ->select(DB::raw('tbl_subcategory.photo,tbl_subcategory.sub_cat_id,tbl_category.category_name,tbl_subcategory.sub_cat_name, tbl_subcategory.status'))
                    ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_subcategory.category_id')
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
                    if ($role_id == 1) {
                        $link = '<a onclick="getbyId(' . $row->sub_cat_id . ')" href="#">Edit</a>';
                    } else {
                        $link = 'No Edit';
                    }


                    $output .= '
            <tr>
            <td>' . $sl . '</td>
             <td>' . $row->category_name . '</td>
             <td>' . $row->sub_cat_name . '</td>
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

    public function saveCategory(Request $request)
    {
        $this->AuthCheck();
        $data = array();
        if (!empty($request->category_id)) {
            $data['category_id'] = $request->category_id;
            $data['category_name'] = $request->category_name;
            $data['slug'] = $request->slug;
            $data['category_type'] = $request->category_type;
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
                    DB::table('tbl_category')
                        ->where('category_id', $request->category_id)
                        ->update($data);
                }
            }

            DB::table('tbl_category')
                ->where('category_id', $request->category_id)
                ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['category_name'] = $request->category_name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            $data['category_type'] = $request->category_type;
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
                    DB::table('tbl_category')->insert($data);
                }
            }
            DB::table('tbl_category')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function saveSubCategory(Request $request)
    {
        $this->AuthCheck();
        if (!empty($request->sub_cat_id)) {
            $data['category_id'] = $request->category_id;
            $data['sub_cat_name'] = $request->sub_cat_name;
            $data['slug'] = $request->slug;
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
                    DB::table('tbl_subcategory')
                        ->where('sub_cat_id', $request->sub_cat_id)
                        ->update($data);
                }
            }



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
                    DB::table('tbl_subcategory')->insert($data);
                }
            }
            DB::table('tbl_subcategory')->insert($data);


            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function saveSubinSubCategory(Request $request)
    {

        $this->AuthCheck();

        if (!empty($request->sub_in_sub_id)) {
            $data['category_id'] = $request->category_id;
            $data['sub_cat_id'] = $request->sub_cat_id;
            $data['sub_in_sub_cat_name'] = $request->sub_in_sub_cat_name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_sub_in_sub_cat_name')
                ->where('sub_in_sub_id', $request->sub_in_sub_id)
                ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['category_id'] = $request->category_id;
            $data['sub_cat_id'] = $request->sub_cat_id;
            $data['sub_in_sub_cat_name'] = $request->sub_in_sub_cat_name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_sub_in_sub_cat_name')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function searchCategoryRow($categoryId)
    {
        $this->AuthCheck();
        $row = DB::table('tbl_category')
            ->where('category_id', $categoryId)
            ->first();
        echo json_encode($row);
    }

    public function getInSubCategory()
    {
        $sub_cat_id = $_GET['sub_cat_id'];
        $output = DB::table('tbl_sub_in_sub_cat_name')
            ->where('sub_cat_id', $sub_cat_id)
            ->get();
        return json_encode($output);
    }

    public function searchInSubCategoryRow($sub_in_sub_id)
    {

        $this->AuthCheck();
        $row = DB::table('tbl_sub_in_sub_cat_name')
            ->where('sub_in_sub_id', $sub_in_sub_id)
            ->first();
        echo json_encode($row);
    }

    public function searchSubCategoryRow($sub_cat_id)
    {
        $this->AuthCheck();
        $row = DB::table('tbl_subcategory')
            ->where('sub_cat_id', $sub_cat_id)
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
