<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use DateTime;
//session_start();

class LoginController extends Controller
{
    public function userRegistration(Request $request)
    {

        if (empty($request->doctor_id)) {
            $user_id = Session::get('user_id');
            $data = array();
            $data['user_id'] = $user_id;
            $data['info_type'] = $request->info_type;
            $data['doctor_name'] = $request->doctor_name;
            $data['doctor_id'] = $request->doctor_id;
            $data['division_id'] = $request->division_id;
            $data['district_id'] = $request->district_id;
            $data['title'] = $request->title;
            $data['speciality_id'] = $request->speciality_id;
            $data['about_me'] = $request->about_me;
            $data['degree'] = $request->degree;
            $data['pressent_chamber_location'] = $request->pressent_chamber_location;
            $data['gender'] = $request->gender;
            $data['email'] = $request->email;
            $data['bmdc_no'] = $request->bmdc_no;
            $data['phone'] = $request->phone;
            $data['dr_pic'] = $request->dr_pic;
            $data['remarks'] = $request->remarks;
            $data['status'] = '0';//$request->status;
            $dr_pic = $request->file('dr_pic');
            if ($dr_pic) {
                $iamgeName = str_random(20);
                $ext = strtolower($dr_pic->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'fronted/doc_pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $dr_pic->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $data['dr_pic'] = $imageUrl;
                    $dr_max_id= DB::table('tbl_doctor_profile')->max('doctor_id');
                    if (!empty($dr_max_id) > 0) {
                        $data['doctorId'] = sprintf("%06d", $dr_max_id + 1) . '-' . date("y");
                    }else{
                        $data['doctorId'] = sprintf("%06d", '000001') . '-' . date("y");
                    }
                    DB::table('tbl_doctor_profile')->insert($data);
                    //insert tbl_user
                    $ddata['doctorId']= $data['doctorId'];
                    $ddata['name'] = $data['doctor_name'];
                    $ddata['role_id'] = '3';
                    $ddata['date'] = date("Y-m-d");
                    $ddata['username'] =  $request->username; //Its username filed
                    $ddata['password'] = md5($request->password); //Its password filed
                    $ddata['status'] = 0;
                    $ddata['update_at']='';
                    DB::table('tbl_user')->insert($ddata);
                    Session::put('messages', 'Thank you for registration DoctorFair. We will communicate with you within 24 hours.');
                    return redirect('/registration');
                }
            }
            $data['dr_pic'] = "";
            //check max id
            $dr_max_id= DB::table('tbl_doctor_profile')->max('doctor_id');
            if (!empty($dr_max_id) > 0) {
                $data['doctorId'] = sprintf("%06d", $dr_max_id + 1) . '-' . date("y");
            }else{
                $data['doctorId'] = sprintf("%06d", '000001') . '-' . date("y");
            }
            DB::table('tbl_doctor_profile')->insertGetId($data);
            // tbl user table insert
            $ddata = array();
            if (!empty($dr_max_id) > 0) :
                $data['doctorId'] = sprintf("%06d", $dr_max_id + 1) . '-' . date("y");
       else:
           $data['doctorId'] = sprintf("%06d", '000001') . '-' . date("y");
       endif;
       $ddata['doctorId']= $data['doctorId'];
       $ddata['name'] = $data['doctor_name'];
       $ddata['role_id'] = '3';
       $ddata['date'] = date("Y-m-d");
       $ddata['username'] =  $request->username; //Its username filed
       $ddata['password'] = md5($request->password); //Its password filed
       $ddata['status'] = 0;
       $ddata['update_at']='';

       DB::table('tbl_user')->insert($ddata);
       Session::put('messages', 'Thank you for registration DoctorFair. We will communicate with you within 24 hours.');
            return redirect('/registration');
        }

    }

}
