<?php $__env->startSection('title','Product List'); ?>
<?php $__env->startSection('maincontent'); ?>
<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>
<div class="content-wrapper">
	<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Product</strong> List</span>

<?php 
	if(count($sellerProduct) >= 4){
?>
			Already Limit Finish.
	<?php }else{ ?>
		<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();" style="color:black; font-size: 15px; font-weight: bod; ">
				<i class="fa fa-plus"></i> Create a Product [upload limit 4]</a>
	<?php } ?>
		</div>
	</div>
	<!--Start Dashboard Content-->

	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div style="color:green; text-align: center;"><?php
																$messages = Session::get('product_entry');
																if (!empty($messages)) {
																	echo $messages;
																	session::put('product_entry', null);
																}
																?></div>
				<!-- Tab panes -->
				<div class="tab-content">
					<div id="tabe-13" class="container-fluid tab-pane active">


						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width: 100%; color:#fff;">
								<thead>
									<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
										<th>SL</th>
										<th>Product Name</th>
										<th>SKU</th>
										<th>Category</th>
										<th>Sub Category</th>
										<th>1st Photo</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$x=1;
								?>
								<?php $__currentLoopData = $sellerProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
								  if($value->status == 1){
									 $status =  'Publish';
								  }else{
									$status =  'Not Publish';
								  }
								?>
								<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
										<td><?php echo e($index +1); ?></td>
										<td><?php echo e(substr($value->product_name, 0, 28) . '...'); ?></td>
										<td><?php echo e($value->product_code); ?></td>
										<td><?php echo e($value->category_name); ?></td>
										<td><?php echo e($value->sub_cat_name); ?></td>
										
										<td><img src="<?php echo e(url('admin/'.$value->photo1)); ?>" style="height:100px; width: 100px;"/></td>
										<td><?php echo e($status); ?></td>
										<td><a href="#" onclick="getbyId('<?php echo $value->product_id;?>')">Edit</a></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>

						</div>
					</div>


				</div>
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

					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group row">
										<label for="basic-input" class="col-sm-3 col-form-label">Product Name</label>
										<div class="col-sm-9">
											<input type="text" id="product_name" name="product_name" required="required" class="form-control" name="product_name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)">
										</div>
									</div>

									<div class="form-group row" style="display: none;">
										<label for="disabled-input" class="col-sm-3 col-form-label">Slug</label>
										<div class="col-sm-9">
											<input type="text" id="slug" name="slug" placeholder="Slug" class="form-control">

										</div>
									</div>

									<div class="form-group row">
										<label for="readonly-input" class="col-sm-3 col-form-label">SKU</label>
										<div class="col-sm-9">
											<input type="text" id="product_code" name="product_code" required="required" class="form-control" onkeydown="checkProductCode(this.value);">
											<span id="sku_msg" style="color: red; font-weight: bod;"></span>

										</div>
									</div>


									<input type="hidden" id="qty" name="qty" class="form-control" value="1">
									<input type="hidden" id="product_id" name="product_id" />

									<div class="form-group row">
										<label for="basic-select" class="col-sm-3 col-form-label">Select
											Category</label>
										<div class="col-sm-9">

											<select id="category_id" name="category_id" required="required" onchange="getCategoryVal(this.value);" style="width: 100%;">
												<option value="">--Select--</option>
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
											<select id="sub_cat_id" name="sub_cat_id" required="required" onchange="getSubInCategoryVal(this.value);" style="width: 100%;">
												<option value="">--Select--</option>
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
											<select id="sub_in_sub_id" name="sub_in_sub_id" required="required" style="width: 100%;">
												<option value="">--Select--</option>
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
											<select id="brand_id" name="brand_id" style="width: 100%;" required="required">
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

									<div class="form-group row" style="display: none;">
										<label for="multiple-select" class="col-sm-3 col-form-label">Type</label>
										<div class="col-sm-9">
											<select id="entry_type" name="status" class="form-control" style="width: 100%;">
												<option value="0" selected>Dynamic</option>
												<option value="0">Manual</option>
											</select>
										</div>
									</div>
									<div class="form-group row" style="display: none;">
										<label for="multiple-select" class="col-sm-3 col-form-label">Status</label>
										<div class="col-sm-9">
											<select id="status" name="status" class="form-control" style="width: 100%;">
												<option value="0" selected>Publish</option>
												<option value="1">Not Publish</option>
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

									<div class="form-group row">
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
										<div class="card-body">
											<img id="img1" width="100" height="100" style="border-radius: 8px;border: 1px solid #555;" />
											<img id="img2" width="100" height="100" style="border-radius: 8px;border: 1px solid #555;"/>
											<img id="img3" width="100" height="100" style="border-radius: 8px;border: 1px solid #555;"/>
										
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label" style="color: white;">1.
													Product Image 1 </label>
											
												<input type="file" id="file-input1" name="photo1" onchange="document.getElementById('img1').src = window.URL.createObjectURL(this.files[0])">
												<span id="editimg1"></span>
											</div>
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label" style="color: white;">2.
													Product Image 2</label>
												<input type="file" id="file-input2" name="photo2" onchange="document.getElementById('img2').src = window.URL.createObjectURL(this.files[0])">
												<span id="editimg2"></span>
											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label" style="color: white;">3.
													Product Image 3</label>
												<input type="file" id="file-input3" name="photo3" onchange="document.getElementById('img3').src = window.URL.createObjectURL(this.files[0])">
												<span id="editimg3"></span>
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

	function getPercentage() {
		var regular_price = parseInt($('#regular_price').val());
		var percentage = parseInt($('#percentage').val());
		var totalValue = regular_price * ((100 - percentage) / 100);
		var result = parseInt(totalValue.toFixed(2));
		$('#special_price').val(result);
	}


	function emptyfrm() {
		$('#cform')[0].reset();
	}
	// Data Table List View
	function convertToSlug(str) {
		str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
		str = str.replace(/^\s+|\s+$/gm, '');
		str = str.replace(/\s+/g, '-');
		$("#slug").val(str);
	}

	function checkProductCode(product_code) {
		console.log(product_code);
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
				if (data == 1) {
					$("#submitproduct").prop("disabled", true);
					$("#sku_msg").text("Sorry already exits.");
					$("#product_code").focus();
				} else {
					$("#sku_msg").text("Available SKU");
					$("#submitproduct").prop("disabled", false);
				}
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
				var img1 = '<img src="' + data.photo1 + '"style="height: 80px; width: 80px; border-radius: 3px;border: 2px solid #555;" id="editimg1" class="card-img-top">';
				$("#editimg1").html(img1);
				
				var img2 = '<img src="' + data.photo2 + '"style="height: 80px; width: 80px; border-radius: 3px;border: 2px solid #555;" id="editimg2" class="card-img-top">';
				$("#editimg2").html(img2);

				var img3 = '<img src="' + data.photo3 + '"style="height: 80px; width: 80px; border-radius: 3px;border: 2px solid #555;" id="editimg3" class="card-img-top">';
				$("#editimg3").html(img3);

				var content = data.pro_long_description.replace(/<[^>]+>/g, '');
				$('#product_name').val(data.product_name);
				$('#slug').val(data.slug);
				$('#product_code').val(data.product_code);
				$('#pro_long_description').text(content);
				$('#regular_price').val(data.regular_price);
				$('#product_id').val(data.product_id);
				$('#orginal_price').val(data.regular_price);
				$('#special_price').val(data.regular_price);
				$('#category_id').val(data.category_id);
				$('#sub_cat_id').val(data.sub_cat_id);
				$('#sub_in_sub_id').val(data.sub_in_sub_id);
				$('#percentage').val(data.percentage);
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

	// Category 
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
					$("#sub_cat_id").append('<option value="' + subcategory.sub_cat_id + '">' + subcategory.sub_cat_name + '</option>');
				});
			}
		});
	}

	function getSubInCategoryVal(sub_cat_id) {
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
					$("#sub_in_sub_id").append('<option value="' + insubmenu.sub_in_sub_id + '">' + insubmenu.sub_in_sub_cat_name + '</option>');
				});
			}
		});
	}
	 
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/admin/pages/product/sellerproductlist.blade.php ENDPATH**/ ?>