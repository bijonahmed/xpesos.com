<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Post extends Controller {



    public function postlist() {
        $this->AuthCheck();
        $data = array();
        $data['menu'] = DB::table('tbl_menu')->orderBy('menu_id', 'asc')->get();
        $data['submenu'] = DB::table('tbl_sub_menu')->where('tbl_sub_menu.status', 1)->orderBy('sub_menu_id', 'asc')->get();
        $data['in_sub_menu'] = DB::table('tbl_sub_in')->where('tbl_sub_in.status', 1)->orderBy('sub_in_sub_id', 'asc')->get();
        return view('admin.pages.post.postlist', $data);
    }



    public function SavePost(Request $request) {
        $this->AuthCheck();
        //$user_id = Session::get('user_id');
        if (!empty($request->post_id)) {
            $data = array();
            $data['post_title'] = $request->post_title;
            $data['slug'] = $request->slug;
            $data['post_description'] = $request->post_description;
            $data['status'] = $request->status;
            $data['menu_id'] = $request->menu_id;
            $data['sub_menu_id'] = $request->sub_menu_id;
            $data['sub_in_sub_id'] = $request->sub_in_sub_id;
            $data['management_name'] = $request->management_name;
            $data['designation'] = $request->designation;
            $data['entry_date'] = date("Y-m-d");

            DB::table('tbl_post')
                    ->where('post_id', $request->post_id)
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
                    DB::table('tbl_post')
                    ->where('post_id', $request->post_id)
                    ->update($data);
                    return redirect('/admin/post-list');
                }
            }

            return redirect('/admin/post-list');
        } else {

            $data = array();
            $data['post_title'] = $request->post_title;
            $data['slug'] = $request->slug;
            $data['post_description'] = $request->post_description;
            $data['status'] = $request->status;
            $data['menu_id'] = $request->menu_id;
            $data['sub_menu_id'] = $request->sub_menu_id;
            $data['sub_in_sub_id'] = $request->sub_in_sub_id;
            $data['management_name'] = $request->management_name;
            $data['designation'] = $request->designation;
            $data['entry_date'] = date("Y-m-d");
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
                    $post_id= DB::table('tbl_post')->insertGetId($data);


                    return redirect('/admin/post-list');
                }
            }

           $post_id= DB::table('tbl_post')->insertGetId($data);
  

            $slugdata=array();
            $menu_id = $request->menu_id;
            if(!empty($menu_id)){
                $row = DB::table('tbl_menu')->where('menu_id', $menu_id)->first();
                $slugdata['slug']=$row->slug;
                $slugdata['post_id']= $post_id;
                DB::table('tbl_post_slug')->insert($slugdata);
                   
            }
		    $sub_menu_id = $request->sub_menu_id;
            if(!empty($sub_menu_id)){
                $row = DB::table('tbl_sub_menu')->where('sub_menu_id', $sub_menu_id)->first();
                $slugdata['slug']=$row->slug;
                $slugdata['post_id']= $post_id;
                DB::table('tbl_post_slug')->insert($slugdata);
            }
			$sub_in_sub_id = $request->sub_in_sub_id;
            if(!empty($sub_in_sub_id)){
                $row = DB::table('tbl_sub_in')->where('sub_in_sub_id', $sub_in_sub_id)->first();
                $slugdata['slug']=$row->slug;
                $slugdata['post_id']= $post_id;
                DB::table('tbl_post_slug')->insert($slugdata);
            }
            return redirect('/admin/post-list');

        }

    }

    public function searchByPostlist(Request $request){
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_post')
                ->select('tbl_menu.name as mmenu','tbl_sub_in.name as insubmenu','tbl_sub_menu.sub_menu_id', 'tbl_sub_menu.name as submenuName', 'tbl_post.post_id', 'tbl_post.post_title','tbl_post.slug','tbl_post.entry_date','tbl_post.status')
                ->leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_post.menu_id')
                ->leftJoin('tbl_sub_menu', 'tbl_sub_menu.sub_menu_id', '=', 'tbl_post.sub_menu_id')
                ->leftJoin('tbl_sub_in', 'tbl_sub_in.sub_in_sub_id', '=', 'tbl_post.sub_in_sub_id')
                ->where('tbl_post.post_title', 'like', '%' . $query . '%')
                ->orWhere('tbl_post.status', 'like', '%' . $query . '%')
                ->orderBy('tbl_post.post_id', 'asc')
                ->get();

            } else {
                $data = DB::table('tbl_post')
                ->select('tbl_menu.name as mmenu','tbl_sub_in.name as insubmenu','tbl_sub_menu.sub_menu_id', 'tbl_sub_menu.name as submenuName', 'tbl_post.post_id', 'tbl_post.post_title','tbl_post.slug','tbl_post.entry_date','tbl_post.status')
                ->leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_post.menu_id')
                ->leftJoin('tbl_sub_menu', 'tbl_sub_menu.sub_menu_id', '=', 'tbl_post.sub_menu_id')
                ->leftJoin('tbl_sub_in', 'tbl_sub_in.sub_in_sub_id', '=', 'tbl_post.sub_in_sub_id')
                ->orderBy('tbl_post.post_id', 'desc')
                ->get();
            }
            $total_row = $data->count();
            $sl=1;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $status = $row->status;
                    if($status==0){
                        $status= 'Inactive';
                    }else {
                        $status= 'Active';
                    }
                    $value=$row->post_id;

                $link = '<a onclick="getbyId('.$row->post_id.')" href="#">Edit</a>';
            //$link = '<a onclick="getbyId('.$row->post_id.')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
            <td>' . $row->mmenu . '</td>
            <td>' . $row->submenuName . '</td>
            <td>' . $row->insubmenu . '</td>
            <td>' . $row->post_title . '</td>
            <td>' .  date("d-M-Y",strtotime($row->entry_date)) . '</td>
            <td>' .  $status . '</td>
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

    public function getSubMenu(){

        $menu_id = $_GET['menu_id'];
        $output = DB::table('tbl_sub_menu')
                ->where('menu_id', $menu_id)
                ->get();
        return json_encode($output);
    }

    public function searchPostId($post_id){
        $data=array();
        $data['menu'] = DB::table('tbl_menu')->orderBy('menu_id', 'asc')->get();
        $data['submenu'] = DB::table('tbl_sub_menu')->where('tbl_sub_menu.status', 1)->orderBy('sub_menu_id', 'asc')->get();
        $data['in_sub_menu'] = DB::table('tbl_sub_in')->where('tbl_sub_in.status', 1)->orderBy('sub_in_sub_id', 'asc')->get();
        $data['data'] = DB::table('tbl_post')->where('post_id',$post_id)->orderBy('post_id', 'asc')->first();
        return view('admin.pages.post.editpost', $data);
    }

    public function searchPostRow($post_id) {

        $this->AuthCheck();
        $row = DB::table('tbl_post')
                ->where('post_id', $post_id)
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