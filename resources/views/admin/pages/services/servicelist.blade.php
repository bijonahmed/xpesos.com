@extends('admin.master')
@section('title','Services List')
@section('maincontent')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
  <script>tinymce.init({selector:'textarea'});</script>
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
                                        data-column_name="services_id" style="cursor: pointer">SL <span
                                            id="id_icon"></span></th>
                                    <th width="25%" class="sorting" data-sorting_type="asc"
                                        data-column_name="services_name" style="cursor: pointer">Services Name <span
                                            id="post_title_icon"></span></th>
                                    <th width="15%" class="sorting" data-sorting_type="asc"
                                        data-column_name="division_id" style="cursor: pointer">Slug<span
                                            id="post_title_icon"></span></th>
                                    <th width="15%" class="sorting" data-sorting_type="asc"
                                        data-column_name="district_id" style="cursor: pointer">Img<span
                                            id="post_title_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="status"
                                        style="cursor: pointer">Status <span id="post_title_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc"
                                        data-column_name="services_id" style="cursor: pointer">Action <span
                                            id="post_title_icon"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$sl = 1;
foreach ($data as $row) {
    ?>
    <tr>
        <td><?php echo $sl;
    $sl++; ?> </td>
      <td>{{ $row->services_name }}</td>
      <td>{{ $row->slug }}</td>

       <td><img src="<?php echo $row->photo;?>" style="hieght: 200px; width: 250px;"></td>
        <td><?php
            if ($row->status == '0') {
                echo "Inactive";
            } else if ($row->status == '1') {
                echo "Active";
            }
            ?></td>
        <td><a href="#" onclick="getbyId('<?php echo $row->services_id ?>')">Edit</a></td>
    </tr>
    <?php
}
?>


                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="services_id" />
                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                    </div>
                </div>
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
                        <b>Add Services</b>
                        <hr />
                    </p>

                    <div class="form-group row">
                        <label for="Xlarge-input" class="col-sm-3 col-form-label">Services Nmae</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="services_name" name="services_name"
                                placeholder="Services Name.." required onload="convertToSlug(this.value)"
                                onkeyup="convertToSlug(this.value)">
                            <input type="hidden" class="form-control" id="services_id" name="services_id">
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
                            <textarea class="form-control" id="description" name="description"></textarea>
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
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
 
<script>
 CKEDITOR.replace( 'description' );
// Add Slug
function convertToSlug(str) {
    str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
    str = str.replace(/^\s+|\s+$/gm, '');
    str = str.replace(/\s+/g, '-');
    $("#slug").val(str);

    //return str;
}
// Edit
function getbyId(services_id) {
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "services/searhServicesId/" + services_id,
        data: {
            "services_id": services_id,
            "_token": _token,
        },
        success: function(data) {
            var id= data.services_id;
            urls = "editfeaturesServices/" + services_id,
           // alert(urls);
            window.open(urls, '_blank');
            // var img = '<img src="' + data.photo + '" width="100" height="100" id="insertedImages">';
            // $("#insertedImages").html(img);
            // $("input[name=services_id]").val(data.services_id);
            // $("input[name=services_name]").val(data.services_name);
            // $("input[name=slug]").val(data.slug);
            // $("#description").val(data.description);
            // $("select[name=status]").val(data.status);

        }
    });
   // $('#modal-animation-3').modal('show');
}

</script>
@endsection