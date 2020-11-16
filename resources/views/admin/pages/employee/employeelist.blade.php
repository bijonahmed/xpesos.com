@extends('admin.master')
@section('title','Employee List')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>
 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="content-wrapper">
	<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Employee List</strong></span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">
				<div class="row">
					<div class="col-md-7">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Employee</li>
							</ol>
						</nav>

					</div>
					<div class="col-md-3">
						<div class="form-group" style="text-align: right;">
							<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();">
								<i class="fa fa-plus"></i> Add </a>
							<input type="text" name="search" id="search" placeholder="Search" />
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
						<thead>
							<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
								<th>SL</th>
								<th>Employee Name</th>
								<th>Employee Phone</th>
								<th>Salary</th>
								<th>Photo</th>
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
	</div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">

	<form enctype="multipart/form-data" id="upload_form">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Employee</h5>
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
								<div class="col-md-5">
									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Employee Name</label>
										<input type="text" id="employeename" name="employeename" placeholder="Employee Name" style="width: 100%;" required>
										<input type="hidden" class="form-control" id="employeeid" name="employeeid">
									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Email</label>
										<input type="text" id="email" name="email" placeholder="Email" required style="width: 100%;" onkeyup="checkUserEmail(this.value);">
									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Mobile</label>
										<input type="text" id="mobile" name="mobile" placeholder="Mobile" required style="width: 100%;" onkeyup="checkUserMobile(this.value);">
										<span id="mobilevalidation" style="color: red; font-weight: bold;"></span>
									</div>


									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Department</label>
										<select id="dpt_id" name="dpt_id" style="width: 100%;">
											<option value="">Select Department</option>
											<?php
                                        foreach ($department as $val) {
                                            ?>
											<option value="<?php echo $val->dpt_id; ?>"><?php echo $val->dpt_name; ?>
											</option>
											<?php }?>
										</select>
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Designation</label>
										<select id="designation_id" name="designation_id" style="width: 100%;">
											<option value="">Select Designation</option>
											<?php
                                                  foreach ($designation as $val) {
                                            ?>
											<option value="<?php echo $val->designation_id; ?>"><?php echo $val->designation_name; ?>
											</option>
											<?php }?>
										</select>
									</div>

								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Address
										</label>
										<textarea name="address" id="address" placeholder="Address" required style="width: 100%;"></textarea>
									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Joining Date</label>
										<input type="text" id="joindate" name="joindate" placeholder="Joining Date" required style="width: 100%;" autcomplete="off">
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Salary</label>
										<input type="text" id="salary" name="salary" placeholder="Salary" required style="width: 100%;" autcomplete="off">
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Photo</label>
										<input type="file" id="photo" name="photo">
										<div id="insertedImages"></div>
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
	//fromdate
	$.noConflict();
	jQuery(document).ready(function($) {
		$("#joindate").datepicker();
	});

	function emptyfrm() {
		$("#upload_form")[0].reset();
	}

	// ajax post
	$('#upload_form').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: "save-employee",
			method: "POST",
			data: new FormData(this),
			dataType: 'JSON',
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				$('#modal-animation-3').modal('hide');
				$("#upload_form")[0].reset();
				alert("Successfully Save");
				featch_list();

			}
		})
	});

	function checkUserMobile(mobile) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "admin-check-employee-mobile/" + mobile,
			data: {
				"mobile": mobile,
				"_token": _token,
			},
			success: function(data) {
				var msg = data;
				var textmesg = "Please try again another Mobile Number. already exits";
				if (msg == '1') {
					$("#mobilevalidation").text(textmesg);
					$("#mobile").focus();
					$("#save").hide();
				} else {
					var textmesg = '';
					$("#mobilevalidation").text(textmesg);
					$("#save").show();
				}
			}
		});
	}

	// Edit
	function getbyId(employeeid) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "employee/searhEmployeeId/" + employeeid,
			data: {
				"employeeid": employeeid,
				"_token": _token,
			},
			success: function(data) {

				$("#employeename").val(data.employeename);
				$("#email").val(data.email);
				$("#mobile").val(data.mobile);
				$("#salary").val(data.salary);

				$("#dpt_id").val(data.dpt_id);
				$("#designation_id").val(data.designation_id);
				$("#joindate").val(data.joindate);

				$("#employeeid").val(data.employeeid);
				$("#address").val(data.address);
				var img = '<img src="' + data.photo + '" width="100" height="100" id="insertedImages">';
				$("#insertedImages").html(img);
				$("#insertedImages").html(img);
				$("#status").val(data.status);
				$('#modal-animation-3').modal();
				featch_list();
			}
		});
	}

	function featch_list(query = '') {
		console.log("test");
		$.ajax({
			url: "{{ route('employeelist.search') }}",
			method: 'GET',
			data: {
				query: query
			},
			dataType: 'json',
			success: function(data) {
				$('tbody').html(data.table_data);
				$('#total_records').text(data.total_data);
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