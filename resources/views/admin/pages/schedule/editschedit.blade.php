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
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="10%" class="sorting">SL</th>
                                    <th width="30%" class="sorting">Day</th>
                                    <th width="30%" class="sorting">Time</th>
                                    <th width="30%" class="sorting">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $x=1;
                                    foreach($data as $v){
                                ?>
                                <tr>
                                    <td><?php echo $x;$x++;?></td>
                                    <td><?php echo $v->day;?></td>
                                    <td><?php echo $v->time;?></td>
                                    <td><a href="{{url('/admin/remove-schedule/'.$v->schedule_id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>

                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
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
        var day = $("input[name=day]").val();
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