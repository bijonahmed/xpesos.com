<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Services extends Controller {

    public function index() {
        $this->AuthCheck();
        $data = array();
        $data['data'] = DB::table('tbl_services')->orderBy('services_id', 'asc')->get();
        return view('admin.pages.services.servicelist', $data);
    }

    public function changepassword(Request $request) {
        $data['user_id'] = $request->user_id;
        $data['username'] = $request->username;
        if (!empty($request->password)) {
            $data['password'] = md5($request->password);
        }
        DB::table('tbl_user')
                ->where('user_id', $request->user_id)
                ->update($data);
        return redirect('/admin/update-profile');
    }

    public function saveSetting(Request $request) {
        $this->AuthCheck();
        $data = array();
        $data['name'] = $request->name;
        $data['tel'] = $request->tel;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['hotline'] = $request->hotline;
        $data['emergency'] = $request->emergency;
        $data['callfororder'] = $request->callfororder;
        $data['dvcharge'] = $request->dvcharge;
        $data['recived_order'] = $request->recived_order;
        $data['confirm_order'] = $request->confirm_order;
        $data['shipped_order'] = $request->shipped_order;
        $data['copyright'] = $request->copyright;
        $data['bkasnumber'] = $request->bkasnumber;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        $data['currency'] = $request->currency;
        
        $data['banner1_link'] = $request->banner1_link;
        $data['banner2_link'] = $request->banner2_link;
        $data['banner3_link'] = $request->banner3_link;
        $data['banner4_link'] = $request->banner4_link;
        $data['banner5_link'] = $request->banner5_link;
        $data['banner6_link'] = $request->banner6_link;
        $data['banner7_link'] = $request->banner7_link;
        
        
        
        DB::table('tbl_setting')
                ->where('setting_id', $request->setting_id)
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
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        //banner1
        $photo = $request->file('banner1');
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
                $data['banner1'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        
         //banner2
        $photo = $request->file('banner2');
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
                $data['banner2'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        
          //banner3
        $photo = $request->file('banner3');
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
                $data['banner3'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        
        
           //banner4
        $photo = $request->file('banner4');
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
                $data['banner4'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        
        
          //banner5
        $photo = $request->file('banner5');
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
                $data['banner5'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        
         $photo = $request->file('banner6');
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
                $data['banner6'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
        
         $photo = $request->file('banner7');
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
                $data['banner7'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/company-setting');
            }
        }
         DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
        return redirect('/admin/company-setting');
    }
	
	
	public function updaepro(Request $request){
		
		$data['user_id'] = $request->user_id;
        $data['email'] = $request->email;
        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['username'] = $request->username;
 
	    $photo = $request->file('user_pic');
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
                $data['user_pic'] = $img;
                DB::table('tbl_user')
                        ->where('user_id', $request->user_id)
                        ->update($data);
                return redirect('/admin/update-profile');
            }
        }
	DB::table('tbl_user')
             ->where('user_id', $request->user_id)
             ->update($data);
	return redirect('/admin/update-profile');
		
		
	}

    public function updateSetting(Request $request) {

        $data['setting_id'] = $request->setting_id;
        $data['admin_name'] = $request->admin_name;
        $data['admin_email'] = $request->admin_email;
        $data['admin_phone'] = $request->admin_phone;


        $photo = $request->file('admin_photo');
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
                $data['admin_photo'] = $img;
                DB::table('tbl_setting')
                        ->where('setting_id', $request->setting_id)
                        ->update($data);
                return redirect('/admin/update-profile');
            }
        }


        DB::table('tbl_setting')
                ->where('setting_id', $request->setting_id)
                ->update($data);

        return redirect('/admin/update-profile');
    }

    public function saveServices(Request $request) {
        $this->AuthCheck();
        $user_id = Session::get('user_id');
        if (!empty($request->services_id)) {
            $data = array();
            $data['services_name'] = $request->services_name;
            $data['slug'] = $request->slug;
            $data['description'] = $request->description;
            $data['status'] = $request->status;
            DB::table('tbl_services')
                    ->where('services_id', $request->services_id)
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
                    DB::table('tbl_services')
                            ->where('services_id', $request->services_id)
                            ->update($data);
                    return redirect('/admin/services-list');
                }
            }

            return redirect('/admin/services-list');
        } else {

            $data = array();
            $data['services_name'] = $request->services_name;
            $data['slug'] = $request->slug;
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
                    DB::table('tbl_services')->insert($data);
                    return redirect('/admin/services-list');
                }
            }

            DB::table('tbl_services')->insert($data);
            return redirect('/admin/services-list');
        }
    }

    public function searchServicesRow($services_id) {

        $this->AuthCheck();
        $row = DB::table('tbl_services')
                ->where('services_id', $services_id)
                ->first();
        echo json_encode($row);
    }

    public function companylist() {
        $id = 1;
        $data = array();
        $data['data'] = DB::table('tbl_setting')->where('setting_id', $id)->orderBy('setting_id', 'asc')->first();
        return view('admin.pages.services.editsetting', $data);
    }

    public function searchServicesId($services_id) {
        $data = array();
        $data['data'] = DB::table('tbl_services')->where('services_id', $services_id)->orderBy('services_id', 'asc')->first();
        return view('admin.pages.services.editservices', $data);
    }

    public function AuthCheck() {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }

}