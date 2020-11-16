@extends('admin.master')
@section('title','Slider List')
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
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3"> <i class="fa fa-plus"></i> Add New </a>
                            </div>
                            <div class="col-md" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group" style="text-align: right;">
                                <input type="text" name="search" id="search" placeholder="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
    <form id="cform" enctype="multipart/form-data" action="{{url('admin/save')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" style="color: white;"><i class="fa fa-plus"></i> Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Name (English) </label>

                        <input type="text" id="name" name="name" required autcomplete="off" style="width: 100%;">
                        <input type="hidden" class="form-control" id="slider_id" name="slider_id">

                    </div>


                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Description</label>

                        <textarea id="description" name="description" id="description" style="width: 100%;"></textarea>

                    </div>


                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Image</label>

                        <input type="file" id="photo" name="photo">
                        <br /><span style="color: red;">Must be upload (1680x500)</span>
                        <div id="insertedImages"></div>

                    </div>



                    <div class="form-group">
                        <label for="large-input" class="col-form-label">Status</label>

                        <select class="form-control" id="status" name="status" style="width: 100%;">
                            <option value='1'>Active</option>
                            <option value='0'>Inactive</option>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
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

// Edit
function getbyId(slider_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "slider/searchbyslider/" + slider_id,
        data: {
            "slider_id": slider_id,
            "_token": _token,
        },
        success: function (data) {
            var img = '<img src="' + data.photo + '" width="100%" height="100" id="insertedImages">';
            $("#insertedImages").html(img);
            $("#name").val(data.name);
            $("#description").val(data.description);
            $("#status").val(data.status);
            $("#slider_id").val(data.slider_id);
        }
    });
    $('#modal-animation-3').modal('show');
}


// Data Table List View
$(document).ready(function () {
    //  alert("test");
    featch_slider_list();

    function featch_slider_list(query = '') {
        console.log("test");
        $.ajax({
            url: "{{ route('listByslider.search') }}",
            method: 'GET',
            data: {
                query: query
            },
            dataType: 'json',
            success: function (data) {
                $('tbody').html(data.table_data);
                $('#total_records').text(data.total_data);
            }
        })
    }

    $(document).on('keyup', '#search', function () {
        var query = $(this).val();
        featch_slider_list(query);
    });

});
</script>

@endsection