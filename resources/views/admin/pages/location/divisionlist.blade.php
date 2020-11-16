@extends('admin.master')
@section('title','Division List')
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
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3"> <i class="fa fa-plus"></i> Add New</a>
                            </div>
                            <div class="col-md" style="text-align:right;">
                                <a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                  
                        <div class="col-md-12" style="text-align: right;">
                            <div class="form-group">
                                <input type="text" name="serach" id="serach" placeholder="Search...." />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="division_id" style="cursor: pointer">SL <span id="id_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" data-column_name="division_name" style="cursor: pointer">Name <span id="post_title_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" data-column_name="status" style="cursor: pointer">Status <span id="post_title_icon"></span></th>
                                    <th width="19%" class="sorting" data-sorting_type="asc" data-column_name="status" style="cursor: pointer">Action <span id="post_title_icon"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.pages.location.search_division_data')
                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="division_id" />
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
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Name</label>
                    
                            <input type="text" id="division_name" name="division_name" required style="width: 100%;">
                            <input type="hidden" class="form-control" id="division_id" name="division_id">
                       
                    </div>
                    <div class="form-group">
                        <label for="large-input" class="col-form-label">Status</label>
                      
                            <select id="status" name="status" style="width: 100%;">
                                <option value='1'>Active</option>
                                <option value='0'>Inactive</option>
                            </select>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save </button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>
<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>
<script src="{{asset(url('admin/search/divisionSearch.js'))}}"></script>
<script>
// ajax post
$(".btn-submit").click(function (e) {
    e.preventDefault();
    var _token = $("input[name='_token']").val();
    var division_name = $("input[name=division_name]").val();
    var status = $("select[name=status]").val();
    var division_id = $("input[name=division_id]").val();
    if (division_name == '') {
        alert("Please enter name");
    }
    $.ajax({
        type: 'POST',
        url: "save-division",
        dataType: "json",
        data: {
            _token: _token,
            division_name: division_name,
            division_id: division_id,
            status: status
        },
        success: function (data) {
            var msg = data;
            var division_id = $("#division_id").val();
            if (division_id) {
                alert(data);
                location.reload().delay(3000);
            } else {
                $("#showmsg").text(msg);
                $("#cform")[0].reset();
                $("#division_name").focus();
            }

        }
    });
});

// Edit
function getbyId(division_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "location/searchDivisionId/" + division_id,
        data: {
            "division_id": division_id,
            "_token": _token,
        },
        success: function (data) {
            $("#division_name").val(data.division_name);
            $("#status").val(data.status);
            $("#division_id").val(data.division_id);
        }
    });
    $('#modal-animation-3').modal('show');
}
</script>

@endsection
