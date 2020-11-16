<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
//session_start();
class Schedule extends Controller
{
    public function index()
    {
        $this->AuthCheck();
        $data =array();
        $data['data'] = DB::table('tbl_schedule')
            ->leftjoin('tbl_doctor_profile', 'tbl_schedule.doctorId', '=', 'tbl_doctor_profile.doctorId')
            ->where('tbl_schedule.status', 1)->groupBy('tbl_schedule.doctorId')->paginate(15);
        return view('admin.pages.schedule.schedulelist', $data);
    }
    public function searchScheduleRow($doctorId)
    {
        $this->AuthCheck();
        $data =array();
        $data['data'] = DB::table('tbl_schedule')
            ->join('tbl_doctor_profile', 'tbl_schedule.doctorId', '=', 'tbl_doctor_profile.doctorId')
            ->where('tbl_schedule.doctorId', $doctorId)->get();
        return view('admin.pages.schedule.editschedit', $data);
    }
    public function removeSchedule($schedule_id)
    {
        $this->AuthCheck();
        $data =array();
        $data['data'] = DB::table('tbl_schedule')->where('tbl_schedule.schedule_id', $schedule_id)->delete();
        return redirect('/doctor-schedule');
    }
    public function addSchedule()
    {
        $this->AuthCheck();
        $data=array();
        $data['schedule'] = DB::table('tbl_doctor_profile')->where('tbl_doctor_profile.status', 1)->orderBy('doctorId', 'asc')->get();
         return view('admin.pages.schedule.addschedule', $data);


    }
    public function saveSchedule(Request $request)
    {
        $this->AuthCheck();
        if (!empty($request->schedule_id)) {
            $user_id=Session::get('user_id');
            $data['user_id'] = $user_id;
            $data['schedule_id'] = $request->schedule_id;
            $data['doctorId'] = $request->doctorId;
            $data['day'] = $request->day;
            $data['time'] = $request->time;
            $data['status'] = $request->status;
            DB::table('tbl_schedule')
                ->where('schedule_id', $request->schedule_id)
                ->update($data);
            $success = "Successfully Update";
            echo json_encode($success);
        } else {
            $user_id=Session::get('user_id');
            $data = array();
            $data['doctorId'] = $request->doctorId;
            $data['user_id'] = $user_id;
            $data['day'] = $request->day;
            $data['time'] = $request->time;
            $data['status'] = $request->status;
            DB::table('tbl_schedule')->insert($data);
            $success = "Successfully Save";
            echo json_encode($success);
        }
    }
    public function scheduleFetch_data(Request $request)
    {
        $this->AuthCheck();
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('tbl_schedule')
                ->leftjoin('tbl_doctor_profile', 'tbl_schedule.doctorId', '=', 'tbl_doctor_profile.doctorId')
                ->where('tbl_schedule.doctorId', 'like', '%' . trim($query) . '%')
                ->groupBy('tbl_schedule.doctorId')->paginate(15);
            return view('admin.pages.schedule.search_schedule_data', compact('data'))->render();
        }
    }
    public function AuthCheck()
    {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }
}
