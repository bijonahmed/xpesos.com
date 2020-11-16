@extends('admin.master')
@section('title','Edit Product')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="content-wrapper">
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="container">

					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">

								<div class="modal-body">
									<form id="cform" enctype="multipart/form-data" action="{{url('/admin/removeProduct')}}" method="post">
										{{ csrf_field() }}
										<input type="hidden" name="product_id" id="pid" />
										<input type="hidden" id="imgpath" name="imgpath" />
										<input type="hidden" id="imgId" name="imgId" />
										<button type="submit" class="btn btn-danger btn-block">Remove Image</button>
									</form>

								</div>

							</div>
						</div>
					</div>

					<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveProduct')}}" method="post">
						{{ csrf_field() }}
						<div class="">
							<div class="">
								<div class="modal-header bg-primary">
									<h5 class="modal-title text-white"><i class="fa fa-star"></i> Edit Product</h5>
									<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
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
												<label for="Xlarge-input" class="col-form-label">Sub
													Category</label><br>

												<select id="sub_cat_id" name="sub_cat_id" onchange="getSubMenuVal(this.value);" style="width: 100%;">
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
													<option value="">Select in Sub Category</option>
													<?php
                                                    foreach ($subincategory as $val) {
                                                        ?>
													<option value="<?php echo $val->sub_in_sub_id; ?>">
														<?php echo $val->sub_in_sub_cat_name; ?>
													</option>
													<?php
                                                    }
                                                    ?>
												</select>

											</div>

											<div class="form-group" id="post">
												<label for="Xlarge-input" class="col-form-label">Product Name</label>

												<input type="text" id="product_name" name="product_name" placeholder="Product Name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" style="width: 100%;">

											</div>
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Slug</label>
												<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">

											</div>
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Quantity</label>
												<input type="number" id="qty" name="qty" placeholder="Quantity" required style="width: 100%;">
												<input type="hidden" name="product_id" id="product_id" />
											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Code</label>
												<input type="text" id="product_code" name="product_code" placeholder="Model Name" required style="width: 100%;" value="<?php echo $data->product_code; ?>" onkeyup="checkProductCode(this.value);">
												<div id="msg" style="color: green; font-size: 18px;"></div>
											</div>

										</div>
										<div class="col-md-3">

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Brand
													Name</label>
												<input type="text" id="pro_brand_name" name="pro_brand_name" placeholder="Brand Name" required style="width: 100%;" value="<?php echo $data->pro_brand_name; ?>">

											</div>
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Long
													Description</label>
												<textarea name="pro_long_description" id="pro_long_description" placeholder="Long Description" required style="width: 100%;"><?php echo $data->pro_long_description; ?></textarea>

											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Regular Price</label>
												<input type="text" id="regular_price" name="regular_price" placeholder="Regular Price" required style="width: 100%;" onkeyup="if (/\D/g.test(this.value))
                                                                   this.value = this.value.replace(/\D/g, '')" value="<?php echo $data->regular_price; ?>">

											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Percentage</label>
												<input type="text" id="percentage" name="percentage" placeholder="Percentage" style="width: 100%;" value="<?php echo $data->percentage; ?>" onkeyup="getPercentage();">

											</div>
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Special Price</label>
												<input type="text" id="special_price" name="special_price" placeholder="Special Price" style="width: 100%;" value="<?php echo $data->special_price; ?>">

											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Availability
												</label>
												<select id="pro_vailability" name="pro_vailability" style="width: 100%;">
													<option value='1'>In Stock</option>
													<option value='0'>Out Of Stock</option>
												</select>
											</div>

											<div class="form-group" id="sdate" style="display: none;">
												<label for="Xlarge-input" class="col-form-label" style="color: red;">Today Dell (End Date)</label>
												<input type="text" id="schedule_to_date" name="schedule_to_date" placeholder="Schedule Date" style="width: 100%;">

											</div>

										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Option</label>
												<select id="pro_option" name="pro_option" style="width: 100%;" onchange="showProducOption(this.value);">
													<option value='0'>No</option>
													<option value='1'>Top Part</option>
													<option value='2'>Bottom Part</option>
													<option value='3'>Show</option>
												</select>
											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label" style="color: green;font-weight: bold;">Vendor Name</label>
												<input type="text" id="vendor_name" name="vendor_name" placeholder="Vendor Name" required style="width: 100%;">

											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label" style="color: green;font-weight: bold;">Original Price</label>
												<input type="text" id="orginal_price" name="orginal_price" placeholder="Original Price" required style="width: 100%;">

											</div>

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Type</label>
												<select id="pro_type" name="pro_type" style="width: 100%;">
													<option value='1'>New</option>
													<option value='0'>Old</option>
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

											<div class="form-group">
												<label for="Xlarge-input" class="col-form-label">Product Image</label>
												<input type="file" id="file-input1" name="photo1" onchange="previewProductOne()">
												<input type="file" id="file-input2" name="photo2" onchange="previewProductTwo()">
												<input type="file" id="file-input3" name="photo3" onchange="previewProductThree()">
												<input type="file" id="file-input4" name="photo4" onchange="previewProductFour()">
												<input type="file" id="file-input5" name="photo5" onchange="previewProductFive()">

											</div>
										</div>

										<div class="container">
											<div class="row">
												<div class="col-md-3">
													<?php
                                                    if (!empty($data->photo1)) {
                                                        ?>
													<br>
													<img src="{{ url('admin/'.$data->photo1) }}" style="height: 250px; width: 250px;">
													<?php } ?>

												</div>
												<div class="col-md-3">

													<?php
                                                    if (!empty($data->photo2)) {
                                                        ?>
													<center><span><a href="#" onclick="getProductImg('<?php echo $data->photo5; ?>', '2')">Delete</a></span>
													</center>
													<img src="{{ url('admin/'.$data->photo2) }}" style="height: 250px; width: 250px;">
													<?php } ?>

												</div>
												<div class="col-md-3">

													<?php
                                                    if (!empty($data->photo3)) {
                                                        ?>
													<center><span><a href="#" onclick="getProductImg('<?php echo $data->photo5; ?>', '3')">Delete</a></span>
													</center>
													<img src="{{ url('admin/'.$data->photo3) }}" style="height: 250px; width: 250px;">
													<?php } ?>

												</div>
												<div class="col-md-3">

													<?php
                                                    if (!empty($data->photo4)) {
                                                        ?>

													<center><span><a href="#" onclick="getProductImg('<?php echo $data->photo5; ?>', '4')">Delete</a></span>
													</center>
													<img src="{{ url('admin/'.$data->photo4) }}" style="height: 250px; width: 250px;">
													<?php } ?>

												</div>
												<div class="col-md-3">

													<?php
                                                    if (!empty($data->photo5)) {
                                                        ?>
													<center><span><a href="#" onclick="getProductImg('<?php echo $data->photo5; ?>', '5')">Delete</a></span>
													</center>
													<img src="{{ url('admin/'.$data->photo5) }}" style="height: 250px; width: 250px;">

													<?php } ?>
												</div>

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
									<div id="forPant" style="text-align: center;display: none; color: black; border-radius: 5px;  border-radius: 25px;">
										<div class="row">
											<div class="col-md-2">
												<input type="text" required style="width: 100%; background-color: #dae1e7;" value="28" readonly="">
											</div>
											<div class="col-md-3">
												<input type="text" id="bottom_28" name="bottom_28" placeholder="Waist size" style="width: 100%;" value="<?php echo $data->bottom_28; ?>">
											</div>

										</div>

										<div class="row">
											<div class="col-md-2">
												<input type="text" required style="width: 100%; background-color: #dae1e7;" value="30" readonly="">

											</div>
											<div class="col-md-3">
												<input type="text" id="bottom_30" name="bottom_30" placeholder="Waist size" style="width: 100%;" value="<?php echo $data->bottom_30; ?>">
											</div>

										</div>
										<div class="row">
											<div class="col-md-2">
												<input type="text" required style="width: 100%; background-color: #dae1e7;" value="32" readonly="">

											</div>
											<div class="col-md-3">
												<input type="text" id="bottom_32" name="bottom_32" placeholder="Waist size" style="width: 100%;" value="<?php echo $data->bottom_32; ?>">
											</div>

										</div>
										<div class="row">
											<div class="col-md-2">
												<input type="text" required style="width: 100%; background-color: #dae1e7;" value="34" readonly="">

											</div>
											<div class="col-md-3">
												<input type="text" id="bottom_34" name="bottom_34" placeholder="Waist size" style="width: 100%;" value="<?php echo $data->bottom_34; ?>">
											</div>

										</div>
										<div class="row">
											<div class="col-md-2">
												<input type="text" required style="width: 100%; background-color: #dae1e7;" value="36" readonly="">

											</div>
											<div class="col-md-3">
												<input type="text" id="bottom_36" name="bottom_36" placeholder="Waist size" style="width: 100%;" value="<?php echo $data->bottom_36; ?>">
											</div>

										</div>
									</div>

									<div id="showProductOption" style="display: none;">
										<center style="color: green; font-weight: bold; font-size: 20px;">Top Part
										</center>
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
												<a class="nav-link" data-toggle="tab" href="#tabe-4" onclick="setValueforextralarge();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">XL
														(Extra Large)</span></a>
											</li>

											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#tabe-5" onclick="setValueforxxl();"><i class="icon-user"></i> <span class="hidden-xs" style="font-size: 15px; color: green;">XXL
														(extra extra Large)</span></a>
											</li>

										</ul>

										<!-- Tab panes -->
										<div class="tab-content">
											<div id="tabe-1" class="container tab-pane active"><br>
												<div class="form-group">
													<label>Length</label>
													<input type="hidden" name="s" id="s" value="S" value="<?php echo $data->s; ?>" />
													<input type="hidden" name="m" id="m" value="<?php echo $data->m; ?>" />
													<input type="hidden" name="l" id="l" value="<?php echo $data->l; ?>" />
													<input type="hidden" name="xl" id="xl" value="<?php echo $data->xl; ?>" />
													<input type="hidden" name="xxl" id="xxl" value="<?php echo $data->xxl; ?>" />

													<input type="text" placeholder="Length" style="width: 100%;" name="s_length" value="<?php echo $data->s_length; ?>">
												</div>
												<div class="form-group">
													<label>Height</label>
													<input type="text" placeholder="Height" style="width: 100%;" name="s_height" value="<?php echo $data->s_height; ?>">
												</div>
												<div class="form-group">
													<label>Width</label>
													<input type="text" placeholder="Width" style="width: 100%;" name="s_width" value="<?php echo $data->s_width; ?>">
												</div>

											</div>
											<div id="tabe-2" class="container tab-pane fade">

												<div class="form-group">
													<label>Length</label>
													<input type="text" placeholder="Length" style="width: 100%;" name="m_length" value="<?php echo $data->m_length; ?>">
												</div>
												<div class="form-group">
													<label>Height</label>
													<input type="text" placeholder="Height" style="width: 100%;" name="m_height" value="<?php echo $data->m_height; ?>">
												</div>
												<div class="form-group">
													<label>Width</label>
													<input type="text" placeholder="Width" style="width: 100%;" name="m_width" value="<?php echo $data->m_width; ?>">
												</div>
											</div>
											<div id="tabe-3" class="container tab-pane fade">

												<div class="form-group">
													<label>Length</label>
													<input type="text" placeholder="Length" style="width: 100%;" name="l_length" value="<?php echo $data->l_length; ?>">
												</div>
												<div class="form-group">
													<label>Height</label>
													<input type="text" placeholder="Height" style="width: 100%;" name="l_height" value="<?php echo $data->l_height; ?>">
												</div>
												<div class="form-group">
													<label>Width</label>
													<input type="text" placeholder="Width" style="width: 100%;" name="l_width" value="<?php echo $data->l_width; ?>">
												</div>
											</div>
											<div id="tabe-4" class="container tab-pane fade">

												<div class="form-group">
													<label>Length</label>
													<input type="text" placeholder="Length" style="width: 100%;" name="xl_length" value="<?php echo $data->xl_length; ?>">
												</div>
												<div class="form-group">
													<label>Height</label>
													<input type="text" placeholder="Height" style="width: 100%;" name="xl_height" value="<?php echo $data->xl_height; ?>">
												</div>
												<div class="form-group">
													<label>Width</label>
													<input type="text" placeholder="Width" style="width: 100%;" name="xl_width" value="<?php echo $data->xl_width; ?>">
												</div>
											</div>
											<div id="tabe-5" class="container tab-pane fade">

												<div class="form-group">
													<label>Length</label>
													<input type="text" placeholder="Length" style="width: 100%;" name="xxl_length" value="<?php echo $data->xxl_length; ?>">
												</div>
												<div class="form-group">
													<label>Height</label>
													<input type="text" placeholder="Height" style="width: 100%;" name="xxl_height" value="<?php echo $data->xxl_height; ?>">
												</div>
												<div class="form-group">
													<label>Width</label>
													<input type="text" placeholder="Width" style="width: 100%;" name="xxl_width" value="<?php echo $data->xxl_width; ?>">
												</div>
											</div>

										</div>
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Remarks</label>
										<textarea id="remarks" name="remarks" style="width: 100%;"><?php echo $data->remarks; ?></textarea>

									</div>

									<div class="modal-footer">
										<div id="showmsg" style="text-align: center;"></div>

										<button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Update
										</button>
									</div>

								</div>
					</form>

				</div>

			</div>
		</div>
	</div><!-- End Row-->
