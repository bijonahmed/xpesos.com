<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

//session_start();

class Location extends Controller {

    public function divisionList() {
        $this->AuthCheck();
        $data = array();
        $data['data'] = DB::table('tbl_division')->orderBy('division_id', 'asc')->paginate(10);
        return view('admin.pages.location.divisionlist', $data);
    }

    public function districtList() {
        $this->AuthCheck();
        $data = array();
        $data['division'] = DB::table('tbl_division')->orderBy('division_id', 'asc')->get();
        $data['data'] = DB::table('tbl_district')
                        ->join('tbl_division', 'tbl_district.division_id', '=', 'tbl_division.division_id')
                        ->orderBy('district_id', 'asc')->paginate(15);
        return view('admin.pages.location.districtlist', $data);
    }

    public function saveDivision(Request $request) {
        $this->AuthCheck();
        if (!empty($request->division_id)) {
            $data['division_id'] = $request->division_id;
            $data['division_name'] = $request->division_name;
            $data['status'] = $request->status;
            DB::table('tbl_division')
                    ->where('division_id', $request->division_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['division_name'] = $request->division_name;
            $data['status'] = $request->status;
            DB::table('tbl_division')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function saveDistrict(Request $request) {
        $this->AuthCheck();
        if (!empty($request->district_id)) {
            $data['division_id'] = $request->division_id;
            $data['district_name'] = $request->district_name;
            $data['status'] = $request->status;
            DB::table('tbl_district')
                    ->where('district_id', $request->district_id)
                    ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $data = array();
            $data['division_id'] = $request->division_id;
            $data['district_name'] = $request->district_name;
            $data['status'] = $request->status;
            DB::table('tbl_district')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }

    public function divisionFetch_data(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('tbl_division')
                    ->where('division_id', 'like', '%' . trim($query) . '%')
                    ->orWhere('division_name', 'like', '%' . trim($query) . '%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(10);
            return view('admin.pages.location.search_division_data', compact('data'))->render();
        }
    }

    public function districtFetch_data(Request $request) {
        $this->AuthCheck();
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('tbl_district')
                    ->join('tbl_division', 'tbl_district.division_id', '=', 'tbl_division.division_id')
                    ->where('district_id', 'like', '%' . trim($query) . '%')
                    ->orWhere('district_name', 'like', '%' . trim($query) . '%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(15);
            return view('admin.pages.location.search_district_data', compact('data'))->render();
        }
    }

    public function searchDivisionRow($division_id) {

        $row = DB::table('tbl_division')
                ->where('division_id', $division_id)
                ->first();
        echo json_encode($row);
    }

    public function searchDistrictRow($district_id) {

        $row = DB::table('tbl_district')
                ->where('district_id', $district_id)
                ->first();
        echo json_encode($row);
    }

    public function divisionWiseDistrictSelect() {

        $division_id = $_GET['division_id'];
        $output = DB::table('tbl_district')
                ->where('division_id', $division_id)
                ->get();
        return json_encode($output);
    }

    public function AuthCheck() {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }

}
