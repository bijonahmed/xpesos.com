@extends('admin.master')
@section('title','News List')
@section('maincontent')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();">
                                    <i class="fa fa-plus"></i> Add </a>

                            </div>
                            <div class="col-md-2" style="text-align:right;">
                                <a href="#" onclick="location.reload();emptyfrm();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
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
                                <input type="text" name="serachdata" id="serachdata" class="form-control"
                                    placeholder="Search...." />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table-hover" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>News Title</th>
                                    <th>Slug</th>
                                    <th>Date</th>
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



<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveNews')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated" style="width:1200px;">
                <div class="modal-body">
                    <p>
                        <b>Add News</b>
                        <hr />
                    </p>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">News Title Nmae</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="news_title" name="news_title"
                                placeholder="News Title.." required onload="convertToSlug(this.value)"
                                onkeyup="convertToSlug(this.value)">
                            <input type="hidden" class="form-control" id="news_id" name="news_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" required>

                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="news_description" name="news_description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Photo</label>
                        <div class="col-sm-9">
                        <input type="file" id="photo" name="photo">
                            <br /><span style="color: red;">Must be upload (230x230)</span>
                            <div id="insertedImages"></div>


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
<style>
.modal-lg {
    max-width: 90% !important;
}
</style>
<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>
<script>
function emptyfrm(){

    $('#cform')[0].reset();
}
// Data Table List View
CKEDITOR.replace( 'news_description' );
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
function getbyId(news_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "news/searhNewsId/" + news_id,
        data: {
            "news_id": news_id,
            "_token": _token,
        },
        success: function(data) {
            var id= data.news_id;
            urls = "editnews/" + news_id,
            window.open(urls, '_blank');
        }

    });

    // $('#modal-animation-3').modal('show');
    // CKEDITOR.replace( 'news_description' );

}

$(document).ready(function() {
    //  alert("test");
    featch_news_list();

    function featch_news_list(query = '') {
        console.log("test");
        $.ajax({
            url: "{{ route('listByNews.search') }}",
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




    $(document).on('keyup', '#serachdata', function() {
        var query = $(this).val();
        featch_news_list(query);
    });

});
</script>
@endsection