</div>

<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>

<script>
	var $j = jQuery.noConflict();
	$j("#schedule_to_date").datepicker();

	function getProductImg(imgpath, imgId) {
		$('#myModal').modal('show');
		$('#imgpath').val(imgpath);
		$('#imgId').val(imgId);
	}

	function getPercentage() {
		var regular_price = parseInt($('#regular_price').val());
		var percentage = parseInt($('#percentage').val());
		var totalValue = regular_price * ((100 - percentage) / 100);
		var result = parseInt(totalValue.toFixed(2));
		$('#special_price').val(result);
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
            }  else {
                $('#showProductOption').hide();
                $('#forPant').hide();
         }
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
	$(document).ready(function() {
		$('#product_id').val("<?php echo $data->product_id; ?>");
		$('#pid').val('<?php echo $data->product_id; ?>');
		$('#qty').val('<?php echo $data->qty;?>');
		$('#status').val('<?php echo $data->status;?>');
		$('#category_id').val('<?php echo $data->category_id; ?>');
		$('#sub_cat_id').val('<?php echo $data->sub_cat_id; ?>');
		$('#sub_in_sub_id').val('<?php echo $data->sub_in_sub_id; ?>');
		$('#product_name').val('<?php echo $data->product_name; ?>');
		$('#slug').val('<?php echo $data->slug; ?>');
		$('#user_id').val('<?php echo $data->user_id; ?>');
		$('#pro_vailability').val('<?php echo $data->pro_vailability; ?>');
		$('#pro_type').val('<?php echo $data->pro_type; ?>');
		$('#status').val('<?php echo $data->status; ?>');
		$('#remarks').val('<?php echo $data->remarks; ?>');
		//
		$('#xxl').val('<?php echo $data->xxl; ?>');
		$('#xl').val('<?php echo $data->xl; ?>');
		$('#l').val('<?php echo $data->l; ?>');
		$('#m').val('<?php echo $data->m; ?>');
		$('#s').val('<?php echo $data->s; ?>');
		$('#vendor_name').val('<?php echo $data->vendor_name; ?>');
		$('#orginal_price').val('<?php echo $data->orginal_price; ?>');
		$('#schedule_to_date').val('<?php echo $data->schedule_to_date; ?>');
        $('#shoe_size').val('<?php echo $data->shoe_size; ?>');
		// getCategoryVal(category_id);
		$('#pro_option').val('<?php echo $data->pro_option; ?>');
		var pro_option = '<?php echo $data->pro_option; ?>';
		// Product Option
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
             $('#shoe').hide();
		}
		// $('#editmodal').modal('show');
		//condition(sub_cat_id);
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

	function getSubMenuVal(sub_cat_id) {
		//condition(sub_cat_id);
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/sub-menu-in-menu")}}',
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
						insubmenu
						.name + '</option>');
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
</script>
@endsection