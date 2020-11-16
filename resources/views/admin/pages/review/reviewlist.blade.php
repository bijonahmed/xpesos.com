@extends('admin.master')
@section('title','Review List')
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
                    <div class="table-responsive">
                          <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Review Description</th>
                                    <th>Customer Name</th>
                                    <th>Review Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 1;
                                foreach ($review as $item) {
                                    ?>
                                    <tr>
                                        <td><?php echo $x;
                                $x++; ?> </td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->review_description}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{date("d-m-Y",strtotime($item->review_date))}}</td>
                                        <td><a href="{{url('admin/remove-review/'.$item->review_id)}}" onclick="return confirm('Are you sure you want to delete this review?');">Remove</a></td>
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

@endsection