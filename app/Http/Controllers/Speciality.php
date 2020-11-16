<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Speciality extends Controller {

  public function addSpeciality(){
    $this->AuthCheck();
    $data = DB::table('tbl_speciality')->orderBy('speciality_id', 'asc')->paginate(15);
    return view('admin.pages.speciality.specalitylist', compact('data'));
  }

  public function specalityFetch_data(Request $request){
    $this->AuthCheck();
    if ($request->ajax()) {
        $sort_by = $request->get('sortby');
        $sort_type = $request->get('sorttype');
        $query = $request->get('query');
        $query = str_replace(" ", "%", $query);
        $data = DB::table('tbl_speciality')
                ->where('speciality_id', 'like', '%' . trim($query) . '%')
                ->orWhere('specality_name', 'like', '%' . trim($query) . '%')
                ->orderBy($sort_by, $sort_type)
                ->paginate(15);
        return view('admin.pages.speciality.search_specality_data', compact('data'))->render();
    }
  }

  public function saveSpeciality(Request $request){
    $this->AuthCheck();
    if (!empty($request->speciality_id)) {
        $data['speciality_id'] = $request->speciality_id;
        $data['specality_name'] = $request->specality_name;
        $data['slug'] = $request->slug;
        $data['status'] = $request->status;
        DB::table('tbl_speciality')
                ->where('speciality_id', $request->speciality_id)
                ->update($data);
        $success = "Successfully Update";
        echo json_encode($success);
    } else {
        $data = array();
        $data['specality_name'] = $request->specality_name;
        $data['slug'] = $request->slug;
        $data['status'] = $request->status;
        DB::table('tbl_speciality')->insert($data);
        $success = "Successfully Save";
        echo json_encode($success);
    }
  }

  public function searchSpecialityRow($speciality_id){
        $this->AuthCheck();
        $row = DB::table('tbl_speciality')
                ->where('speciality_id', $speciality_id)
                ->first();
        echo json_encode($row);
  }

  public function searchSpecialitySlug($slug){
    $this->AuthCheck();
    if(!empty($slug)){
        $row = DB::table('tbl_speciality')
        ->where('slug', $slug)
        ->first();
        echo json_encode($row);
    }

  }

  public function AuthCheck() {
      $user_id = Session::get('user_id');
      if (empty($user_id)) {
          return redirect('/auth')->send();
      }
  }
}