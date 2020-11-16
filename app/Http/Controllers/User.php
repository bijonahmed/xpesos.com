<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
//session_start();
class User extends Controller
{
    public function rolelist()
    {
        $this->AuthCheck();
        $data = array();
        $data['data'] = DB::table('tbl_user_role')->get();
        return view('admin.pages.user.rolelist', $data);
    }
    public function addUser()
    {
          $this->AuthCheck();
          $data = array();
          $data['data'] = DB::table('tbl_user')->orderBy('user_id', 'desc')->paginate(10);
          $data['role'] = DB::table('tbl_user_role')->get();
          return view('admin.pages.user.userlist', $data);
    }
    public function changePassword(Request $request){
        $this->AuthCheck();
        if (!empty($request->user_id)) {
            $data=array();
            $data['user_id'] = $request->user_id;
            if(!empty($request->password)){
                $data['password'] = md5($request->password);
              }
              DB::table('tbl_user')
              ->where('user_id', $request->user_id)
              ->update($data);
          $success = "Successfully Update Password";
          echo json_encode($success);
        }
    }
    public function saveUser(Request $request)
    {
          $this->AuthCheck();
        if (!empty($request->userid)) {
            $data['user_id'] = $request->userid;
            $data['name'] = $request->name;
            $data['company'] = $request->company;
            $data['email'] = $request->email;
            $data['mobile'] = $request->mobile;
            $data['username'] = $request->username;
            $data['company_slug'] = $request->slug;
            $data['update_at']=NOW();
            $data['created_at']='';
            $data['role_id'] = $request->role_id;
            $data['status'] = $request->status;
 
            $user_pic = $request->file('user_pic');
            if (!empty($user_pic)) {
                $iamgeName = str_random(20);
                $ext = strtolower($user_pic->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $user_pic->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $user_pic = $imageUrl;
                    $img = substr($user_pic, 6);
                    $data['user_pic'] = $img;
                    DB::table('tbl_user')
                    ->where('user_id', $request->userid)
                    ->update($data);
                    return redirect('/admin/user-list');
                }
            }

            DB::table('tbl_user')
                ->where('user_id', $request->userid)
                ->update($data);
                return redirect('/admin/user-list');
            // $success = "Successfully Update";
            // echo json_encode($success);
        } else {
            $data = array();
            $data['name'] = $request->name;
            $data['mobile'] = $request->mobile;
            $data['company_slug'] = $request->slug;
            $data['email'] = $request->email;
            $data['username'] = $request->username;
            $data['date']= date("Y-m-d");
            $data['created_at']=NOW();
            $data['update_at']='';
            $data['company'] = $request->company;
            $data['role_id'] = $request->role_id;
            $data['status'] = $request->status;
            $data['password'] = md5($request->password);
            $user_pic = $request->file('user_pic');

            if (!empty($user_pic)) {
                $iamgeName = str_random(20);
                $ext = strtolower($user_pic->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $user_pic->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $user_pic = $imageUrl;
                    $img = substr($user_pic, 6);
                    $data['user_pic'] = $img;
                    DB::table('tbl_user')->insert($data);
                    return redirect('/admin/user-list');
                }
            }

            DB::table('tbl_user')->insert($data);
            return redirect('/admin/user-list');
            // $success = "Successfully Save";
            // echo json_encode($success);
        }
    }
    public function userFetch_data(Request $request)
    {
        $this->AuthCheck();
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('tbl_user')
                ->where('user_id', 'like', '%' . trim($query) . '%')
                ->orWhere('name', 'like', '%' . trim($query) . '%')
                ->orWhere('phoneNumber', 'like', '%' . trim($query) . '%')
                ->orderBy($sort_by, $sort_type)
                ->paginate(10);
            return view('admin.pages.user.search_user_data', compact('data'))->render();
        }
    }
    public function searchUserRow($user_id)
    {
              $this->AuthCheck();
              $row = DB::table('tbl_user')
                  ->where('user_id', $user_id)
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
