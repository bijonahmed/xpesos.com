@extends('admin.master')
@section('title','User Role List')
@section('maincontent')
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">
                              
                            </div>
                            <div class="col-md" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th width="5%" class="sorting" data-sorting_type="asc" style="cursor: pointer">SL
                                        <span id="id_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" style="cursor: pointer">Role
                                        Name <span id="post_title_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" style="cursor: pointer">
                                        Status <span id="post_title_icon"></span></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl = 1;

                                foreach ($data as $value) {
                                    ?>
                                <tr>
                                    <td><?php echo $sl;
                                    $sl++; ?></td>
                                    <td><?php echo $value->role_name; ?></td>
                                    <td><?php
                                          if ($value->status==1) {
                                              echo "Active";
                                          } else {
                                              echo $value->status;
                                          } ?></td>
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