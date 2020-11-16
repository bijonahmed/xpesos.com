@extends('admin.master')
@section('title','Update post')
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
                            <div class="col-md">
                                <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();">
                                    <i class="fa fa-plus"></i> Add </a>

                            </div>
                            <div class="col-md" style="text-align:right;">
                                <a href="#" onclick="location.reload();emptyfrm();">&nbsp;<i
                                        class="fa fa-refresh"></i>&nbsp;Reload
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- End Row-->
</div>
<div class="modal fade" id="editmodal">

    <form id="cform" enctype="multipart/form-data" action="{{url('/admin/SavePost')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Edit Post</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Menu</label>

                        <select id="menu_id" name="menu_id" required="required" onchange="getMenuVal(this.value);"
                            style="width: 100%;">
                            <option value="">Select Menu</option>
                            <?php
                                foreach ($menu as $val) {
                                    ?>
                            <option value="<?php echo $val->menu_id; ?>"><?php echo $val->name; ?></option>
                            <?php
                                }
                                ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Sub Menu</label>

                        <select id="sub_menu_id" name="sub_menu_id" onchange="getSubMenuVal(this.value);"
                            style="width: 100%;">
                            <option value="">Select Sub Menu</option>
                            <?php
                                foreach ($submenu as $val) {
                                    ?>
                            <option value="<?php echo $val->sub_menu_id; ?>"><?php echo $val->name; ?></option>
                            <?php
                                }
                                ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Sub In Menu</label>

                        <select id="sub_in_sub_id" name="sub_in_sub_id" style="width: 100%;">
                            <option value="">Select in Sub Menu</option>
                            <?php
                               foreach ($in_sub_menu as $val) {
                                    ?>
                            <option value="<?php echo $val->sub_in_sub_id; ?>"><?php echo $val->name; ?></option>
                            <?php
                                }
                                ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Post Title</label>

                        <input type="text" id="post_title" name="post_title" placeholder="Post Title.."
                            value="{{ $data->post_title }}" required onload="convertToSlug(this.value)"
                            onkeyup="convertToSlug(this.value)" style="width: 100%;">
                        <input type="hidden" class="form-control" id="post_id" name="post_id">

                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Slug</label>

                        <input type="text" value="{{ $data->slug }}" id="slug" name="slug" placeholder="Slug" required
                            style="width: 100%;">

                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Description</label>

                        <textarea id="post_description" name="post_description"
                            style="width: 100%;">{{ $data->post_description }}</textarea>

                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Photo</label>

                        <input type="file" id="photo" name="photo">
                        <br /><span style="color: red;">Must be upload (230x230)</span>
                        <div id="insertedImages"></div>
                        <?php 
                          if(!empty($data->photo)){
                        ?>
                        <img src="{{ url('admin/'.$data->photo) }}" style="height: 250px; width: 250px;">
                          <?php } ?>
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
                    <button type="button" class="btn btn-secondary" onclick="back();"><i class="fa fa-times"></i>
                        Back</button>
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
    function back() {
        window.location.href = "/admin/post-list";
    }

    function emptyfrm() {
        $('#cform')[0].reset();
    }
    // Data Table List View
    CKEDITOR.replace('post_description');

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
    $(document).ready(function() {
        var post_id = '<?php echo $data->post_id;?>';
        var status = '<?php echo $data->status;?>';
        var menu_id = '<?php echo $data->menu_id;?>';
        var sub_menu_id = '<?php echo $data->sub_menu_id;?>';
        var sub_in_sub_id = '<?php echo $data->sub_in_sub_id;?>';
        var designation = '<?php echo $data->designation;?>';
        var management_name = '<?php echo $data->management_name;?>';
        $('#post_id').val(post_id);
        $('#status').val(status);
        $('#menu_id').val(menu_id);
        $('#sub_menu_id').val(sub_menu_id);
        $('#sub_in_sub_id').val(sub_in_sub_id);
        $('#designation').val(designation);
        $('#management_name').val(management_name);
        $('#editmodal').modal('show');
        condition(sub_menu_id);
    });

    function getMenuVal(menu_id) {
        $.ajax({
            type: "get",
            url: '{{URL::to("admin/get-sub-menu")}}',
            data: {
                menu_id: menu_id,
                _token: $('#token').val()
            },
            dataType: 'json',
            success: function(response) {
                $("#sub_menu_id").empty();
                $.each(response, function(index, submenu) {
                    $("#sub_menu_id").append('<option value="' + submenu.sub_menu_id + '">' +
                        submenu
                        .name + '</option>');
                });
                // $("select[name=district_id]").val(response.district_id);
            }
        });
    }

    function getSubMenuVal(sub_menu_id) {
        condition(sub_menu_id);
        $.ajax({
            type: "get",
            url: '{{URL::to("admin/sub-menu-in-menu")}}',
            data: {
                sub_menu_id: sub_menu_id,
                _token: $('#token').val()
            },
            dataType: 'json',
            success: function(response) {
                $("#sub_in_sub_id").empty();
                $.each(response, function(index, insubmenu) {
                    $("#sub_in_sub_id").append('<option value="' + insubmenu.sub_in_sub_id + '">' +
                        insubmenu
                        .name + '</option>');
                });
                // $("select[name=district_id]").val(response.district_id);
            }
        });
    }

    function condition(sub_menu_id) {
        if (sub_menu_id == 1) {
            //alert("sub menu id ");
            $('#post').hide();
            $('#mname').show();
            $('#dname').show();
        } else {
            $('#post').show();
            $('#mname').hide();
            $('#dname').hide();
        }
    }
</script>
@endsection