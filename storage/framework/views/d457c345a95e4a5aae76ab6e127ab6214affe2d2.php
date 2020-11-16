<?php $__env->startSection('title','Product List'); ?>
<?php $__env->startSection('maincontent'); ?>
<style>
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
<link href="<?php echo e(url('admin/assets/products.css')); ?> " rel="stylesheet" />
<div class="content-wrapper">
	<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Product</strong> List</span>
			<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();" style="color:yellow; display: none;">
				<i class="fa fa-plus"></i> Create a Product </a>

		</div>
	</div>

	<!--Start Dashboard Content-->
	<div id="myProgress">
		<div id="myBar"></div>
	</div>

	<div id="showcattext"></div>
	<ul class="loading-animation alternate" style="display:none;" id="catloader">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>

	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">

				<ul class="nav nav-tabs nav-tabs-info nav-justified">
				</ul>
				<form method="POST" action="<?php echo e(url('admin/filterProducts')); ?>">
					<!-- Tab panes -->
					<div class="tab-content" id="tab-content-loading">
						<div id="tabe-13" class="container-fluid tab-pane active">

							<div class="row">

								<div class="col-md-3">
									<select name="selectbatch" style="padding: 10px;" class="form-control" id="selectbatch" onchange="clearBar();">
										<option value="">Select Batch</option>
										<?php
										for ($i = 1; $i <= 500; $i++) {
											echo "<option value=" . $i . ">" . 'Batch ' . $i . "</option>";
										}
										?>
									</select>
								</div>

								<div class="col-md-3">

									<button class="btn btn-danger btn-block" onclick="downloadApiData();" id="import" type="button">
										<i aria-hidden="true" class="fa fa-refresh"></i> &nbsp;Syntronic</button>

								</div>
								<input type="hidden" name="maxlimit" value="200" id="maxlimit" />

								<div class="col-md-3">
									<?php echo e(csrf_field()); ?>

									<div class="form-group" style="text-align: right;">
										<select name="filterBatch" class="form-control" id="filterBatch" required>
											<option value="">Filter Batch</option>
											<?php
											for ($i = 1; $i <= 500; $i++) {
												echo "<option value=" . $i . ">" . 'Filter Batch-' . $i . "</option>";
											}
											?>
										</select>
										<input type="hidden" name="maxLimit" id="maxLimit" value="200" placeholder="Max Limit" />
									</div>

								</div>
								<div class="col-md-3">
									<button type="submit" class="btn btn-primary btn-block" id="btnSearch">Search</button>
								</div>

							</div>

							<center>
								<div class="loader" style="display: none;;"></div>
							</center>
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead class="thead-primary">
										<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
											<th>SL</th>
											<th>Product Id</th>
											<th>Category</th>
											<th>Product Name</th>
											<th>Price</th>
											<th>Stock Qty</th>
											<th>Batch</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody class="showproduct">
									</tbody>
								</table>

							</div>
						</div>

					</div>
				</form>
			</div>
		</div>

	</div>
</div>
</div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
	<form id="cform" enctype="multipart/form-data" action="<?php echo e(url('/admin/SaveProduct')); ?>" method="post">
		<?php echo e(csrf_field()); ?>

		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Add Product</h5>
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
					<button type="submit" id="submitproduct" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- Modal -->

