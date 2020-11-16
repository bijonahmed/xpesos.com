@extends('admin.master')
@section('title','Specality List')
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
                                        class="fa fa-plus"></i> Add New</a>
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
                                <input type="text" name="serach" id="serach" class="form-control"
                                    placeholder="Search...." />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th width="5%" class="sorting" data-sorting_type="asc"
                                        data-column_name="speciality_id" style="cursor: pointer">SL <span
                                            id="id_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc"
                                        data-column_name="specality_name" style="cursor: pointer">Name <span
                                            id="post_title_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" data-column_name="status"
                                        style="cursor: pointer">Status <span id="post_title_icon"></span></th>
                                    <th width="19%" class="sorting" data-sorting_type="asc" data-column_name="status"
                                        style="cursor: pointer">Action <span id="post_title_icon"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.pages.speciality.search_specality_data')
                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="speciality_id" />
                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
    <form id="cform">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content animated zoomInUp">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Specality</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="specality_name" name="specality_name" required
                                onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)">
                            <input type="hidden" class="form-control" id="speciality_id" name="speciality_id">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="slug" name="slug" id="slug" required>
                            <p id="slug_msg"></p>
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
<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>
<script src="{{asset(url('admin/search/specialitySearch.js'))}}"></script>
<script>
//slug
function convertToSlug(str) {
    checkSlug(str);
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
    var specality_name = $("input[name=specality_name]").val();
    var slug = $("input[name=slug]").val();
    var status = $("select[name=status]").val();
    var speciality_id = $("input[name=speciality_id]").val();
    if (specality_name == '' && slug == '') {
        alert("Please input your speciality name / Slug");
    }
    $.ajax({
        type: 'POST',
        url: "save-speciality",
        dataType: "json",
        data: {
            _token: _token,
            specality_name: specality_name,
            slug: slug,
            speciality_id: speciality_id,
            status: status
        },
        success: function(data) {
            var msg = data;
            var speciality_id = $("#speciality_id").val();
            if (speciality_id) {
                alert(data);
                location.reload().delay(3000);
            } else {
                $("#showmsg").text(msg);
                $("#cform")[0].reset();
                $("#specality_name").focus();
            }

        }
    });
});

//check slug

function checkSlug(str){

    var _token = $("input[name='_token']").val();

    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "speciality/searchSlug/" + str,
        data: {
            "str": str,
            "_token": _token,
        },
        success: function(response) {
            if(response.specality_name){
                var slugs="";
                $("#slug").val(slugs);
                alert("Sorry Already exits. Please try another slug name");

            }
        }
    });


}

// Edit
function getbyId(speciality_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "speciality/searchspeciality_id/" + speciality_id,
        data: {
            "speciality_id": speciality_id,
            "_token": _token,
        },
        success: function(data) {
            $("#specality_name").val(data.specality_name);
            $("#status").val(data.status);
            $("#speciality_id").val(data.speciality_id);
            $("#slug").val(data.slug);
        }
    });
    $('#modal-animation-3').modal('show');
}
</script>

@endsection