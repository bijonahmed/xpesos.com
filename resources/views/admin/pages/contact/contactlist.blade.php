@extends('admin.master')
@section('title','Contact')
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

                            </div>
                            <div class="col-md-2" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">

                    <div class="table-responsive">
                        <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Sending Date</th>
                                    <th>Sender Name</th>
                                    <th>Email ID</th>
                                    <th>Title</th>
                                    <th>Messages</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
            $x=1;
            foreach($data as $v){
            ?>
                                <tr>
                                    <td><?php echo $x; $x++;?></td>
                                    <td><?php echo date("d-M-Y",strtotime($v->sneding_date));?></td>
                                    <td><?php echo $v->contact_name;?></td>
                                    <td><?php echo $v->email;?></td>
                                    <td><?php echo $v->title;?></td>
                                    <td><?php echo $v->msg;?></td>
                                </tr>
                                <?php
}
                              ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>

</div>
</div>


@endsection
