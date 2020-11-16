@extends('admin.master')
@section('title','User List')
@section('maincontent')
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container-fluid">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">
                                <a href="#" onclick="showModal();"> <i class="fa fa-plus"></i> Create a User</a>
                            </div>
                            <div class="col-md" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row" style="display:none;">
                        <div class="form-group">
                            <input type="text" name="serach" id="serach" placeholder="Search...." />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>CompanyName</th>
                                    <th>PersonName</th>
                                    <th>PhoneNumber</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.pages.user.search_user_data')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-4">
    <form id="cform">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Changes Password</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="userid" name="user_id">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Password</label>
                        <input type="password" id="password" name="password" required style="width: 100%;" placeholder="Enter your Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary btn-changesPass"><i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal-animation-3">
    <form id="userform" enctype="multipart/form-data" method="POST" action="{{url('admin/save-user')}}">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Company</label>
                        <input type="text" id="company" name="company" placeholder="Company" required style="width: 100%;" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label" style="color: red;">Slug</label>
                        <input type="text" id="slug" name="slug" placeholder="slug" required style="width: 100%;">
                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Name</label>
                        <input type="text" id="name" name="name" placeholder="Full Name" required style="width: 100%;">
                        <input type="hidden" class="form-control" id="user_id" name="userid">
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Mobile</label>
                        <input type="text" id="mobile" name="mobile" placeholder="Mobile" required style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input">username</label>
                        <input type="text" id="username" placeholder="username" name="username" required style="width: 100%;">
                    </div>
                    <!-- <div class="form-group">
                        <label for="Xlarge-input">CompanyLogo</label>
                        <span id="insertedImages"></span>
                        <input type="file" id="user_pic" style="width: 100%;" name="user_pic">
                    </div> -->
                    <div class="form-group">
                        <label for="Xlarge-input">Role</label>
                        <select id="role_id" name="role_id" style="width: 100%;" required>
                            <option value="">Select Role</option>
                            <?php
                            foreach ($role as $val) {
                            ?>
                                <option value="<?php echo $val->role_id; ?>"><?php echo $val->role_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="large-input" class="col-form-label">Status</label>
                        <select id="status" name="status" style="width: 100%;">
                            <option value='1'>Active</option>
                            <option value='0'>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group" id="editpassword">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Password</label>
                        <input type="password" id="password" name="password" style="width: 100%;" placeholder="Enter your Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>

<script>
    function convertToSlug(str) {
        //replace all special characters | symbols with a space
        str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
        // trim spaces at start and end of string
        str = str.replace(/^\s+|\s+$/gm, '');
        // replace space with dash/hyphen
        str = str.replace(/\s+/g, '-');
        $("#slug").val(str);
        //return str;
    }

    function showModal() {
        $("#userform")[0].reset();
        $("#modal-animation-3").modal('show');
    }

    // ajax post btn-changesPass
    $(".btn-changesPass").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var password = $("input[name=password]").val();
        var user_id = $("input[name=user_id]").val();
        if (password == '') {
            alert("Please input your password name");
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: "change-password",
                dataType: "json",
                data: {
                    _token: _token,
                    user_id: user_id,
                    password: password
                },
                success: function(data) {
                    alert(data);
                    window.setTimeout(function() {
                        location.reload()
                    }, 2000)
                }
            });
        }
    });

    // Edit
    function changesPass(user_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/searchuser_id/" + user_id,
            data: {
                "user_id": user_id,
                "_token": _token,
            },
            success: function(data) {
                $("#userid").val(data.user_id);
            }
        });
        $('#modal-animation-4').modal('show');
    }

    function getbyId(user_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/searchuser_id/" + user_id,
            data: {
                "user_id": user_id,
                "_token": _token,
            },
            success: function(data) {
                $("#name").val(data.name);
                $("#name").val(data.name);
                $("#phoneNumber").val(data.phoneNumber);
                $("#role_id").val(data.role_id);
                $("#status").val(data.status);
                $("#email").val(data.email);
                $("#company").val(data.company);
                $("#slug").val(data.company_slug);
                $("#username").val(data.username);
                $("#mobile").val(data.mobile);
                var img = '<img src="' + data.user_pic + '" width="100" height="100" id="insertedImages">';
                $("#insertedImages").html(img);


                //  $("#password").val(data.password);
                $("#user_id").val(data.user_id);
                $("#editpassword").hide();
            }
        });
        $('#modal-animation-3').modal('show');
    }
</script>
@endsection