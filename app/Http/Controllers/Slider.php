<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Slider extends Controller {

    public function index() {

        $this->AuthCheck();
        $data = array();
        return view('admin.pages.slider.sliderlist', $data);
    }

    public function readReview() {
        $this->AuthCheck();
        $data = array();
        $data['review'] = DB::table('tbl_review')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_review.product_id')
                        ->orderBy('review_id', 'desc')->get();
        return view('admin.pages.review.reviewlist', $data);
    }

    public function removeId($id) {
        DB::table('tbl_review')->where('review_id', $id)->delete();
        return redirect('/admin/review-list');
    }

    public function savesliders(Request $request) {

        $this->AuthCheck();
        if (!empty($request->slider_id)) {
            $data = array();
            $data['name'] = $request->name;
            $data['description'] = $request->description;
            $data['status'] = $request->status;
            DB::table('tbl_slider')
                    ->where('slider_id', $request->slider_id)
                    ->update($data);

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
                    DB::table('tbl_slider')
                            ->where('slider_id', $request->slider_id)
                            ->update($data);
                    return redirect('/admin/slider-list');
                }
            }

            return redirect('/admin/slider-list');
        } else {

            $data = array();
            $data['name'] = $request->name;
            $data['description'] = $request->description;
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
                    DB::table('tbl_slider')->insert($data);
                    return redirect('/admin/slider-list');
                }
            }

            DB::table('tbl_slider')->insert($data);
            return redirect('/admin/slider-list');
        }
    }

    public function searchSliderRow($slider_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_slider')
                ->where('slider_id', $slider_id)
                ->first();
        echo json_encode($row);
    }

    public function searchBysliderlist(Request $request) {

        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_slider')
                        ->where('tbl_slider.name', 'like', '%' . $query . '%')
                        ->orWhere('tbl_slider.status', 'like', '%' . $query . '%')
                        ->orderBy('tbl_slider.slider_id', 'desc')
                        ->get();
            } else {
                $data = DB::table('tbl_slider')
                        ->orderBy('tbl_slider.slider_id', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                $x = 1;
                foreach ($data as $row) {
                    $status = $row->status;

                    if ($status == 0) {
                        $status = 'Inactive';
                    } else {
                        $status = 'Active';
                    }

                    $route = 'edit_product';
                    $link = '<a onclick="getbyId(' . $row->slider_id . ')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $x . '</td>
            <td>' . $row->name . '</td>
            <td><img class="img thumbnail" src="' . $row->photo . '" style="height: 100%px; width: 250px;" /></td>
             <td>' . $status . '</td>
             <td>' . $link . '</td>
            </tr>
            ';
                    $x++;
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
