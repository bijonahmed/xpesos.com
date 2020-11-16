@extends('admin.master')
@section('title','Category List')
@section('maincontent')
<style>
    .widthtxt {
        width: 100%;

    }
</style>
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container">
                    <div class="card-header">
                        <div class="row">
                            <?php
                            $role_id = Session::get('role_id');
                            if ($role_id == 1) {
                            ?>
                                <div class="col-md">
                                    <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="resert();"> <i class="fa fa-plus"></i> Create a Category</a>
                                </div>
                            <?php } ?>
                            <div class="col-md" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="container">
                    <div class="row">

                        <div class="col-md-12">
                            <div class=" form-group" style="text-align: right; padding: 10px;">
                                <input type="text" name="serach" id="search" placeholder="Search" />

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>Category Name</th>
                                    <th>Sort</th>
                                    <th>Photo</th>
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
    <form enctype="multipart/form-data" id="upload_form">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content border-primary">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input">Name</label>
                        <input type="text" id="category_name" class="widthtxt" name="category_name" required onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" autcomplete="off">
                        <input type="hidden" class="form-control" id="category_id" name="category_id">

                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Slug</label>
                        <input type="text" id="slug" name="slug" id="slug" class="widthtxt" required>
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Sort</label>
                        <input type="text" id="sort" name="sort" class="widthtxt" required>
                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Image (170x170)</label>
                        <input type="file" id="photo" name="photo">

                    </div>

                    <div class="form-group">
                        <label for="large-input" class="col-form-label">Status</label>

                        <select style="width:100%;" id="status" name="status">
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
        str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
        str = str.replace(/^\s+|\s+$/gm, '');
        str = str.replace(/\s+/g, '-');
        $("#slug").val(str);

    }

    function resert() {
        $("#upload_form")[0].reset();
    }
    // ajax post
    $('#upload_form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: "save-category",
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                var msg = data;
                $("#showmsg").text(msg);
                $("#upload_form")[0].reset();
                location.reload();
            }
        })
    });

    // Edit
    function getbyId(categoryId) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "category/searchCategoryid/" + categoryId,
            data: {
                "categoryId": categoryId,
                "_token": _token,
            },
            success: function(data) {
                $("#category_name").val(data.category_name);
                $("#status").val(data.status);
                $("#slug").val(data.slug);
                $("#category_type").val(data.category_type);
                $("#sort").val(data.sort);
                $("#category_id").val(data.category_id);
            }
        });
        $('#modal-animation-3').modal('show');
    }

    $(document).ready(function() {
        //alert("test");
        featch_category_list();
        console.log("test");

        function featch_category_list(query = '') {
            console.log("bijon");
            $.ajax({
                url: "{{ route('listByCategory.search') }}",
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('tbody').html(data.table_data);
                    //$('#total_records').text(data.total_data);
                }
            })
        }

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            featch_category_list(query);
        });

    });
</script>

@endsection