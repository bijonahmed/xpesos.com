<?php $__env->startSection('title','In Sub Category List'); ?>
<?php $__env->startSection('maincontent'); ?>
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
                                    <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();"> <i class="fa fa-plus"></i> Create a in Subcategory</a>
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
                    <div class="col-md-12">
                        <div class=" form-group" style="text-align: right; padding: 10px;">
                            <input type="text" name="serach" id="search" placeholder="Search" />

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                    <th>SL</th>
                                    <th>Category Name</th>
                                    <th>Sub Cat Name</th>
                                    <th>In Sub Cat Name</th>
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
        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog">
            <div class="modal-content border-primary">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Sub Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Category</label>
                        <select id="category_id" name="category_id" required="required" onchange="getCategoryVal(this.value);" style="width: 100%;">
                            <option value="">Select Category</option>
                            <?php
                            foreach ($category as $val) {
                            ?>
                                <option value="<?php echo $val->category_id; ?>"><?php echo $val->category_name; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Sub Category</label><br>

                        <select id="sub_cat_id" name="sub_cat_id" style="width: 100%;">
                            <option value="">Select Sub Category</option>
                            <?php
                            foreach ($sub_cat as $val) {
                            ?>
                                <option value="<?php echo $val->sub_cat_id; ?>"><?php echo $val->sub_cat_name; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>


                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input">In Sub Cat Name</label>
                        <input type="text" id="sub_in_sub_cat_name" name="sub_in_sub_cat_name" class="widthtxt" required onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" autcomplete="off">

                        <input type="hidden" id="sub_in_sub_id" name="sub_in_sub_id" class="widthtxt">
                    </div>


                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Slug</label>
                        <input type="text" id="slug" name="slug" id="slug" class="widthtxt" required>

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
<script src="<?php echo e(url('admin/assets/js/jquery.min.js')); ?>"></script>
<script>
    function emptyfrm() {

        $('#cform')[0].reset();
    }

    function convertToSlug(str) {
        str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
        str = str.replace(/^\s+|\s+$/gm, '');
        str = str.replace(/\s+/g, '-');
        $("#slug").val(str);

    }

    // ajax post
    $(".btn-submit").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var category_id = $("select[name=category_id]").val();
        var sub_cat_id = $("select[name=sub_cat_id]").val();
        var sub_in_sub_id = $("input[name=sub_in_sub_id]").val();
        var sub_in_sub_cat_name = $("input[name=sub_in_sub_cat_name]").val();
        var slug = $("input[name=slug]").val();
        var status = $("select[name=status]").val();

        if (sub_in_sub_cat_name == '') {
            alert("Please input your sub category name");
        }
        $.ajax({
            type: 'POST',
            url: "save-in-subsubcategory",
            dataType: "json",
            data: {
                _token: _token,
                category_id: category_id,
                sub_in_sub_id: sub_in_sub_id,
                sub_in_sub_cat_name: sub_in_sub_cat_name,
                sub_cat_id: sub_cat_id,
                slug: slug,
                status: status
            },
            success: function(data) {
                var msg = data;
                $("#showmsg").text(msg);
                $("#sub_in_sub_cat_name").focus();
                $("#sub_in_sub_cat_name").val("");
                $("#slug").val("");

            }
        });
    });

    // Edit
    function getbyId(sub_in_sub_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "category/searchInSubCategoryid/" + sub_in_sub_id,
            data: {
                "sub_in_sub_id": sub_in_sub_id,
                "_token": _token,
            },
            success: function(data) {
                console.log(data.slug);
                $("#sub_in_sub_id").val(data.sub_in_sub_id);
                $("#sub_in_sub_cat_name").val(data.sub_in_sub_cat_name);
                $("#status").val(data.status);
                $("#sub_cat_id").val(data.sub_cat_id);
                $("#slug").val(data.slug);
                $("#category_id").val(data.category_id);
            }
        });
        $('#modal-animation-3').modal('show');
    }

    $(document).ready(function() {
        //alert("test");
        featch_list();
        console.log("test");

        function featch_list(query = '') {
            console.log("bijon");
            $.ajax({
                url: "<?php echo e(route('listByInSubCategory.search')); ?>",
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
            featch_list(query);
        });

    });

    function getCategoryVal(category_id) {
        $.ajax({
            type: "get",
            url: '<?php echo e(URL::to("admin/get-sub-category")); ?>',
            data: {
                category_id: category_id,
                _token: $('#token').val()
            },
            dataType: 'json',
            success: function(response) {
                $("#sub_cat_id").empty();
                remove_subcat();
                $.each(response, function(index, subcategory) {
                    $("#sub_cat_id").append('<option value="' + subcategory.sub_cat_id + '">' +
                        subcategory.sub_cat_name + '</option>');
                });
                // $("select[name=district_id]").val(response.district_id);
            }

        });

    }

    function remove_insubmenu() {
        $('#sub_in_sub_id').append('<option selected="selected" value="">Select</option>');
    }

    function remove_subcat() {
        $('#sub_cat_id').append('<option selected="selected" value="">Select</option>');
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/admin/pages/category/inSubategorylist.blade.php ENDPATH**/ ?>