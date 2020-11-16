    @extends('fronted.master')
    @section('title','Registration/Login')
    @section('maincontent')

    <div class='container'>
        <div class='row'>
            @include('fronted.common.leftsidebar')
            <div class='col-md-9'>
                <div class="body-content">
                    <div class="sign-in-page">
                        <div class="row">
                            <!-- Sign-in -->
                            <!-- create a new account -->
                            <div class="col-md-12 col-sm-12 create-new-account">
                                <h4 class="checkout-subtitle">Create a new account Only for Doctor.</h4>
                                <form class="register-form outer-top-xs" enctype="multipart/form-data" role="form"
                                    action="{{url('/save-registration-data')}}" method="POST">
                                   {{ csrf_field() }}

                                    <div style="color:green; text-align: center; font-size: 18px; font-weight: bold;"><?php
                                               $messages = Session::get('messages');
                                               if (!empty($messages)) {
                                                   echo $messages;
                                                   session::put('messages', null);
                                               }?></div>
                                    <table width="290" border="0" class="table table-hover">
                                        <tr>
                                            <td colspan="5" style="background-color: green; color: white;">
                                                <b>Particular Information</b>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="135">Name&nbsp;</td>
                                            <td width="139">
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="doctor_name" name="doctor_name" placeholder="Enter Your Name"
                                                    autocomlete="off" required>
                                                <input type="hidden" id="info_type" name="info_type" value="2"/ />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Title&nbsp;</td>
                                            <td>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="title" name="title" placeholder="Like: Dr./Prof."
                                                    autocomlete="off" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Expertise/Specialized</td>
                                            <td>
                                                <select class="form-control selectpicker" id="speciality_id"
                                                    name="speciality_id" data-show-subtext="true"
                                                    data-live-search="true">
                                                    <option value="">Select Expertise/Speciality</option>
                                                    <?php
                   foreach ($t_speciality as $val) {
                       ?>
                                                    <option value="<?php echo $val->speciality_id; ?>">
                                                        <?php echo $val->specality_name; ?></option>
                                                    <?php
                   }
                   ?>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td>Gender&nbsp;</td>
                                            <td><select class="selectpicker" name="gender" data-show-subtext="true"
                                                    data-live-search="true" style="color: black; width: 100%;">
                                                    <option data-subtext="Search By Specality">Search By Gender</option>
                                                    <option data-subtext="Male">Male</option>
                                                    <option data-subtext="Female">Female</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td>Phone No</td>
                                            <td><input type="text" class="form-control unicase-form-control text-input"
                                                    id="phone" name="phone" placeholder="Enter Your Phone Number"
                                                    autocomlete="off" required onchange="checkMobile(this.value)">
                                                <span id="phonevalidation"
                                                    style="color: red; font-weight: bold;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email Id </td>
                                            <td><input type="text" class="form-control unicase-form-control text-input"
                                                    id="email" name="email" placeholder="Enter Your Email ID"
                                                    autocomlete="off" onchange="checkEmail(this.value)">
                                                <span id="emailvalidation"
                                                    style="color: red; font-weight: bold;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>BMDC Reg. No</td>
                                            <td><input type="text" class="form-control unicase-form-control text-input"
                                                    id="bmdc_no" name="bmdc_no" placeholder="BMDC Reg. No"
                                                    autocomlete="off" required onchange="checkbmdc(this.value)">
                                                <span id="bvmdcvalidation"
                                                    style="color: red; font-weight: bold;"></span>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Degree</td>
                                            <td><textarea type="text"
                                                    class="form-control unicase-form-control text-input" id="degree"
                                                    name="degree" placeholder="Degree" autocomlete="off"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Remarks</td>
                                            <td><textarea class="form-control unicase-form-control text-input"
                                                    id="remarks" name="remarks" placeholder="Remarks"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>About Info To Me</td>
                                            <td><textarea class="form-control unicase-form-control text-input"
                                                    id="about_me" name="about_me"
                                                    placeholder="About Info To Me"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>Upload Images</td>
                                            <td><input type="file" class="form-control unicase-form-control text-input"
                                                    id="dr_pic" name="dr_pic"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="background-color: green; color: white;">
                                                <b>Chamber Location</b>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Division</td>
                                            <td>
                                                <select class="from-control selectpicker" data-error="field is required"
                                                    required id="division_id" name="division_id"
                                                    onchange="getDistrict(this.value)">
                                                    <option value="">Select Division</option>
                                                    <?php
                                                  foreach ($division as $val) {
                                                      ?>
                                                    <option value="<?php echo $val->division_id; ?>">
                                                        <?php echo $val->division_name; ?></option>
                                                    <?php
                                                  }
                                                  ?>
                                                </select>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>District</td>
                                            <td>

                                                <select class="from-control" name="district_id" id="district_id"
                                                    style="width: 100%;">
                                                    <option value="" selected="selected">Select District</option>
                                                </select>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Chamber Hospital/Clinic Name</td>
                                            <td><input type="text" class="form-control unicase-form-control text-input"
                                                    id="pressent_chamber_location" name="pressent_chamber_location"
                                                    placeholder="Chamber Hospital/Clinic Name" autocomlete="off"
                                                    required></td>
                                        </tr>
                                        <tr>

                                        <tr>
                                            <td colspan="5" style="background-color: green; color: white;">
                                                <b>Username & Password</b>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Username</td>
                                            <td><input type="text" class="form-control unicase-form-control text-input"
                                                    id="username" name="username" placeholder="Enter Your Username"
                                                    autocomlete="off" required onchange="checkUsername(this.value)">
                                                <span id="usernamevalidation"
                                                    style="color: red; font-weight: bold;"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Password</td>
                                            <td><input type="password"
                                                    class="form-control unicase-form-control text-input" id="password"
                                                    name="phone" placeholder="Enter Your Password" autocomlete="off"
                                                    required onchange="checkPassword(this.value)">
                                                <span id="passwordvalidation"
                                                    style="color: red; font-weight: bold;"></span>
                                            </td>
                                        </tr>

                                    </table>
                                    <button type="submit"
                                        class="btn-upper btn btn-primary checkout-page-button btn-block"
                                        id="signup">Sign Up</button>
                                </form>
                            </div>
                            <!-- create a new account -->
                        </div><!-- /.row -->
                    </div><!-- /.sigin-in-->
                </div><!-- /.body-content -->
            </div>
            @endsection
            <script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>

