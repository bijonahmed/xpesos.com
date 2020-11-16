@extends('admin.master')
@section('title','Gallery List')
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
                                        class="fa fa-plus"></i> Create a Gallery</a>
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
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Video</th>
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
    <form id="cform" enctype="multipart/form-data" action="{{url('/admin/saveGallery')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Add Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Gallery Name (English) </label>
                   
                            <input type="text" id="name" name="name" required autcomplete="off" style="width: 100%;">
                            <input type="hidden" class="form-control" id="gallery_id" name="gallery_id">
                        
                    </div>
                    <div class="form-group">
                        <label for="large-input">Type</label>
                        
                            <select id="type" name="type" style="width: 100%;"
                                onchange="showhide(this.value)">
                                <option value=''>Select Type</option>
                                <option value='1'>Photo</option>
                                <option value='2'>Video</option>
                            </select>
                       
                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" >Description</label>
                        
                            <textarea id="description" name="description"  id="description" style="width: 100%;"></textarea>
                       
                    </div>


                    <div style="display: none;" id="img">
                        <label for="Xlarge-input" class="col-form-label">Image</label>
                       
                            <input type="file" id="photo" name="photo">
                            <br /><span style="color: red;">Must be upload (230x230)</span>
                            <div id="insertedImages"></div>
                        
                    </div>



                    <div class="form-group" style="display: none;" id="video">
                        <label for="Xlarge-input" class="col-form-label">Video Url </label>
                        
                            <input type="text" id="video_url" name="video_url" autcomplete="off">

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

<script src="{{asset(url('admin/assets/js/jquery.min.js'))}}"></script>

<script>
function showhide(val) {

    if (val == 1) {
        $("#img").show();
        $("#video").hide();
    } else {
        $("#img").hide();
        $("#video").show();
    }
    //alert(val);
}



// Edit
function getbyId(gallery_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "gallery/searchbygallery/" + gallery_id,
        data: {
            "gallery_id": gallery_id,
            "_token": _token,
        },
        success: function(data) {
            var img = '<img src="' + data.photo + '" width="100" height="100" id="insertedImages">';
            $("#insertedImages").html(img);
            $("#name").val(data.name);
            $("#type").val(data.type);
            $("#video_url").val(data.video_url);
            $("#description").val(data.description);
            $("#status").val(data.status);
            $("#gallery_id").val(data.gallery_id);
            showhide(data.type);
        }
    });
    $('#modal-animation-3').modal('show');
}


// Data Table List View
$(document).ready(function() {
    //  alert("test");
    featch_list();

    function featch_list(query = '') {
        //  console.log("test");
        $.ajax({
            url: "{{ route('listBygallery.search') }}",
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
        featch_list(query);
    });

});
</script>

@endsection