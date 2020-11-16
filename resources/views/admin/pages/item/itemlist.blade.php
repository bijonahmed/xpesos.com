@extends('admin.master')
@section('title','Item List')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<style>
	.modal-lg {
		max-width: 90% !important;
	}

	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid blue;
		border-bottom: 16px solid blue;
		width: 120px;
		height: 120px;
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
			<span><strong>Item </strong> List</span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">
				<div class="row">
					<div class="col-md-4">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Item</li>
							</ol>
						</nav>

					</div>
					<div class="col-md-6">
						<div class="form-group" style="text-align: right;">
							<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();" style="display:none;">
								<i class="fa fa-plus"></i> Create a new item </a>

							<a href="#" data-toggle="modal" data-target="#modal-animation-4" onclick="emptyfrm();">
								<i class="fa fa-plus"></i> Import item </a>

							<input type="text" name="search" id="search" placeholder="Search" />
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<select id="category_id" name="category_id" required="required" onchange="getCategoryVal(this.value);checkCateWiseItem(this.value);" style="width: 100%;">
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

						<div class="col-md-4">
							<select id="sub_cat_id" name="sub_cat_id" style="width: 100%;" onchange="getOnCahangeSubCatVal(this.value);checkSubCateWiseItem(this.value);">
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

						<div class="col-md-4">
							<select id="sub_in_sub_id" name="sub_in_sub_id" style="width: 100%;" onchange="checkSubCateWiseItem(this.value);checkinSubCateWiseItem(this.value);">
								<option value="">Select In Sub Category</option>
								<?php
								foreach ($insub_cat as $val) {
								?>
									<option value="<?php echo $val->sub_in_sub_id; ?>"><?php echo $val->sub_in_sub_cat_name; ?>
									</option>
								<?php
								}
								?>
							</select>

						</div>

					</div>
					<br>
					<center>
						<div class="loader" id="loader"></div>
					</center>
				</div>
				<div class="table-responsive">
					<table class="table-striped table-hover" style="width: 100%; color:black;" border="1">
						<thead>
							<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
								<th style="text-align: center;">SL</th>
								<th style="text-align: center;">Company</th>
								<th style="text-align: center;">Product Code</th>
								<th style="text-align: center;">Product Name</th>
								<th style="text-align: center;">Category</th>
								<th style="text-align: center;">Sub Category</th>
								<th style="text-align: center;">In Sub Category</th>
								<th style="text-align: center;">Qty</th>
								<th style="text-align: center;">Report</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody class="itemrev">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-4">
	<!--<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveProduct')}}" method="post">-->
	<form id="cform">
		{{ csrf_field() }}
		<div class="modal-dialog modal-sm">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><small>Item Import Form Producct List</small></h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="pills-home-tab">
							<center>
								<div id="loading"></div>
							</center>
							<center><button type="submit" id="save" class="btn btn-primary btn-processing"><i class="fa fa-check-square-o"></i> Processing Data
								</button></center> <br>

							<div class="modal-footer">

								<button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i>
									Close</button>

							</div>
						</div>
					</div>
	</form>
</div>

</div>
</div>
</div>
<!-- Modal -->

<div class="modal fade" id="modal-animation-3">
	<!--<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveProduct')}}" method="post">-->
	<form id="cform">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Item</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-md-11">
									<div class="form-group">
										<label for="large-input" class="col-form-label"> Product</label>

										<input type="hidden" class="form-control" id="item_id" name="item_id">
										<select id="product_id" name="product_id" style="width: 100%;">
											<option value="">Select Product</option>
											<?php

											$x = 1;
											foreach ($product as $val) {
											?>
												<option value="<?php echo $val->product_id; ?>">
													<?php echo $x . '. ' . $val->product_name . ' [' . $val->product_code . '] '; ?>
												</option>
											<?php
												$x++;
											}
											?>
										</select>
									</div>

									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label" id="qtylevel">Openining
											Quantity</label>
										<input type="text" id="qnty" name="qnty" placeholder="Quuantity" style="width: 100%;" autocomplete="off" required onkeyup="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
										<span id="qnty_val"></span>

									</div>

									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Rate</label>
										<input type="text" id="rate" name="rate" placeholder="Rate" style="width: 100%;" autocomplete="off" required onkeyup="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '');getCalculated(this.value)">
										<span id="rate_val"></span>
									</div>

									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Total</label>
										<input type="text" id="rate_total" name="rate_total" placeholder="Rate" style="width: 100%;" autocomplete="off" required onkeyup="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
										<span id="rate_total_val"></span>
									</div>

									<div class="form-group">
										<label for="large-input" class="col-form-label">Status</label>
										<select id="status" name="status" style="width: 100%;">
											<option value='1'>Active</option>
											<option value='0'>Inactive</option>
										</select>
									</div>

								</div>
							</div>
							<div class="modal-footer">

								<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
									Close</button>
								<button type="submit" id="save" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
						</div>
					</div>
	</form>
</div>

<!-- Modal -->

