@extends('admin.master')
@section('title','Special Category List')
@section('maincontent')
<style>
    .widthtxt {
        width: 100%;

    }

    .modal-lg {
        max-width: 100% !important;
        margin-left: 20px;
        margin-right: 20px;
    }

    .table td,
    .table th {
        padding: .1rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .card .table td,
    .card .table th {
        padding-right: .5rem;
        padding-left: .5rem;
    }
</style>

<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <?php
                if (isset($selectbatch)) {
                    echo $selectbatch;
                }
                ?>

                <div class="container-fluid">
                    <br>
                    <form enctype="multipart/form-data" id="upload_form" class="form-inline" method="post" action="{{ url('admin/special-category-product')}}">
                        {{ csrf_field() }}
                        <div class="col-md-3">
                            <select name="filterBatch" id="filterBatch" style="width: 100%;" class="form-control">
                                <option value="">Select Batch</option>
                                <?php
                                for ($i = 1; $i <= 1000; $i++) {
                                    echo "<option value=" . $i . ">" . 'Batch ' . $i . "</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <div class="col-md-3">
                            <input type="text" name="product_name" placeholder="Enter your product name" style="width: 100%;" class="form-control" />

                        </div>

                        <div class="col-md-3">
                            <input type="text" name="product_code" placeholder="Enter your product code" style="width: 100%;" class="form-control" />

                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">FIND</button>

                        </div>
                        </form>

                        <div class="table-responsive">
                            <br>
                            <table class="table table-striped table-hover" style="width: 100%;">
                                <thead>
                                    <tr style="border-radius: 0 6px 0 0;" class="bg btn-primary">
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Special Category</th>
                                        <th>Batech</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $x = 1;
                                    if (!empty($product)) {
                                    ?>
                                        @foreach($product as $i)
                                        @if($i->status == 0)
                                        <?php
                                        $status = "Not Publish";
                                        $color = 'red';
                                        ?>
                                        @else
                                        <?php
                                        $status = " Publish";
                                        $color = 'green';
                                        ?>
                                        @endif
                                        <tr style="border-radius: 0 6px 0 0;">

                                            <td>{{ $i->api_id }}</td>
                                            <td>
                                                <?php
                                                if (strlen($i->product_name) > 40) {
                                                    echo substr($i->product_name, 0, 40) . '...';
                                                }

                                                ?> </td>
                                            <td>{{ $i->sp_category_name }}</td>
                                            <td>{{ $i->batch }}</td>

                                            <td style="background-color: {{ $color }}; color: white;">{{ $status }}</td>
                                            <td onclick="showproduct('<?php echo $i->api_id; ?>')">Show</td>
                                        </tr>
                                        @endforeach
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                   
                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>
</div>
</div>
</div>


<div class="modal fade" id="modal-animation-3">
<form enctype="multipart/form-data" id="cform" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg ">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-check"></i> Add Special Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#one" role="tab" aria-controls="pills-home" aria-selected="true">Particular Information</a>
                        </li>
                        <li class="nav-item" style="display: none;">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#two" role="tab" aria-controls="pills-profile" aria-selected="false">Product Upload</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="pills-home-tab">
                    
                            <div class="row">
                                <div class="col-md-8">

                                    <div class="form-group row">
                                        <label for="basic-input" class="col-sm-3 col-form-label">Product Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="product_name" readonly class="form-control" name="product_name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="disabled-input" class="col-sm-3 col-form-label">Slug</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="slug" readonly placeholder="Slug" class="form-control">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="readonly-input" class="col-sm-3 col-form-label">SKU</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="product_code" readonly class="form-control">
                                        </div>
                                    </div>

                                    <input type="hidden" id="api_id" name="api_id" class="form-control">
                                    <input type="hidden" id="qty" name="qty" class="form-control" value="1">
                                    <div class="form-group row">
                                        <label for="basic-select" class="col-sm-3 col-form-label" style="color: red; font-weight: bold;;">Select
                                            Special Category</label>
                                        <div class="col-sm-9">

                                            <select id="special_cat_id" name="special_cat_id" required="required" class="form-control">
                                                <option value="">Select</option>
                                                <?php
                                                if (!empty($sp_category)) {
                                                    foreach ($sp_category as $val) {
                                                ?>
                                                        <option value="<?php echo $val->special_cat_id; ?>">
                                                            <?php echo $val->sp_category_name; ?>
                                                        </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="basic-textarea" class="col-sm-3 col-form-label">Product
                                            Description</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" readonly id="pro_long_description" placeholder="Description" style="width: 100%;"></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="multiple-select" class="col-sm-3 col-form-label">Type</label>
                                        <div class="col-sm-9">
                                            <!-- <textarea rows="4" class="form-control" name="pro_long_description" id="pro_long_description"></textarea> -->
                                            <select id="entry_type" readonly class="form-control" style="width: 100%;">
                                                <option value="1" selected>Dynamic</option>
                                                <option value="0">Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="multiple-select" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select id="status" name="status" class="form-control" style="width: 100%;">
                                                <option value="1" selected>Publish</option>
                                                <option value="0">Not Publish</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="multiple-select" class="col-sm-5 col-form-label">Regular Price</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="regular_price" readonly class="form-control" placeholder="0.00" required style="text-align:right;" onkeyup="if (/\D/g.test(this.value))
                                                           this.value = this.value.replace(/\D/g, '')">
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="multiple-select" class="col-sm-5 col-form-label">Special Price</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="special_price" readonly placeholder="0.00" class="form-control" style="text-align:right;" onkeyup="getPercentage();">
                                        </div>
                                    </div>

                                    <div class="card card-primary">
                                        <span id="insertedImages"></span>
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Thumbnail Preview</h5>

                                            <div class="row">
                                                <span id="multipleImg"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="button" id="btnSave" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Small modal -->
<div class="modal fade" id="modal-animation-4">
        <div class="modal-dialog">
            <div class="modal-content border-primary">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i>Success</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2>Successfully Save..</h2>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                </div>
            </div>
        </div>
 
</div>
<?php
$filter = "";
if (!empty($filterBatch)) {
    $filter = $filterBatch;
} ?>

<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<script>
  // ajax post
	$(".btn-submit").click(function(e) {
		e.preventDefault();
      //  alert("Test");
		var _token = $("input[name='_token']").val();
		var api_id = $("input[name=api_id]").val();
		var special_cat_id = $("#special_cat_id").val();
		var status = $("select[name=status]").val();
		if (special_cat_id == '') {
			alert("Please select your category.");
			$("#special_cat_id").focus();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: "{{url('admin/updateProducts')}}",
			dataType: "json",
			data: {
				_token: _token,
				api_id: api_id,
				special_cat_id: special_cat_id,
				status: status
			},
			success: function(data) {
                $('#modal-animation-3').modal('hide');
				$('#modal-animation-4').modal('show');
				$("#cform")[0].reset();
                    setTimeout(function(){
                        $('#modal-animation-4').modal('hide');
                        location.reload();
                        },2000); 
			}
		});
	});
    function showproduct(id) {
        firstThamnailPreviewImg(id);
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "product/findproductSearch/" + id,
            success: function(data) {
                //console.log(data);
                var content = data.pro_long_description.replace(/<[^>]+>/g, '');
                //content.split(" ").join("\n")
                $('#product_name').val(data.product_name);
                $('#slug').val(data.slug);
                $('#product_code').val(data.product_code);
                $('#pro_long_description').text(content);
                $('#regular_price').val(data.regular_price);
                $('#api_id').val(data.api_id);
                $('#orginal_price').val(data.regular_price);
                $('#special_price').val(data.regular_price);
                $('#category_id').val(data.category_id);
                $('#sub_cat_id').val(data.sub_cat_id);
                $('#sub_in_sub_id').val(data.sub_in_sub_id);
                $('#remarks').val(data.remarks);
                $('#special_cat_id').val(data.special_cat_id);
                $('#status').val(data.status);
                $("#modal-animation-3").modal('show');

            }
        });
    }

    function firstThamnailPreviewImg(product_id) {
        multipleThamnailPreviewImg(product_id);
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "product/thamnailPreviewImg/" + product_id,
            success: function(data) {
                var img = '<img src="' + data.guid +
                    '"style="height: 350px; width: 100%; border-radius: 8px;border: 5px solid #555;" id="insertedImages" class="card-img-top">';
                $("#insertedImages").html(img);
            }
        });
    }

    function multipleThamnailPreviewImg(product_id) {
        $.ajax({
            type: 'GET',
            url: "product/multiplethamnailPreviewImg/" + product_id,
            success: function(data) {
                $("#multipleImg").html(data);
            }
        });
    }
    $(document).ready(function() {
        $("#filterBatch").val("<?php echo $filter; ?>");
    });
</script>

@endsection