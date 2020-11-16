<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
//session_start();

class News extends Controller {
    public function newsList() {
        $this->AuthCheck();
        $data = array();
        $data['data'] = DB::table('tbl_news')->orderBy('news_id', 'asc')->get();
        return view('admin.pages.news.newslist', $data);
    }

    public function SaveNews(Request $request) {
        $this->AuthCheck();
        //$user_id = Session::get('user_id');
        if (!empty($request->news_id)) {
            $data = array();
            $data['news_title'] = $request->news_title;
            $data['slug'] = $request->slug;
            $data['news_description'] = $request->news_description;
            $data['status'] = $request->status;
            $data['entry_date'] = date("Y-m-d");
            DB::table('tbl_news')
                    ->where('news_id', $request->news_id)
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
                    DB::table('tbl_news')
                    ->where('news_id', $request->news_id)
                    ->update($data);
                    return redirect('/admin/news-list');
                }
            }
            return redirect('/admin/news-list');
        } else {
            $data = array();
            $data['news_title'] = $request->news_title;
            $data['slug'] = $request->slug;
            $data['news_description'] = $request->news_description;
            $data['status'] = $request->status;
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
                    DB::table('tbl_news')->insert($data);
                    return redirect('/admin/news-list');
                }
            }
            DB::table('tbl_news')->insert($data);
            return redirect('/admin/news-list');
        }
    }
    public function searchByNewslist(Request $request){
        $this->AuthCheck();
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('tbl_news')
                    ->where('tbl_news.news_title', 'like', '%' . $query . '%')
                    ->orWhere('tbl_news.status', 'like', '%' . $query . '%')
                    ->orderBy('tbl_news.news_id', 'asc')
                    ->get();
            } else {
                $data = DB::table('tbl_news')
                ->orderBy('tbl_news.news_id', 'desc')
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
                    $value=$row->news_id;
                $link = '<a onclick="getbyId('.$row->news_id.')" href="#">Edit</a>';
            //$link = '<a onclick="getbyId('.$row->news_id.')" href="#">Edit</a>';
                    $output .= '
            <tr>
            <td>' . $sl . '</td>
             <td>' . $row->news_title . '</td>
             <td>' . $row->slug . '</td>
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
    public function searchNewsId($news_id){
        $data['data'] = DB::table('tbl_news')->where('news_id',$news_id)->orderBy('news_id', 'asc')->first();
        return view('admin.pages.news.editnews', $data);
    }
    public function searchNewsRow($news_id) {
        $this->AuthCheck();
        $row = DB::table('tbl_news')
                ->where('news_id', $news_id)
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