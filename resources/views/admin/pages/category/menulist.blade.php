@extends('admin.master')
@section('title','Category List')
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
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3"> <i
                                        class="fa fa-plus"></i> Add (Total Data : <span id="total_records"></span>)</a>
                            </div>
                            <div class="col-md-2" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
                                </a>
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
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="Search Disease Category.." />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>Category Name English </th>
                                    <th>Category Name Bangla</th>
                                    <th>Slug</th>
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
    <form id="cform">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated zoomInUp">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Add Disease Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Name (English) </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="english_name" name="english_name" required
                                onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)"
                                autcomplete="off">
                            <input type="hidden" class="form-control" id="disease_cat_id" name="disease_cat_id">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Nane (Bangla) </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bangla_name" name="bangla_name"
                                autcomplete="off">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="slug" name="slug" id="slug" required>
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
// ajax post
$(".btn-submit").click(function(e) {
    e.preventDefault();
    var _token = $("input[name='_token']").val();
    var english_name = $("input[name=english_name]").val();
    var bangla_name = $("input[name=bangla_name]").val();
    var slug = $("input[name=slug]").val();
    var status = $("select[name=status]").val();
    var disease_cat_id = $("input[name=disease_cat_id]").val();
    if (english_name == '' && slug == '') {
        alert("Please input your Disease Category name / slug");
    }
    $.ajax({
        type: 'POST',
        url: "save-disease-category",
        dataType: "json",
        data: {
            _token: _token,
            english_name: english_name,
            bangla_name: bangla_name,
            slug: slug,
            disease_cat_id: disease_cat_id,
            status: status
        },
        success: function(data) {
            var msg = data;
            var disease_cat_id = $("#disease_cat_id").val();
            if (disease_cat_id) {
                alert(data);
                location.reload().delay(3000);
            } else {
                $("#showmsg").text(msg);
                $("#cform")[0].reset();
                $("#english_name").focus();
            }

        }
    });
});

// Edit
function getbyId(disease_cat_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "diseasecategory/searchdiseaseCategoryid/" + disease_cat_id,
        data: {
            "disease_cat_id": disease_cat_id,
            "_token": _token,
        },
        success: function(data) {
            $("#english_name").val(data.english_name);
            $("#bangla_name").val(data.bangla_name);
            $("#status").val(data.status);
            $("#slug").val(data.slug);
            $("#disease_cat_id").val(data.disease_cat_id);
        }
    });
    $('#modal-animation-3').modal('show');
}


// Data Table List View
$(document).ready(function() {
    //  alert("test");
    fetch_disease_category_data();

    function fetch_disease_category_data(query = '') {
        $.ajax({
            url: "{{ route('diseaseCategory.search') }}",
            method: 'GET',
            data: {
                query: query
            },
            dataType: 'json',
            success: function(data) {
                $('tbody').html(data.table_data);
                $('#total_records').text(data.total_data);
            }
        })
    }

    $(document).on('keyup', '#search', function() {
        var query = $(this).val();
        fetch_disease_category_data(query);
    });

});
</script>

@endsection