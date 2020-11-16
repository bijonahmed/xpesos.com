@extends('admin.master')
@section('title','Schedule List')
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
                                <a href="{{url('/admin/add-schedule')}}"> <i class="fa fa-plus"></i> Add New</a>
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
                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="doctorId" style="cursor: pointer">SL <span id="id_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" data-column_name="day" style="cursor: pointer">DOCTOR ID <span id="post_title_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" data-column_name="status" style="cursor: pointer">Status <span id="post_title_icon"></span></th>
                                    <th width="19%" class="sorting" data-sorting_type="asc" data-column_name="status" style="cursor: pointer">Action <span id="post_title_icon"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.pages.schedule.search_schedule_data')
                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="doctorId" />
                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>

</div>
</div>
<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>
<script src="{{asset(url('admin/search/scheduleSearch.js'))}}"></script>


@endsection