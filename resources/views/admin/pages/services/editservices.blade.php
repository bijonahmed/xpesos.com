@extends('admin.master')
@section('title','Services List')
@section('maincontent')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
tinymce.init({
    selector: 'textarea'
});
</script>
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

            </div>
        </div>
    </div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
    <form id="cform" enctype="multipart/form-data" action="{{url('/admin/saveservices')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated" style="width:1200px;">
                <div class="modal-body">
                    <p>
                        <b>Edit Services</b>
                        <hr />
                    </p>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Services Nmae</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->services_name }}" id="services_name" name="services_name"
                                placeholder="Services Name.." required onload="convertToSlug(this.value)"
                                onkeyup="convertToSlug(this.value)">
                            <input type="hidden" class="form-control" value="{{ $data->services_id }}" id="services_id" name="services_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="slug" value="{{ $data->slug }}" name="slug" placeholder="Slug" required>

                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description">{{ $data->description }}</textarea>
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
<script src="{{asset(url('admin/search/servicesSearch.js'))}}"></script>
<script>
CKEDITOR.replace('description');
// Add Slug
function convertToSlug(str) {
    str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
    str = str.replace(/^\s+|\s+$/gm, '');
    str = str.replace(/\s+/g, '-');
    $("#slug").val(str);

    //return str;
}
// Edit
$(document).ready(function() {
   var imglink= '<?php echo '/admin/'.$data->photo;?>';
   var img = '<img src="' + imglink + '" width="100" height="100" id="insertedImages">';
   $("#insertedImages").html(img);

    var status = '<?php echo $data->status;?>';
    $('#status').val(status);
    $('#modal-animation-3').modal('show');
});
</script>
@endsection