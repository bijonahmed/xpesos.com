@extends('admin.master')
@section('title','Product List')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid blue;
		border-bottom: 16px solid blue;
		width: 120px;
		height: 120px;
        position: absolute;
        margin-left: 40% !important;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}

	@-webkit-keyframes spin {
		0% {
			-webkit-transform: rotate(0deg);
		}

		100% {
			-webkit-transform: rotate(360deg);
		}
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}
</style>

<div class="content-wrapper">
	<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Product</strong> List</span>
			<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();" style="color:yellow;">
				<i class="fa fa-plus"></i> Create a Product </a>
		</div>
	</div>
	<!--Start Dashboard Content-->

	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">

				<ul class="nav nav-tabs nav-tabs-info nav-justified">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tabe-13"><i class="icon-home"></i> <span class="hidden-xs">Product List</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tabe-14"><i class="icon-user"></i> <span class="hidden-xs">API Featech Product</span></a>

					</li>

				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div id="tabe-13" class="container-fluid tab-pane active">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="text-align: right; padding: 10px;">
									<input type="text" name="searchproduct" id="searchproduct" placeholder="Search" />
								</div>
							</div>
						</div>
						<center>
							<div class="loader"></div>
						</center>
						<div class="table-responsive">
							<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
								<thead>
									<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
										<th>SL</th>
										<th>Vendor Name</th>
										<th>Category</th>
										<th>In Sub Category</th>
										<th>Product Name</th>
										<th>Code</th>
										<th>%</th>
										<th>Photo</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody class="showproduct">
								</tbody>
							</table>

						</div>
					</div>
					<div id="tabe-14" class="container-fluid tab-pane fade">
						<div style="text-align: right"> <button class="btn btn-danger" onclick="feactchData();"> <i aria-hidden="true" class="fa fa-refresh"></i> &nbsp;Syntronice Data</button></div>
						<br>
                        
                        	<center><div class="loader"></div></center>
						<div class="table-responsive">
							<table class="table-hover" style="width:100%;">
								<thead>
									<tr style="background-color: #4a0c26;color: white; border-radius: 0 6px 0 0">
										<th>SL</th>
                                        <th>Product ID</th>
										<th>ProductName</th>
										<th>Sku</th>
										<th>Price</th>
										<th>Stock Qty</th>
										<th>Image</th>
									</tr>
								</thead>
								<tbody class="ebaytbody">
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
	<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveProduct')}}" method="post">
		{{ csrf_field() }}
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
						<li class="nav-item">
							<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#two" role="tab" aria-controls="pills-profile" aria-selected="false">Product Upload</a>
						</li>

					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="pills-home-tab">

							<div class="row">
								<div class="col-md-4">
									<?php 
                                 $user_id = Session::get('user_id');
                                 $role_id = Session::get('role_id');
                                 if($role_id==1){
                                ?>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Select Vendor</label>
										<select id="user_id" name="user_id" required="required" style="width: 100%;">
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
									<?php }else{ ?>
									<input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}" />
									<?php } ?>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Category</label>
										<select id="category_id" name="category_id" required="required" onchange="getCategoryVal(this.value);" style="width: 100%;">
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
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Sub Category</label><br>

										<select id="sub_cat_id" name="sub_cat_id" onchange="getSubInCategoryVal(this.value);" style="width: 100%;">
											<option value="">Select Sub Category</option>
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

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Sub In Category</label>
										<select id="sub_in_sub_id" name="sub_in_sub_id" style="width: 100%;">
											<option value="">Select in Category</option>

										</select>

									</div>

									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Product Name</label>

										<input type="text" id="post_title" name="product_name" placeholder="Product Name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" style="width: 100%;">
										<input type="hidden" class="form-control" id="product_id" name="product_id">
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Slug</label>
										<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">

									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Quantity</label>
										<input type="text" id="qty" name="qty" placeholder="Quantity" required style="width: 100%;" value="1">

									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Product Code</label>
										<input type="text" id="product_code" name="product_code" placeholder="Product Code" required style="width: 100%;" autcomplete="off" onkeyup="checkProductCode(this.value);">
										<div id="msg" style="color: green; font-size: 18px;"></div>

									</div>

								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Product Brand Name</label>
										<input type="text" id="pro_brand_name" name="pro_brand_name" placeholder="Brand Name" required style="width: 100%;">

									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Product Long
											Description</label>
										<textarea name="pro_long_description" id="pro_long_description" placeholder="Long Description" required style="width: 100%;"></textarea>

									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Product Option</label>
										<select id="pro_option" name="pro_option" style="width: 100%;" onchange="showProducOption(this.value);">
											<option value='0'>No</option>
											<option value='1'>Top Part</option>
											<option value='2'>Bottom Part</option>
											<option value='3'>Show</option>
										</select>
									</div>

									<div class="form-group" style="display:none;">
										<label for="Xlarge-input" class="col-form-label" style="color: green;font-weight: bold;">Vendor Name</label>
										<input type="text" id="vendor_name" name="vendor_name" placeholder="Vendor Name" required style="width: 100%;">

									</div>

									<div class="form-group" style="display:none;">
										<label for="Xlarge-input" class="col-form-label" style="color: green;font-weight: bold;">Original Price</label>
										<input type="text" id="orginal_price" name="orginal_price" placeholder="Original Price" required style="width: 100%;">

									</div>

									<div class="form-group">
										<div id="insertedImages"></div>

									</div>

									<div class="form-group" id="sdate" style="display: none;">
										<label for="Xlarge-input" class="col-form-label" style="color: red;">Today Dell
											(End Date) </label>
										<input type="text" id="schedule_to_date" name="schedule_to_date" placeholder="Schedule Date" style="width: 100%;">

									</div>

								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Regular Price</label>
										<input type="text" id="regular_price" name="regular_price" placeholder="Regular Price" required style="width: 100%;" onkeyup="if (/\D/g.test(this.value))
                                                           this.value = this.value.replace(/\D/g, '')">

									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Percentage</label>
										<input type="text" id="percentage" name="percentage" placeholder="Percentage" style="width: 100%;" onkeyup="getPercentage();">

									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Special Price</label>
										<input type="text" id="special_price" name="special_price" placeholder="Special Price" style="width: 100%;">

									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Product Vailability</label>
										<select id="pro_type" name="pro_vailability" style="width: 100%;">
											<option value='1'>In Stock</option>
											<option value='0'>Out Of Stock</option>
										</select>
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Product Type</label>
										<select id="pro_type" name="pro_type" style="width: 100%;">
											<option value='1'>New</option>
											<option value='0'>Used</option>
											<option value='2'>Seller refurbished</option>
											<option value='3'>Open box</option>

										</select>
									</div>

									<?php 
      $role_id = Session::get('role_id');
      if($role_id==1){
?>

									<div class="form-group">
										<label for="large-input" class="col-form-label">Status</label>
										<select id="status" name="status" style="width: 100%;">
											<option value='1'>Active</option>
											<option value='0'>Inactive</option>
										</select>

									</div>
									<?php } ?>
								</div>

							</div>
							<div id="forPant" style="text-align: center;display: none; color: black; border-radius: 5px;  border-radius: 25px;">
								<div class="row">
									<div class="col-md-2">
										<input type="text" required style="width: 100%; background-color: #dae1e7;" value="28" readonly="">
									</div>
									<div class="col-md-3">
										<input type="text" id="waist_lengh_28" name="bottom_28" placeholder="Waist size" style="width: 100%;" value="Waist : 00 , Length: 00 ">
									</div>

								</div>

								<div class="row">
									<div class="col-md-2">
										<input type="text" required style="width: 100%; background-color: #dae1e7;" value="30" readonly="">

									</div>
									<div class="col-md-3">
										<input type="text" id="waist_lengh_28" name="bottom_30" placeholder="Waist size" style="width: 100%;" value="Waist : 00 , Length: 00 ">
									</div>

								</div>
								<div class="row">
									<div class="col-md-2">
										<input type="text" required style="width: 100%; background-color: #dae1e7;" value="32" readonly="">

									</div>
									<div class="col-md-3">
										<input type="text" id="waist_lengh_28" name="bottom_32" placeholder="Waist size" style="width: 100%;" value="Waist : 00 , Length: 00 ">
									</div>

								</div>
								<div class="row">
									<div class="col-md-2">
										<input type="text" required style="width: 100%; background-color: #dae1e7;" value="34" readonly="">

									</div>
									<div class="col-md-3">
										<input type="text" id="waist_lengh_28" name="bottom_34" placeholder="Waist size" style="width: 100%;" value="Waist : 00 , Length: 00 ">
									</div>

								</div>
								<div class="row">
									<div class="col-md-2">
										<input type="text" required style="width: 100%; background-color: #dae1e7;" value="36" readonly="">

									</div>
									<div class="col-md-3">
										<input type="text" id="waist_lengh_28" name="bottom_36" placeholder="Waist size" style="width: 100%;" value="Waist : 00 , Length: 00 ">
									</div>

								</div>
							</div>

							<div id="shoe" style="text-align: center;display: none; color: black; border-radius: 5px;  border-radius: 25px;">
								<div class="row">
									<div class="col-md-12">
										<label for="large-input" class="col-form-label">Shoe Size</label>
										<select id="shoe_size" name="shoe_size" style="width: 100%;">
											<option>Select Shoe Size</option>
											<option value='2/35'>2/35</option>
											<option value='3/36'>3/36</option>
											<option value='4/37'>4/37</option>
											<option value='5/38'>5/38</option>
											<option value='6/39'>6/39</option>
											<option value='7/40'>7/40</option>
											<option value='8/41'>8/41</option>
											<option value='9/42'>9/42</option>

										</select>
									</div>
								</div>

							</div>

							<div id="showProductOption" style="display: none;">
								<center style="color: green; font-weight: bold; font-size: 20px;">Top Part</center>
								<ul class="nav nav-tabs nav-tabs-primary" style="background-color: #dae1e7;">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#tabe-1" onclick="setValueforSmall();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">S
												(Small)</span></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabe-2" onclick="setValueforMedium();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">M
												(Medium)</span></a>
									</li>

									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabe-3" onclick="setValueforlarge();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">L
												(Large)</span></a>
									</li>

									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabe-4" onclick="setValueforextralarge();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">XL (Extra
												Large)</span></a>
									</li>

									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabe-5" onclick="setValueforxxl();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">XXL (extra
												extra Large)</span></a>
									</li>

								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div id="tabe-1" class="container tab-pane active"><br>
										<div class="form-group">
											<label>Length</label>
											<input type="hidden" name="s" id="s" value="S" />
											<input type="hidden" name="m" id="m" />
											<input type="hidden" name="l" id="l" />
											<input type="hidden" name="xl" id="xl" />
											<input type="hidden" name="xxl" id="xxl" />

											<input type="text" placeholder="Length" style="width: 100%;" name="s_length">
										</div>
										<div class="form-group">
											<label>Height</label>
											<input type="text" placeholder="Height" style="width: 100%;" name="s_height">
										</div>
										<div class="form-group">
											<label>Width</label>
											<input type="text" placeholder="Width" style="width: 100%;" name="s_width">
										</div>

									</div>
									<div id="tabe-2" class="container tab-pane fade">

										<div class="form-group">
											<label>Length</label>
											<input type="text" placeholder="Length" style="width: 100%;" name="m_length">
										</div>
										<div class="form-group">
											<label>Height</label>
											<input type="text" placeholder="Height" style="width: 100%;" name="m_height">
										</div>
										<div class="form-group">
											<label>Width</label>
											<input type="text" placeholder="Width" style="width: 100%;" name="m_width">
										</div>
									</div>
									<div id="tabe-3" class="container tab-pane fade">

										<div class="form-group">
											<label>Length</label>
											<input type="text" placeholder="Length" style="width: 100%;" name="l_length">
										</div>
										<div class="form-group">
											<label>Height</label>
											<input type="text" placeholder="Height" style="width: 100%;" name="l_height">
										</div>
										<div class="form-group">
											<label>Width</label>
											<input type="text" placeholder="Width" style="width: 100%;" name="l_width">
										</div>
									</div>
									<div id="tabe-4" class="container tab-pane fade">

										<div class="form-group">
											<label>Length</label>
											<input type="text" placeholder="Length" style="width: 100%;" name="xl_length">
										</div>
										<div class="form-group">
											<label>Height</label>
											<input type="text" placeholder="Height" style="width: 100%;" name="xl_height">
										</div>
										<div class="form-group">
											<label>Width</label>
											<input type="text" placeholder="Width" style="width: 100%;" name="xl_width">
										</div>
									</div>
									<div id="tabe-5" class="container tab-pane fade">

										<div class="form-group">
											<label>Length</label>
											<input type="text" placeholder="Length" style="width: 100%;" name="xxl_length">
										</div>
										<div class="form-group">
											<label>Height</label>
											<input type="text" placeholder="Height" style="width: 100%;" name="xxl_height">
										</div>
										<div class="form-group">
											<label>Width</label>
											<input type="text" placeholder="Width" style="width: 100%;" name="xxl_width">
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
						<textarea id="descritpion" name="remarks" style="width: 100%;"></textarea>

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