<script>
	//sub_in_sub_id
	function getOnCahangeSubCatVal(sub_cat_id) {
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/get-in-sub-category")}}',
			data: {
				sub_cat_id: sub_cat_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(response) {
				$("#sub_in_sub_id").empty();
				$("#sub_in_sub_id").append('<option value="">Select InSub Category</option>');
				$.each(response, function(index, insubcategory) {
					$("#sub_in_sub_id").append('<option value="' + insubcategory.sub_in_sub_id + '">' +
						insubcategory.sub_in_sub_cat_name + '</option>');
				});
			}
		});

	}

	function getCategoryVal(category_id) {
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
				$("#sub_cat_id").append('<option value="">Select SubCategory</option>');
				$.each(response, function(index, subcategory) {
					$("#sub_cat_id").append('<option value="' + subcategory.sub_cat_id + '">' +
						subcategory.sub_cat_name + '</option>');
				});
			}
		});
	}

	function checkCateWiseItem(category_id) {
		$("#loader").show();
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/findCateWiseItem")}}',
			data: {
				category_id: category_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(data) {
				$('#itemrev tbody tr').remove();
				$('tbody').html(data.table_data);
				$('#total_records').text(data.total_data);
				$("#loader").hide();
			}

		});
	}

	function checkSubCateWiseItem(sub_cat_id) {
		var category_id = $('#category_id').val();
		$("#loader").show();
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/findSubCateWiseItem")}}',
			data: {
				sub_cat_id: sub_cat_id,
				category_id: category_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(data) {
				$('#itemrev tbody tr').remove();
				$('tbody').html(data.table_data);
				$('#total_records').text(data.total_data);
				$("#loader").hide();
			}
		});
	}

	function checkinSubCateWiseItem(sub_in_sub_id) {
		var category_id = $('#category_id').val();
		var sub_cat_id = $('#sub_cat_id').val();
		$("#loader").show();
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/findInSubCateWiseItem")}}',
			data: {
				category_id: category_id,
				sub_cat_id: sub_cat_id,
				sub_in_sub_id: sub_in_sub_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(data) {
				$('#itemrev tbody tr').remove();
				$('tbody').html(data.table_data);
				$('#total_records').text(data.total_data);
				$("#loader").hide();
			}
		});
	}

	function emptyfrm() {
		$("#cform")[0].reset();
		$("#qnty").show();
		$("#rate").show();
		$("#rate_total").show();

	}

	function getCalculated(rate) {
		var quantity = $("#qnty").val();
		var result = quantity * rate;
		$("#rate_total").val(result);
		//$("#cform")[0].reset();
		//console.log(rate);
	}
	// ajax post processing
	$(".btn-processing").click(function(e) {
		e.preventDefault();
		var _token = $("input[name='_token']").val();
		var item_id = '1';
		$('#loading').html('<img src="/admin/pic/loading.gif"> loading...');

		$.ajax({
			type: 'POST',
			url: "save-item-processing",
			dataType: "json",
			data: {
				_token: _token,
				item_id: item_id
			},
			success: function(data) {
				$('#loading').html(data);
				$('#modal-animation-4').modal('hide');
				$("#cform")[0].reset();
				featch_list();

			}
		});
	});

	// ajax post
	$(".btn-submit").click(function(e) {
		e.preventDefault();
		var _token = $("input[name='_token']").val();
		var item_id = $("input[name=item_id]").val();
		var product_id = $("select[name=product_id]").val();
		var qnty = $("input[name=qnty]").val();
		var rate = $("input[name=rate]").val();
		var rate_total = $("input[name=rate_total]").val();
		var status = $("select[name=status]").val();
		if (rate == '' || rate_total == '') {
			alert("Please insert blank filed.");
			$("#product_id").focus();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: "save-item",
			dataType: "json",
			data: {
				_token: _token,
				product_id: product_id,
				item_id: item_id,
				rate: rate,
				qnty: qnty,
				rate_total: rate_total,
				status: status
			},
			success: function(data) {
				alert("Save");
				//$('#modal-animation-3').modal('hide');
				$("#cform")[0].reset();
				featch_list();

			}
		});
	});

	// Edit
	function getbyId(item_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "item/searchItemId/" + item_id,
			data: {
				"item_id": item_id,
				"_token": _token,
			},
			success: function(data) {
				$("#item_id").val(data.item_id);
				$("#product_id").val(data.product_id);
				$("#qnty").hide();
				$("#qnty").val(data.qnty);
				$("#qnty_val").html(data.qnty);
				$("#rate").hide();
				$("#rate").val(data.rate);
				$("#rate_val").html(data.rate);
				$("#rate_total").hide();
				$("#rate_total").val(data.rate_total);
				$("#rate_total_val").html(data.rate_total);
				$("#status").val(data.status);
				$('#modal-animation-3').modal();
			}
		});
	}

	function featch_list(query = '') {
		$("#loader").show();
		$.ajax({
			url: "{{ route('itemlist.search') }}",
			method: 'GET',
			data: {
				query: query
			},
			dataType: 'json',
			success: function(data) {
				$('tbody').html(data.table_data);
				$('#total_records').text(data.total_data);
				$("#loader").hide();
			}
		})
	}
	$(document).on('keyup', '#search', function() {
		var query = $(this).val();
		featch_list(query);
	});
	featch_list();
</script>
@endsection