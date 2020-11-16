@extends('admin.master')
@section('title','Doctor Profile List')
@section('maincontent')
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emtpyform();"> <i class="fa fa-plus"></i> Add </a>
                                <?php echo 'Total Data: '.count($total_doctor);?>
                            </div>
                            <div class="col-md-2" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="serach" id="serach" class="form-control" placeholder="Search...." />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="doctor_id" style="cursor: pointer">DR. ID <span id="id_icon"></span></th>
                                    <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="info_type" style="cursor: pointer">Type<span id="post_title_icon"></span></th>
                                    <th width="12%" class="sorting" data-sorting_type="asc" data-column_name="title" style="cursor: pointer">Title<span id="post_title_icon"></span></th>
                                    <th width="35%" class="sorting" data-sorting_type="asc" data-column_name="doctor_name" style="cursor: pointer">Doctor Name <span id="post_title_icon"></span></th>
                                    <th width="15%" class="sorting" data-sorting_type="asc" data-column_name="phone" style="cursor: pointer">Phone <span id="post_title_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="status" style="cursor: pointer">Status <span id="post_title_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="status" style="cursor: pointer">Action <span id="post_title_icon"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.pages.doctorProfile.search_doc_profile_data')
                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="doctor_id" />
                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
    <form id="cform" enctype="multipart/form-data" action="{{url('/admin/savedoctors')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content animated" style="width:600px;">
                <div class="modal-body">
                    <p>
                        <b>Add Doctor</b>
                        <hr />
                    </p>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Doctor/Professor/Asst.Professor" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Dr. Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="doctor_name" name="doctor_name" placeholder="Doctor Name.." required  onload="convertToSlug(this.value)"
                                onkeyup="convertToSlug(this.value)">
                            <input type="hidden" class="form-control" id="doctor_id" name="doctor_id">
                            <input type="hidden" class="form-control" id="doctorId" name="doctorId">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="dr_slug" name="dr_slug" placeholder="Slug" required >

                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Specialty by </label>
                        <div class="col-sm-9">

                            <select class="form-control" id="speciality_id" name="speciality_id">
                                <option value="">Select Specialty</option>
                                <?php
                                foreach ($t_speciality as $val) {
                                    ?>
                                <option value="<?php echo $val->speciality_id; ?>"><?php echo $val->specality_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">

                            <select class="form-control" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" onkeyup="validationPhone(this.value);">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Number">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Degree</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="degree" name="degree" placeholder="Enter Doctor Degree">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Chamber Location</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="pressent_chamber_location" name="pressent_chamber_location" placeholder="Present Chamber Location">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Photo</label>
                        <div class="col-sm-9">
                            <input type="file" id="dr_pic" name="dr_pic">
                            <br /><span style="color: red;">Must be upload (230x230)</span>
                            <div id="insertedImages"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Remarks</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="remarks">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="large-input" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control" id="status" name="status">
                                <option value='0'>Inactive</option>
                                <option value='1'>Active</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save </button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>
<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>
<script src="{{asset(url('admin/search/doctorSearch.js'))}}"></script>
<script>

function convertToSlug(str) {
    //replace all special characters | symbols with a space
    str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
    // trim spaces at start and end of string
    str = str.replace(/^\s+|\s+$/gm, '');
    // replace space with dash/hyphen
    str = str.replace(/\s+/g, '-');
    $("#dr_slug").val(str);

    //return str;
}
    // Edit
    function getbyId(doctor_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "doctorprofile/searhDoctorId/" + doctor_id,
            data: {
                "doctor_id": doctor_id,
                "_token": _token,
            },
            success: function(data) {
                //console.log(data.dr_pic);
                var img = '<img src="' + data.dr_pic + '" width="100" height="100" id="insertedImages">';
                $("#insertedImages").html(img);
                getDivisionId(data.division_id);
                $("select[name=info_type]").val(data.info_type);
                $("input[name=doctorId]").val(data.doctorId);
                $("input[name=doctor_name]").val(data.doctor_name);
                $("input[name=dr_slug]").val(data.dr_slug);
                $("input[name=doctor_id]").val(data.doctor_id);
                $("select[name=division_id]").val(data.division_id);
                $("select[name=district_id]").val(data.district_id);
                $("input[name=title]").val(data.title);
                $("select[name=speciality_id]").val(data.speciality_id);
                $("select[name=gender]").val(data.gender);
                $("input[name=phone]").val(data.phone);
                $("input[name=email]").val(data.email);
                $("input[name=bmdc_no]").val(data.bmdc_no);
                // $("input[name=dr_pic]").val(data.dr_pic);
                $("input[name=remarks]").val(data.remarks);
                $("select[name=status]").val(data.status);
            }
        });
        $('#modal-animation-3').modal('show');
    }

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
                    $("#district_id").append('<option value="' + district.district_id + '">' + district.district_name + '</option>');
                });
                // $("select[name=district_id]").val(response.district_id);
            }

        });

    }

    function getDivisionId(division_id) {
        getDistrict(division_id);
    }

    function emtpyform() {
        img = '';
        $("#cform")[0].reset();
        $("#insertedImages").html(img);
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

    function validationPhone(phone){

        $.ajax({
            type: "get",
            url: '{{URL::to("/check-phone-number")}}',
            data: {
                phone: phone,
                _token: $('#token').val()
            },
            dataType: 'json',
            success: function(response) {
                // $("#district_id").empty();
                // $.each(response, function(index, district) {
                //     $("#district_id").append('<option value="' + district.district_id + '">' + district.district_name + '</option>');
                // });
                // $("select[name=district_id]").val(response.district_id);
            }

        });
    }



</script>
@endsection