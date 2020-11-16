@extends('admin.master')
@section('title','Add Schedule')
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
                                <a href="{{url('/admin/doctor-schedule')}}"> <i class="fa fa-arrow-left"></i> back</a>
                            </div>
                            <div class="col-md-2" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <form id="cform">
                        {{ csrf_field() }}
                        <br />
                        <div class="form-group row">
                            <label for="Xlarge-input" class="col-sm-3 col-form-label">Doctor ID</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="doctorId" name="doctorId">
                                    <option value="">Select Doctor ID</option>
                                    <?php
                                            foreach ($schedule as $val) {
                                                ?>
                                    <option value="<?php echo $val->doctorId; ?>"><?php echo $val->doctorId .' '.$val->title.' '.$val->doctor_name; ?></option>
                                    <?php
                                            }
                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Xlarge-input" class="col-sm-3 col-form-label">Day </label>
                            <div class="col-sm-9">
                                <select class="form-control form-control" id="day" name="day">
                                    <option value="">Select Days</option>
                                    <option value='Friday (শুক্রবার)'>Friday (শুক্রবার)</option>
                                    <option value='Saturday (শনিবার)'>Saturday (শনিবার)</option>
                                    <option value='Sunday (রবিবার)'>Sunday (রবিবার)</option>
                                    <option value='Monday (সোমবার)'>Monday (সোমবার)</option>
                                    <option value='Tuesday (মঙ্গলবার)'>Tuesday (মঙ্গলবার)</option>
                                    <option value='Wednesday (বুধবার)'>Wednesday (বুধবার)</option>
                                    <option value='Thursday (বৃহস্পতিবার)'>Thursday (বৃহস্পতিবার)</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Xlarge-input" class="col-sm-3 col-form-label">Time</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="time" name="time" required>
                                <input type="hidden" class="form-control" id="schedule_id" name="schedule_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="large-input" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control" id="status" name="status">
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-submit btn-block"><i class="fa fa-check-square-o"></i> Save </button><br />

                    </form>
                </div>
            </div>
        </div>
    </div><!-- End Row-->


</div>

<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>

<script>
    // ajax post
    $(".btn-submit").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var doctorId = $("select[name=doctorId]").val();
        var day = $("select[name=day]").val();
        var time = $("input[name=time]").val();
        var status = $("select[name=status]").val();

        if (doctorId == '') {
            alert("Please select doctor ID");
        }
        $.ajax({
            type: 'POST',
            url: "save-schedule",
            dataType: "json",
            data: {
                _token: _token,
                doctorId: doctorId,
                day: day,
                time: time,
                status: status
            },
            success: function(data) {
                alert(data);
                var time = "";
                doctorId = $("#doctorId").val();
                $("#time").val(time);
                $("#time").focus();
            }
        });
    });
</script>
@endsection