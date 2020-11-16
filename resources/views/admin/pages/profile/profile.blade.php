@extends('admin.master')
@section('title','Update Profile')
@section('maincontent')

<?php 
$user_id = Session::get('user_id');
$setting = DB::table('tbl_user')->where('user_id',$user_id )->first();

 ?>

<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container">
                    <div class="card-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
                            </ol>
                        </nav>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Profile Update</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Change Password</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <form id="cform" enctype="multipart/form-data" action="{{url('/admin/update-pro')}}"
                                    method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" value="{{ $setting->user_id }}"
                                        id="user_id" name="user_id">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content animated">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white"><i class="fa fa-star"></i> Update
                                                    Profile</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label for="Xlarge-input" class="col-form-label">Name</label>
                                                    <input type="text" id="name" name="name" value="{{$setting->name}}"
                                                        required style="width: 100%;">

                                                </div>

                                                <div class="form-group">
                                                    <label for="Xlarge-input" class="col-form-label">Email</label>
                                                    <input type="text" id="email" name="email"
                                                        value="{{$setting->email}}" required style="width: 100%;">

                                                </div>

                                                <div class="form-group">
                                                    <label for="Xlarge-input" class="col-form-label">Phone</label>
                                                    <input type="text" id="mobile" name="mobile"
                                                        value="{{$setting->mobile}}" required style="width: 100%;">

                                                </div>

                                                <div class="form-group">
                                                    <label for="Xlarge-input" class="col-form-label">Photo</label>

                                                    <input type="file" id="user_pic" name="user_pic">
                                                    <br /><span style="color: red;">Must be upload (230x230)</span>
                                                    <div id="insertedImages"></div>
                                                    <img src="{{ url('admin/'.$setting->user_pic) }}"
                                                        style="height: 250px; width: 200px;">

                                                </div>

                                                <div class="form-group">
                                                    <label for="Xlarge-input" class="col-form-label">Username</label>
                                                    <input type="text" id="username" name="username" style="width: 100%;">

                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <div id="showmsg" style="text-align: center;"></div>

                                                <button type="submit" class="btn btn-primary btn-submit"><i
                                                        class="fa fa-check-square-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <form id="cform" enctype="multipart/form-data"
                                    action="{{url('/admin/change-password')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content animated">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white"><i class="fa fa-star"></i> Update
                                                    Password</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label for="Xlarge-input" class="col-form-label">Change
                                                        Password</label>

                                                    <input type="hidden" id="user_id" name="user_id"
                                                        value="<?php echo Session::get('user_id');?>"
                                                        style="width: 100%;">
                                                    <input type="password" id="password" name="password" required
                                                        style="width: 100%;">

                                                </div>

                                            </div>
                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-primary btn-submit"><i
                                                        class="fa fa-check-square-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- End Row-->
</div>

</div>
</div>
<style>
    .modal-lg {
        max-width: 90% !important;
    }
</style>
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>

@endsection