<script>
function checkMobile(phone) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "phone/searchPhoneNumber/" + phone,
        data: {
            "phone": phone,
            "_token": _token,
        },
        success: function(data) {
            var msg = data;
            var textmesg = "Please try again another phone number. already exits";
            if (msg == '1') {
                $("#phonevalidation").text(textmesg);
                $("#phone").focus();
                $("#signup").attr("disabled", true);
            } else {
                var textmesg = '';
                $("#phonevalidation").text(textmesg);
                $("#signup").attr("disabled", false);
            }
        }
    });

}

function checkEmail(email) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "email/searchEmailId/" + email,
        data: {
            "email": email,
            "_token": _token,
        },
        success: function(data) {
            var msg = data;
            var textmesg = "Please try again another Email Id. already exits";
            if (msg == '1') {
                $("#emailvalidation").text(textmesg);
                $("#email").focus();
                $("#signup").attr("disabled", true);
            } else {
                var textmesg = '';
                $("#emailvalidation").text(textmesg);
                $("#signup").attr("disabled", false);
            }
        }
    });

}

function checkbmdc(bmdc_no) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "bmdc/searchbmdc/" + bmdc_no,
        data: {
            "bmdc_no": bmdc_no,
            "_token": _token,
        },
        success: function(data) {
            var msg = data;
            var textmesg = "Please try again another BMDC No. already exits";
            if (msg == '1') {
                $("#bvmdcvalidation").text(textmesg);
                $("#bmdc_no").focus();
                $("#signup").attr("disabled", true);
            } else {
                var textmesg = '';
                $("#bvmdcvalidation").text(textmesg);
                $("#signup").attr("disabled", false);
            }
        }
    });

}

function checkUsername(username) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "user/username/" + username,
        data: {
            "username": username,
            "_token": _token,
        },
        success: function(data) {
            var msg = data;
            var textmesg = "Please try again another Username. already exits";
            if (msg == '1') {
                $("#usernamevalidation").text(textmesg);
                $("#username").focus();
                $("#signup").attr("disabled", true);
            } else {
                var textmesg = '';
                $("#usernamevalidation").text(textmesg);
                $("#signup").attr("disabled", false);
            }
        }
    });

}
$(document).on('change', ':file', function() {
    const file = this.files[0];
    const fileType = file['type'];
    const validImageTypes = ['image/jpeg', 'image/png'];
    if (!validImageTypes.includes(fileType)) {
        alert('Only JPEG and PNG file types are allowed');
        this.value = '';
    }
});

function getDistrict(division_id) {
    $.ajax({
        type: "get",
        url: '{{URL::to("/division-wise-district")}}',
        data: {
            division_id: division_id,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(response) {
            $("#district_id").empty();
            $.each(response, function(index, district) {
                $("#district_id").append('<option value="' + district.district_id +
                    '">' + district.district_name + '</option>');
            });
            // $("select[name=district_id]").val(response.district_id);
        }
    });
}
</script>