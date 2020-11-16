@extends('admin.master')
@section('title',$title)
@section('maincontent')
<link href="{{ url('admin/assets/products.css')}} " rel="stylesheet" />
<style>
.modal-lg {
max-width: 100% !important;
margin-left: 20px;
margin-right: 20px;
}
</style>
<div class="content-wrapper">
<div class="alert alert-success alert-dismissible" role="alert">
<div class="alert-icon">
<i class="icon-check"></i>
</div>
<div class="alert-message">
	<span id="showcattexts"></span>
<span><strong>Product</strong> List Batech: {{ $filterBatch }}</span>
<input type="hidden" name="selectbatch" id="selectbatch" value="{{ $filterBatch }}"/>

</div>
</div>
<div class="row">
<div class="col-lg-12">
<form enctype="multipart/form-data" method="post" action="{{ url('admin/updatestatusProducts') }}">
{{ csrf_field() }}
<div class="row">
<div class="col-md-6">
    <button class="btn btn-primary btn-block" id="optimizedImg" type="button" data-toggle="modal" data-target="#exampleModalCenter">Optimized Image</button>
</div>
<div class="col-md-6">
    <button class="btn btn-primary btn-block" id="process" type="submit" onclick="submit();">Process</button>
</div>

</div>
<div class="card" style="padding: 10px;">
<table width="100%" border="0">
    <tr>
        <td valign="top">SL</td>
        <td valign="top">
            <label><input type="checkbox" onclick="$('input[name*=\'product_id\']').prop('checked', this.checked);" /></label>
        </td>
        <td colspan="3" valign="top">&nbsp;</td>

    </tr>
    <?php
    $x = 1;
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
    <tr>
        <td width="28" valign="top"><?php echo $x;
                                    $x++; ?></td>
        <td width="25" valign="top">
            <input type="checkbox" name="product_id[]" value="{{ $i->product_id }}" />
        </td>
        <td width="189" valign="top"><b>Product ID </b></td>
        <td width="10" valign="top">
            <div align="center">:</div>
        </td>
        <td width="794" valign="top" style="color: blue; font-weight: bold;"> &nbsp;{{ $i->api_id }}
            <button type="button" onclick="showproduct('<?php echo $i->api_id; ?>')">Show Details</td>

    </tr>
    <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Product Name </td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;{{ $i->product_name }}</td>
        <td width="26%" rowspan="7">
            @if(!empty($i->photo1))
            <img src="{{ url('admin/'.$i->photo1) }}" style="height: 180px; width: 100%; width: 100%; border-radius: 8px;border: 5px solid #555;" class="card-img-top" />
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Category </td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;<?php echo $i->category_name ? $i->category_name : "<b style='color: red;'>N/A</b>"; ?></td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Sub Category </td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;<?php echo $i->sub_cat_name ? $i->sub_cat_name : "<b style='color: red;'>N/A</b>"; ?></td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Price </td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;{{ $i->regular_price }}</td>
    </tr>
    <tr valign="top" style="background-color: #d2d1d1;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><b>Special Category</b></td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;<?php echo $i->sp_category_name ? $i->sp_category_name : "<b style='color: red;'>N/A</b>"; ?></td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Stock Quantity </td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;{{ $i->stock_quantity }}</td>
    </tr>
    <tr valign="top" style="background-color: {{ $color }}; color: white;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Status </td>
        <td>
            <div align="center">:</div>
        </td>
        <td>&nbsp;{{ $status }}</td>
    </tr>
    @endforeach

</table>

</div>
</form>
	
<!-- Modal -->