<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>

<script>
	$("#sdate").hide();
	var $j = jQuery.noConflict();
	$j("#schedule_to_date").datepicker();

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

	function setValueforSmall() {
		$('#s').val("S");
	}

	function setValueforMedium() {
		$('#m').val("M");
	}

	function setValueforlarge() {
		$('#l').val("L");
	}

	function setValueforextralarge() {
		$('#xl').val("XL");
	}

	function setValueforxxl() {
		$('#xxl').val("XXL");
	}

	function showProducOption(pro_option) {
		if (pro_option == 1) {
			$('#forPant').hide();
			$('#showProductOption').show();
		} else if (pro_option == 2) {
			$('#forPant').show();
			$('#showProductOption').hide();
		} else if (pro_option == 3) {
			$('#forPant').hide();
			$('#showProductOption').hide();
			$('#shoe').show();
		} else {
			$('#showProductOption').hide();
			$('#forPant').hide();
		}
	}

	function emptyfrm() {
		$('#cform')[0].reset();
	}
	// Data Table List View
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
	//"{{ route('listByMainMenu.search') }}",
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
					$("#msg").text("Sorry already exits.");
				} else {
					$("#msg").text("Available Product Code");
					$("#submitproduct").prop("disabled", false);
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
				$('#post_title').val(data.post_title);
				$('#slug').val(data.post_name);
				$('#product_code').val(data.sku);
				$('#pro_long_description').html(data.post_excerpt);
				$('#regular_price').val(data.max_price);
                $('#orginal_price').val(data.max_price);
                $('#special_price').val(data.max_price);
                
                
                if(data.stock_status == "instock"){
                    $('#pro_vailability').val(1);
                }else{
                     $('#pro_vailability').val(0);
                }
                
				$("#modal-animation-3").modal('show');
			}
		});

	}
    
   function firstThamnailPreviewImg(product_id){
    		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "product/thamnailPreviewImg/" + product_id,
			success: function(data) {
				var img = '<img src="' + data.guid + '"style="height: 250px; width: 270px; border-radius: 8px;border: 5px solid #555;" id="insertedImages">';
				$("#insertedImages").html(img);
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
		ebay_api_featch_list();
		$("#loader").show();
		featch_list();

		function featch_list(query = '') {
			console.log("test");
			$.ajax({
				url: "{{ route('listByProduct.search') }}",
				method: 'GET',
				data: {
					query: query
				},
				dataType: 'json',
				success: function(data) {
					$('.showproduct').html(data.table_data);
					$('#total_records').text(data.total_data);
					$("#loader").hide();
				}
			})
		}
		$(document).on('keyup', '#searchproduct', function() {
			var query = $(this).val();
			featch_list(query);
		});
	});

	function getCategoryVal(category_id) {
		if (category_id == '4') {
			$("#sdate").hide();
			document.getElementById("schedule_to_date").required = true;
		} else {
			$("#sdate").hide();
			document.getElementById("schedule_to_date").required = false;
		}
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/get-sub-category")}}',
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

	function getSubInCategoryVal(sub_cat_id) {
		condition(sub_cat_id);
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/sub-in-sub-category")}}',
			data: {
				sub_cat_id: sub_cat_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(response) {
				$("#sub_in_sub_id").empty();
				remove_insubmenu();
				$.each(response, function(index, insubmenu) {
					$("#sub_in_sub_id").append('<option value="' + insubmenu.sub_in_sub_id + '">' +
						insubmenu.sub_in_sub_cat_name + '</option>');
				});
				// $("select[name=district_id]").val(response.district_id);
			}
		});
	}

	function condition(sub_cat_id) {
		if (sub_cat_id == 1) {
			// $('#post').hide();
			$('#mname').show();
			$('#dname').show();
		} else {
			//$('#post').show();
			$('#mname').hide();
			$('#dname').hide();
		}
	}

	function remove_insubmenu() {
		$('#sub_in_sub_id').append('<option selected="selected" value="">Select</option>');
	}

	function remove_subcat() {
		$('#sub_cat_id').append('<option selected="selected" value="">Select</option>');
	}

    function feactchData(){
       ebay_api_featch_list();
    }
	function ebay_api_featch_list() {
		//console.log("sss");
        $(".loader").show();
		$.ajax({
			url: "{{ route('ebaylistByProduct.search') }}",
			method: 'GET',
			dataType: 'json',
			success: function(data) {
				$('.ebaytbody').html(data.table_data);
				//	$('#total_records').text(data.total_data);
				$(".loader").hide();
			}
		})
	}
</script>
@endsection