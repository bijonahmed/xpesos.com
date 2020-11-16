@extends('admin.master')
@section('title','Menu List')
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
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3"> <i
                                        class="fa fa-plus"></i> Create a new menu </a>
                            </div>
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
                            <div class="form-group" style="text-align: right;">
                                <input type="text" name="search" id="search" placeholder="Search.." />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>Menu Name</th>
                                    <th>Slug</th>
                                    <th>Sort</th>
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
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Menu</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Name (English) </label>

                        <input type="text" id="name" name="name" required onload="convertToSlug(this.value)"
                            onkeyup="convertToSlug(this.value)" autcomplete="off" style="width: 100%;">
                        <input type="hidden" id="menu_id" name="menu_id" style="width: 100%;">

                    </div>


                    <div class="form-group">
                        <label for="Xlarge-input">Slug</label>

                        <input type="text" id="slug" name="slug" id="slug" required style="width: 100%;">

                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Sort</label>
                        <input type="number" id="sort" name="sort" id="sort" required style="width: 100%;">

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
    var name = $("input[name=name]").val();
    var sort = $("input[name=sort]").val();
    var slug = $("input[name=slug]").val();
    var status = $("select[name=status]").val();
    var menu_id = $("input[name=menu_id]").val();
    if (name == '' && slug == '') {
        alert("Please insert your menu name or slug");
    }
    $.ajax({
        type: 'POST',
        url: "save-menu",
        dataType: "json",
        data: {
            _token: _token,
            name: name,
            sort: sort,
            slug: slug,
            menu_id: menu_id,
            status: status
        },
        success: function(data) {
            var msg = data;
            var menu_id = $("#menu_id").val();
            if (menu_id) {
                alert(data);
                location.reload().delay(3000);
            } else {
                $("#showmsg").text(msg);
                $("#cform")[0].reset();
                $("#name").focus();
            }

        }
    });
});

// Edit
function getbyId(menu_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "menu/searchbymenu/" + menu_id,
        data: {
            "menu_id": menu_id,
            "_token": _token,
        },
        success: function(data) {
            $("#name").val(data.name);
            $("#sort").val(data.sort);
            $("#status").val(data.status);
            $("#slug").val(data.slug);
            $("#menu_id").val(data.menu_id);
        }
    });
    $('#modal-animation-3').modal('show');
}


// Data Table List View
$(document).ready(function() {
    //  alert("test");
    featch_menu_list();

    function featch_menu_list(query = '') {
        console.log("test");
        $.ajax({
            url: "{{ route('listByMainMenu.search') }}",
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
        featch_menu_list(query);
    });

});
</script>

@endsection