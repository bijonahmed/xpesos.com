<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Session;
//session_start();
class Menu extends Controller
{
    public function saveMenu(Request $request){

        $this->AuthCheck();
        if (!empty($request->menu_id)) {
            $data['menu_id'] = $request->menu_id;
            $data['name'] = $request->name;
            $data['sort'] = $request->sort;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_menu')
                    ->where('menu_id', $request->menu_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['name'] = $request->name;
            $data['sort'] = $request->sort;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_menu')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function saveSubMenu(Request $request){
        $this->AuthCheck();
        if (!empty($request->sub_menu_id)) {
            $data['sub_menu_id'] = $request->sub_menu_id;
            $data['menu_id'] = $request->menu_id;
            $data['name'] = $request->name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            $data['address'] = $request->address;
            $data['contact'] = $request->contact;
            DB::table('tbl_sub_menu')
                    ->where('sub_menu_id', $request->sub_menu_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['name'] = $request->name;
            $data['menu_id'] = $request->menu_id;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            $data['address'] = $request->address;
            $data['contact'] = $request->contact;
            DB::table('tbl_sub_menu')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }

    }

    public function saveSubMenuin(Request $request){
        $this->AuthCheck();
        if (!empty($request->sub_in_sub_id)) {
            $data['sub_menu_id'] = $request->sub_menu_id;
            $data['name'] = $request->name;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_sub_in')
                    ->where('sub_in_sub_id', $request->sub_in_sub_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['name'] = $request->name;
            $data['sub_menu_id'] = $request->sub_menu_id;
            $data['slug'] = $request->slug;
            $data['status'] = $request->status;
            DB::table('tbl_sub_in')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function menulist() {
        $this->AuthCheck();
        $data = array();
        return view('admin.pages.menu.menulist', $data);
    }

    public function subMenulist() {
        $this->AuthCheck();
        $data = array();
        $data['menu'] = DB::table('tbl_menu')->orderBy('menu_id', 'asc')->get();
        return view('admin.pages.menu.subMenulist', $data);
    }

    public function subMenuinlist(){
        $this->AuthCheck();
        $data = array();
        $data['menu'] = DB::table('tbl_menu')->orderBy('menu_id', 'asc')->get();
        $data['submenu'] = DB::table('tbl_sub_menu')->orderBy('sub_menu_id', 'asc')->get();
        return view('admin.pages.menu.subMenuinlist', $data);

    }

    public function searchBySubMenuInList(Request $request){
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_sub_in')
                    ->select(DB::raw('tbl_menu.name as mmenu, tbl_sub_menu.name as submenu, tbl_sub_in.name,tbl_sub_in.status,tbl_sub_in.sub_in_sub_id, tbl_sub_in.slug'))
                    ->join('tbl_sub_menu', 'tbl_sub_menu.sub_menu_id', '=', 'tbl_sub_in.sub_menu_id')
                    ->join('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_sub_menu.menu_id')
                    ->where('tbl_sub_in.name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_sub_in.status', 'like', '%' . $query . '%')
                    ->orderBy('tbl_sub_in.sub_in_sub_id', 'asc')
                    ->get();

            } else {
                $data = DB::table('tbl_sub_in')
                ->select(DB::raw('tbl_menu.name as mmenu, tbl_sub_menu.name as submenu, tbl_sub_in.name,tbl_sub_in.status,tbl_sub_in.sub_in_sub_id, tbl_sub_in.slug'))
                ->join('tbl_sub_menu', 'tbl_sub_menu.sub_menu_id', '=', 'tbl_sub_in.sub_menu_id')
                ->join('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_sub_menu.menu_id')
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

            $link = '<a onclick="getbyId('.$row->sub_in_sub_id.')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
             <td>' . $row->mmenu . '</td>
             <td>' . $row->submenu . '</td>
             <td>' .  $row->name . '</td>
             <td>' .  $row->slug . '</td>
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

    public function searchByMenuList(Request $request){

        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_menu')
                    ->where('tbl_menu.name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_menu.status', 'like', '%' . $query . '%')
                    ->orderBy('tbl_menu.menu_id', 'asc')
                    ->get();

            } else {
                $data = DB::table('tbl_menu')
                ->orderBy('tbl_menu.menu_id', 'desc')
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

            $link = '<a onclick="getbyId('.$row->menu_id.')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
             <td>' . $row->name . '</td>
             <td>' . $row->slug . '</td>
             <td>' .  $row->sort . '</td>
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

    public function searchBySubMenuList(Request $request){
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_sub_menu')
                    ->select(DB::raw('tbl_sub_menu.slug, tbl_sub_menu.name, tbl_menu.name as menu_name, tbl_sub_menu.status, tbl_sub_menu.sub_menu_id'))
                    ->join('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_sub_menu.menu_id')
                    ->where('tbl_sub_menu.name', 'like', '%' . $query . '%')
                    ->orWhere('tbl_sub_menu.status', 'like', '%' . $query . '%')
                    ->orderBy('tbl_sub_menu.sub_menu_id', 'asc')
                    ->get();

            } else {
                $data = DB::table('tbl_sub_menu')
                ->select('tbl_sub_menu.slug','tbl_sub_menu.name','tbl_menu.name as menu_name', 'tbl_sub_menu.status', 'tbl_sub_menu.sub_menu_id','tbl_menu.name as mname')
                ->join('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_sub_menu.menu_id')
                ->orderBy('tbl_sub_menu.sub_menu_id', 'desc')
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

            $link = '<a onclick="getbyId('.$row->sub_menu_id.')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
             <td>' . $row->menu_name . '</td>
             <td>' . $row->name . '</td>
             <td>' . $row->slug . '</td>
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



    public function searchByMenuRow($menu_id){
        $this->AuthCheck();
        $row = DB::table('tbl_menu')
                ->where('menu_id', $menu_id)
                ->first();
        echo json_encode($row);
    }

    public function searchBySubMenuRow($sub_menu_id){
        $this->AuthCheck();
        $row = DB::table('tbl_sub_menu')
                ->where('sub_menu_id', $sub_menu_id)
                ->first();
        echo json_encode($row);


    }

    public function searchBySubMenuinRow($sub_in_sub_id){
        $this->AuthCheck();
        $row = DB::table('tbl_sub_in')
        ->where('sub_in_sub_id', $sub_in_sub_id)
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