<script src="<?php echo e(url('admin/assets/js/jquery.min.js')); ?>"></script>
<script>
	var i = 0;

	function move() {
		if (i == 0) {
			i = 1;
			var elem = document.getElementById("myBar");
			var width = 1;
			var id = setInterval(frame, 10);

			function frame() {
				if (width >= 100) {
					clearInterval(id);
					i = 0;
				} else {
					width++;
					elem.style.width = width + "%";
				}
			}
		}
	}

	function getPercentage() {
		var regular_price = parseInt($('#regular_price').val());
		var percentage = parseInt($('#percentage').val());
		var totalValue = regular_price * ((100 - percentage) / 100);
		var result = parseInt(totalValue.toFixed(2));
		$('#special_price').val(result);
	}

	function validation(val) {
		if (/\D/g.test(val))
			val = val.replace(/\D/g, '');
	}

	function emptyfrm() {
		$('#cform')[0].reset();
	}

	function convertToSlug(str) {
		str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
		str = str.replace(/^\s+|\s+$/gm, '');
		str = str.replace(/\s+/g, '-');
		$("#slug").val(str);
	}

	function checkProductCode(product_code) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "product/searhProductCode/" + product_code,
			data: {
				"product_code": product_code,
				"_token": _token,
			},
			success: function(data) {
				chk = data;
				if (chk == 1) {
					$("#submitproduct").prop("disabled", true);
					$("#filterBatch").prop("disabled", true);
					$("#msg").text("Sorry already exits.");
				} else {
					$("#msg").text("Available Product Code");
					$("#submitproduct").prop("disabled", false);
					$("#filterBatch").prop("disabled", false);
				}
			}
		});
	}

	function createproduct(id) {
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
	// Edit
	function getbyId(product_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "product/searhProductId/" + product_id,
			data: {
				"product_id": product_id,
				"_token": _token,
			},
			success: function(data) {
				var id = data.product_id;
				urls = "editproduct/" + product_id;
				//window.open(urls);
				location.href = "editproduct/" + product_id;
			}
		});
	}
	$(document).ready(function() {
		featch_list(query = '');
	});

	// function featch_list(query = '') {
	// 	$("#loader").show();
	// 	var selectBatch = $("#selectbatch").val();
	// 	//.	console.log(selectBatch);
	// 	var maxlimit = $("#maxlimit").val();
	// 	var _token = $("input[name='_token']").val();
	// 	$.ajax({
	// 		url: "<?php echo e(route('listByProduct.search')); ?>",
	// 		method: 'GET',
	// 		data: {
	// 			"selectBatch": selectBatch,
	// 			"maxlimit": maxlimit,
	// 			"_token": _token,
	// 		},
	// 		dataType: 'json',
	// 		success: function(data) {
	// 			$('.showproduct').html(data.table_data);
	// 			$("#loader").hide();
	// 		}
	// 	})
	// }

	function getinSubCategory(sub_cat_id) {
		console.log(sub_cat_id);
	}

	function getSubCategory(category_id) {
		console.log(category_id);
	}

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

				$.each(response, function(index, subcategory) {
					$("#sub_cat_id").append('<option value="' + subcategory.sub_cat_id + '">' +
						subcategory.sub_cat_name + '</option>');
				});
			}
		});
	}

	function getSubInCategoryVal(sub_cat_id) {
		condition(sub_cat_id);
		$.ajax({
			type: "get",
			url: '<?php echo e(URL::to("admin/sub-in-sub-category")); ?>',
			data: {
				sub_cat_id: sub_cat_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(response) {
				$("#sub_in_sub_id").empty();
				$.each(response, function(index, insubmenu) {
					$("#sub_in_sub_id").append('<option value="' + insubmenu.sub_in_sub_id + '">' +
						insubmenu.sub_in_sub_cat_name + '</option>');
				});
			}
		});
	}

	function clearBar() {
		$('#myBar').empty();
	}

	function downloadApiData() {
		$('#myBar').empty();
		var selectBatch = $("#selectbatch").val();
		var maxlimit = $("#maxlimit").val();
		var bar = $('.bar');
		var percent = $('.percent');
		var status = $('#status');

		if (selectBatch == "") {
			alert("Please select batch...");
		} else {
			$(".loader").show();
			var _token = $("input[name='_token']").val();

			$.ajax({
				url: "<?php echo e(route('apilistByProduct.search')); ?>",
				data: {
					"selectBatch": selectBatch,
					"maxlimit": maxlimit,
					"_token": _token,
				},

				method: 'GET',
				dataType: 'json',
				beforeSend: function() {
					console.log("Product download");
					$('#import').attr('disabled', 'disabled');
					$("#filterBatch").prop("disabled", true);
					$("#btnSearch").prop("disabled", true);
				},

				success: function(data) {
					$(".loader").hide();
					featch_list(query = '');
					$('#import').attr('disabled', false);
					$("#filterBatch").prop("disabled", false);
					$("#btnSearch").prop("disabled", false);
					move()
					downloadCategory();
				}
			})
		}

	}

	function downloadCategory() {
		var _token = $("input[name='_token']").val();
		$("#catloader").show();
		var selectBatch = $("#selectbatch").val();
		var maxlimit = $("#maxlimit").val();

		$.ajax({
			url: "<?php echo e(route('downloadCategory.search')); ?>",
			data: {
				"selectBatch": selectBatch,
				"maxlimit": maxlimit,
				"_token": _token,
			},
			method: 'GET',
			dataType: 'json',
			beforeSend: function() {
				$('#showcattext').html('<b><h2>Category Download ..</b></h2>'); //showcattext
				$('#import').attr('disabled', 'disabled');
				$("#filterBatch").prop("disabled", true);
				$("#btnSearch").prop("disabled", true);
			},
			success: function(data) {
				$("#catloader").hide();
				$('#showcattext').text('');
				featch_list(query = '');
				console.log("success category");
				$('#import').attr('disabled', false);
				$("#filterBatch").prop("disabled", false);
				$("#btnSearch").prop("disabled", false);
				downloadSubCategory();
			}
		})
	}

	function downloadSubCategory() {

		var selectBatch = $("#selectbatch").val();
		var maxlimit = $("#maxlimit").val();

		var _token = $("input[name='_token']").val();
		$("#catloader").show();
		$.ajax({
			url: "<?php echo e(route('downloadsubCategory.search')); ?>",
			data: {
				"selectBatch": selectBatch,
				"maxlimit": maxlimit,
				"_token": _token,
			},
			method: 'GET',
			dataType: 'json',
			beforeSend: function() {
				$('#showcattext').html('<b><h3>Sub Category Download</b></h3>'); //showcattext
				$('#import').attr('disabled', 'disabled');
				$("#filterBatch").prop("disabled", true);
				$("#btnSearch").prop("disabled", true);
			},
			success: function(data) {
				$("#catloader").hide();
				$('#showcattext').text('');
				featch_list(query = '');
				console.log("success category");
				$('#import').attr('disabled', false);
				$("#filterBatch").prop("disabled", false);
				$("#btnSearch").prop("disabled", false);
				downloadInSubCategory();
			}
		})
	}

	function downloadInSubCategory() {
		var selectBatch = $("#selectbatch").val();
		var maxlimit = $("#maxlimit").val();
		var _token = $("input[name='_token']").val();
		$("#catloader").show();
		$.ajax({
			url: "<?php echo e(route('getInsertInSubCategorys.search')); ?>",
			data: {
				"selectBatch": selectBatch,
				"maxlimit": maxlimit,
				"_token": _token,
			},
			method: 'GET',
			dataType: 'json',
			beforeSend: function() {
				$('#showcattext').html('<b><h4>In Sub Category Download</b></h4>'); //showcattext
				$('#import').attr('disabled', 'disabled');
				$("#filterBatch").prop("disabled", true);
				$("#btnSearch").prop("disabled", true);
			},
			success: function(data) {
				$("#catloader").hide();
				$('#showcattext').text('');
				featch_list(query = '');
				console.log("In Sub Category");
				$('#import').attr('disabled', false);
				$("#filterBatch").prop("disabled", false);
				$("#btnSearch").prop("disabled", false);

			}
		})
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/admin/pages/product/productlist.blade.php ENDPATH**/ ?>