<div class="modal fade" id="modal-animation-3">
<form id="cform" enctype="multipart/form-data" method="post">
{{ csrf_field() }}
<div class="modal-dialog modal-lg ">
    <div class="modal-content animated">
        <div class="modal-header bg-primary">
            <h5 class="modal-title text-white"><i class="fa fa-check"></i> Product</h5>
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
                                    <input type="text" id="product_name" name="product_name" class="form-control" name="product_name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="disabled-input" class="col-sm-3 col-form-label">Slug</label>
                                <div class="col-sm-9">
                                    <input type="text" id="slug" name="slug" placeholder="Slug" class="form-control">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="readonly-input" class="col-sm-3 col-form-label">SKU</label>
                                <div class="col-sm-9">
                                    <input type="text" id="product_code" name="product_code" class="form-control">
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
                                        foreach ($sp_category as $val) {
                                        ?>
                                            <option value="<?php echo $val->special_cat_id; ?>">
                                                <?php echo $val->sp_category_name; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="basic-select" class="col-sm-3 col-form-label">Select
                                    Category</label>
                                <div class="col-sm-9">

                                    <select id="category_id" name="category_id" required="required" class="form-control" onclick="getSubCategory(this.value);">
                                        <option value="">Select Category</option>
                                        <?php
                                        foreach ($category as $val) {
                                        ?>
                                            <option value="<?php echo $val->category_id; ?>">
                                                <?php echo $val->category_name; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="basic-select" class="col-sm-3 col-form-label">Select Sub
                                    Category</label>
                                <div class="col-sm-9">
                                    <select id="sub_cat_id" name="sub_cat_id" required="required" class="form-control" required="required" onclick="getinSubCategory(this.value);">
                                        <option value="">Select Category</option>
                                        <option value="0">None</option>
                                        <?php
                                        foreach ($subcategory as $val) {
                                        ?>
                                            <option value="<?php echo $val->sub_cat_id; ?>">
                                                <?php echo $val->sub_cat_name; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">In sub category</label>
                                <div class="col-sm-9">
                                    <select id="sub_in_sub_id" name="sub_in_sub_id" required="required" class="form-control">
                                        <option value="">Select Category</option>
                                        <option value="0">None</option>
                                        <?php
                                        foreach ($insubcategory as $val) {
                                        ?>
                                            <option value="<?php echo $val->sub_in_sub_id; ?>">
                                                <?php echo $val->sub_in_sub_cat_name; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rounded-input" class="col-sm-3 col-form-label">Brand Name</label>
                                <div class="col-sm-9">
                                    <select id="brand_id" name="brand_id" class="form-control" style="width: 100%;">
                                        <option value="">Select Brand</option>
                                        <?php
                                        foreach ($brand as $val) {
                                        ?>
                                            <option value="<?php echo $val->brand_id; ?>">
                                                <?php echo $val->brand_name; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="basic-textarea" class="col-sm-3 col-form-label">Product
                                    Description</label>
                                <div class="col-sm-9">
                                    <!-- <textarea rows="4" class="form-control" name="pro_long_description" id="pro_long_description"></textarea> -->
                                    <textarea type="text" class="form-control" name="pro_long_description" id="pro_long_description" placeholder="Description" style="width: 100%;"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="basic-select" class="col-sm-3 col-form-label">Product Option</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="pro_option" name="pro_option" style="width: 100%;" onchange="showProducOption(this.value);">
                                        <option value="0">No</option>
                                        <option value="1">Top Part</option>
                                        <option value="2">Bottom Part</option>
                                        <option value="3">Show</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="multiple-select" class="col-sm-3 col-form-label">Product
                                    Vailability</label>
                                <div class="col-sm-9">
                                    <select id="pro_type" class="form-control" name="pro_vailability" style="width: 100%;">
                                        <option value="1">In Stock</option>
                                        <option value="0">Out Of Stock</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="multiple-select" class="col-sm-3 col-form-label">Product
                                    Type</label>
                                <div class="col-sm-9">
                                    <select id="pro_type" class="form-control" name="pro_type" style="width: 100%;">
                                        <option value='1'>New</option>
                                        <option value='0'>Used</option>
                                        <option value='2'>Seller refurbished</option>
                                        <option value='3'>Open box</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="display:none;">
                                <label for="rounded-input" class="col-sm-3 col-form-label">Select Vendor</label>
                                <div class="col-sm-9">
                                    <select id="user_id" name="user_id" class="form-control" style="width: 100%;">
                                        <option value="">Select Vendor</option>
                                        <?php
                                        foreach ($vendor as $val) {
                                        ?>
                                            <option value="<?php echo $val->user_id; ?>">
                                                <?php echo $val->company; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="multiple-select" class="col-sm-3 col-form-label">Type</label>
                                <div class="col-sm-9">
                                    <select id="entry_type" name="status" class="form-control" style="width: 100%;">
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
                                    <input type="text" id="regular_price" required class="form-control" name="regular_price" placeholder="0.00" required style="text-align:right;" onkeyup="if (/\D/g.test(this.value))
                                        this.value = this.value.replace(/\D/g, '')">
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label for="multiple-select" class="col-sm-5 col-form-label">Percentage</label>
                                <div class="col-sm-7">
                                    <input type="text" id="percentage" name="percentage" placeholder="0 %" class="form-control" style="text-align:right;" onkeyup="getPercentage();" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="multiple-select" class="col-sm-5 col-form-label">Special Price</label>
                                <div class="col-sm-7">
                                    <input type="text" id="special_price" required name="special_price" placeholder="0.00" class="form-control" style="text-align:right;" onkeyup="getPercentage();">
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

                <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="container">

                        <div class="row">
                            <div class="col-md-3" style="background-color: blue; color: white;">
                                <div class="form-group">
                                    <label for="Xlarge-input" class="col-form-label" style="color: white;">1.
                                        Product Image 1 </label>
                                    <input type="file" id="file-input1" name="photo1" onchange="previewProductOne()">

                                </div>
                                <div class="form-group">
                                    <label for="Xlarge-input" class="col-form-label" style="color: white;">2.
                                        Product Image 2</label>
                                    <input type="file" id="file-input2" name="photo2" onchange="previewProductTwo()">
                                </div>

                                <div class="form-group">
                                    <label for="Xlarge-input" class="col-form-label" style="color: white;">3.
                                        Product Image 3</label>
                                    <input type="file" id="file-input3" name="photo3" onchange="previewProductThree()">
                                </div>
                                <div class="form-group">
                                    <label for="Xlarge-input" class="col-form-label" style="color: white;">4.
                                        Product Image 4</label>
                                    <input type="file" id="file-input4" name="photo4" onchange="previewProductFour()">
                                </div>
                                <div class="form-group">
                                    <label for="Xlarge-input" class="col-form-label" style="color: white;">5.
                                        Product Image 5</label>
                                    <input type="file" id="file-input5" name="photo5" onchange="previewProductFive()">
                                </div>

                            </div>
                            <div class="col-md-7" style="background-color: pink;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="img1"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="img2"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="img3"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="img4"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="img5"></div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="Xlarge-input" class="col-form-label">Remarks</label>
                <textarea id="remarks" name="remarks" style="width: 100%;"></textarea>

            </div>

        </div>
        <div class="modal-footer">
            <div id="showmsg" style="text-align: center;"></div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                Close</button>
            <button type="submit" id="btnSave" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
            </button>
        </div>
    </div>
</div>
</form>
</div>
 
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Optimized</h5>
        
      </div>
      <div class="modal-body">
		  <div id="showcattext"></div>
	<ul class="loading-animation alternate" style="display:none;" id="catloader">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul><br>
       <button class="btn btn-primary btn-block" type="button" id="crmOpti" onclick="optimizationImage()">Confirm Optimiz</button>
		
      </div>
		 
    </div>
  </div>
</div>
 
<script>
$("#btnSave").click(function(e) {
e.preventDefault();
var _token = $("input[name='_token']").val();
var product_name = $("#product_name").val();
var api_id = $("#api_id").val();
var slug = $("#slug").val();
var product_code = $("#product_code").val();
var category_id = $("#category_id").val();
var sub_cat_id = $("#sub_cat_id").val();
var sub_in_sub_id = $("#sub_in_sub_id").val();
var brand_id = $("#brand_id").val();
var pro_long_description = $("#pro_long_description").val();
var pro_option = $("#pro_option").val();
var pro_type = $("#pro_type").val();
var entry_type = $("#entry_type").val();
var status = $("#status").val();
var regular_price = $("#regular_price").val();
var special_price = $("#special_price").val();
var special_cat_id = $("#special_cat_id").val();

$.ajax({
    type: 'POST',
    url: "{{ url('/admin/SaveProduct') }}",
    dataType: "json",
    data: {
        _token: _token,
        product_name: product_name,
        slug: slug,
        product_code: product_code,
        api_id: api_id,
        category_id: category_id,
        sub_cat_id: sub_cat_id,
        sub_in_sub_id: sub_in_sub_id,
        brand_id: brand_id,
        pro_long_description: pro_long_description,
        pro_option: pro_option,
        pro_type: pro_type,
        entry_type: entry_type,
        status: status,
        regular_price: regular_price,
        special_cat_id: special_cat_id,
        special_price: special_price
    },
    success: function(data) {
        location.reload();
    }
});
});

function convertToSlug(str) {
str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
str = str.replace(/^\s+|\s+$/gm, '');
str = str.replace(/\s+/g, '-');
$("#slug").val(str);
}

function showproduct(id) {
firstThamnailPreviewImg(id);
$.ajax({
    type: 'GET',
    dataType: "json",
    url: "product/findproductSearch/" + id,
    success: function(data) {
        console.log(data);
        var content = data.pro_long_description.replace(/<[^>]+>/g, '');
        //content.split(" ").join("\n")
        $('#product_name').val(data.product_name);
        $('#slug').val(data.slug);
        $('#product_code').val(data.product_code);
        $('#pro_long_description').text(content);
        //	  CKEDITOR.replace( 'pro_long_description' );
        $('#regular_price').val(data.regular_price);
        $('#api_id').val(data.api_id);
        $('#orginal_price').val(data.regular_price);
        $('#special_price').val(data.regular_price);
        $('#category_id').val(data.category_id);
        $('#sub_cat_id').val(data.sub_cat_id);
        $('#sub_in_sub_id').val(data.sub_in_sub_id);
        $('#brand_id').val(data.brand_id);
        $('#remarks').val(data.remarks);
        $('#special_cat_id').val(data.special_cat_id);

        $('#status').val(data.status);
        if (data.stock_status == "instock") {
            $('#pro_vailability').val(1);
        } else {
            $('#pro_vailability').val(0);
        }
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
        var img = '<img src="' + data.photo1 +
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

function optimizationImage() {
	console.log("working image");
	var _token = $("input[name='_token']").val();
		var selectBatch = $("#selectbatch").val();
		var maxlimit = 200;//$("#maxlimit").val();
		var _token = $("input[name='_token']").val();
		$("#catloader").show();
		$.ajax({
			url: "{{ route('getInsertProductImageGallery.search') }}",
			data: {
				"selectBatch": selectBatch,
				"maxlimit": maxlimit,
				"_token": _token,
			},
			timeout: 500000,
			method: 'GET',
			dataType: 'json',
			beforeSend: function() {
				$('#showcattext').html('<b><h3>Optimize Image ..</b></h3>'); //showcattext
				//$('#import').attr('disabled', 'disabled');
				$("#optimizedImg").prop("disabled", true);
				$("#process").prop("disabled", true);
				$("#crmOpti").prop("disabled", true);
				$('#exampleModalCenter').modal({
				   backdrop: 'static',
				   keyboard: false
   				 })
			},
			success: function(data) {
				$("#catloader").hide();
		    	$('#showcattexts').html('<b><h3>Optimize image successfully done..</b></h3>'); //showcattext
				$("#optimizedImg").prop("disabled", false);
				$("#process").prop("disabled", false);
				$("#crmOpti").prop("disabled", false);
				$('#exampleModalCenter').modal('hide');
			}, 
			 error: function(xmlhttprequest, textstatus, message) {
				if(textstatus==="timeout") {
					alert("got timeout");
				} else {
					$("#catloader").hide();
		    	    $('#showcattexts').html('<b><h3>Optimize image successfully done..</b></h3>'); //showcattext
					$('#exampleModalCenter').modal('hide');
					//alert(textstatus);
				}
			}
		})
	}
</script>
@endsection