<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Gallery extends Controller {


    public function index() {

        $this->AuthCheck();
        $data=array();
        $data['list'] = DB::table('tbl_gallery')->orderBy('gallery_id', 'asc')->get();
        return view('admin.pages.gallery.gallerylist',$data);
    }



    public function saveGallery(Request $request){


        $this->AuthCheck();
        if (!empty($request->gallery_id)) {
            $data = array();
            $data['name'] = $request->name;
            $data['type'] = $request->type;
            $data['description'] = $request->description;
            $data['video_url'] = $request->video_url;
            $data['status'] = $request->status;
            DB::table('tbl_gallery')
                    ->where('gallery_id', $request->gallery_id)
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
                    $img=substr($photo, 6);
                    $data['photo']=$img;
                    DB::table('tbl_gallery')
                    ->where('gallery_id', $request->gallery_id)
                    ->update($data);
                    return redirect('/admin/gallery-list');
                }
            }

            return redirect('/admin/gallery-list');
        } else {

            $data = array();
            $data['name'] = $request->name;
            $data['type'] = $request->type;
            $data['description'] = $request->description;
            $data['video_url'] = $request->video_url;
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
                    $img=substr($photo, 6);
                    $data['photo']=$img;
                    DB::table('tbl_gallery')->insert($data);
                    return redirect('/admin/gallery-list');
                }
            }

            DB::table('tbl_gallery')->insert($data);
            return redirect('/admin/gallery-list');

        }

    }


    public function searchGalleryRow($gallery_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_gallery')
                ->where('gallery_id', $gallery_id)
                ->first();
        echo json_encode($row);
    }

    public function searchBygallerylist(Request $request){

        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_gallery')
                    ->where('tbl_gallery.name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_gallery.type', 'like', '%' . $query . '%')
                    ->orderBy('tbl_gallery.gallery_id', 'desc')
                    ->get();
            } else {
                $data = DB::table('tbl_gallery')
                ->orderBy('tbl_gallery.gallery_id', 'desc')
                    ->get();
            }


            $total_row = $data->count();
            if ($total_row > 0) {
                $x=1;
                foreach ($data as $row) {
                    $status = $row->status;

                    if($status==0){
                        $status= 'Inactive';
                    }else {
                        $status= 'Active';
                    }

                    $img= $row->photo;
                    $imglink=$img;
                    //$imglink=substr($img, 5);

                   $route = 'edit_product';
            $link = '<a onclick="getbyId('.$row->gallery_id.')" href="#">Edit</a>';
            $output .= '
            <tr>
            <td>' . $x . '</td>
            <td>' . $row->name . '</td>
            <td><img class="img thumbnail" src="' . $imglink . '" style="height: 100%px; width: 250px;" /></td>
            <td>' .  $row->video_url . '</td>
            <td>' .  $status . '</td>
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
