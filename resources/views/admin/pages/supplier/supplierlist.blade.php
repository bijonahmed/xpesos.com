@extends('admin.master')
@section('title','Vendor List')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
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
			<span><strong>Vendor</strong> List</span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">
				<div class="row">
					<div class="col-md-11">
						<div class="form-group" style="text-align: right;">
							<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();" style="display:none;">
								<i class="fa fa-plus"></i> Create a New Vendor </a>
							<input type="text" name="searchproduct" id="searchproduct" placeholder="Search" />
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
						<thead>
							<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
								<th>SL</th>
								<th>Vendor Name</th>
								<th>Contact Person Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Address</th>
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
	<!--<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveProduct')}}" method="post">-->
	<form id="cform">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Vendor</h5>
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
										<label for="Xlarge-input" class="col-form-label">Vendor Name</label>
										<input type="text" id="supplier_name" name="supplier_name" placeholder="Vendor Name" style="width: 100%;" required>
										<input type="hidden" class="form-control" id="supplier_id" name="supplier_id">
									</div>
									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Vendor Contact Person Name</label>
										<input type="text" id="supplier_contact_person_name" name="supplier_contact_person_name" placeholder="Vendor Contact Person Name" style="width: 100%;" required>

									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Email</label>
										<input type="text" id="supplier_email" name="supplier_email" placeholder="Email" required style="width: 100%;">
									</div>


									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Phone</label>
										<input type="text" id="supplier_phone" name="supplier_phone" placeholder="Phone" required style="width: 100%;" onkeyup="checkSupplierMobile(this.value);">
										<span id="mobilevalidation" style="color: red; font-weight: bold;"></span>
									</div>


								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Address
										</label>
										<textarea name="supplier_address" id="supplier_address" placeholder="Address" required style="width: 100%;"></textarea>
									</div>

									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Reamrks
											Description</label>
										<textarea name="reamrks" id="reamrks" placeholder="Reamrks" required style="width: 100%;"></textarea>
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
								<button type="submit" id="signup" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
						</div>
					</div>
	</form>
</div>
<!-- Modal -->

<script>
	function emptyfrm() {
		$("#cform")[0].reset();
	}

	// ajax post
	$(".btn-submit").click(function(e) {
		e.preventDefault();
		var _token = $("input[name='_token']").val();
		var supplier_name = $("input[name=supplier_name]").val();
		var supplier_contact_person_name = $("input[name=supplier_contact_person_name]").val();
		var supplier_email = $("input[name=supplier_email]").val();
		var supplier_phone = $("input[name=supplier_phone]").val();
		var supplier_address = $("#supplier_address").val();
		var reamrks = $("#reamrks").val();
		var supplier_id = $("input[name=supplier_id]").val();
		var status = $("select[name=status]").val();
		if (supplier_name == '' || supplier_email == '' || supplier_phone == '') {
			alert("Please insert blank filed.");
			return false;
		}
		$.ajax({
			type: 'POST',
			url: "save-supplier",
			dataType: "json",
			data: {
				_token: _token,
				supplier_name: supplier_name,
				supplier_contact_person_name: supplier_contact_person_name,
				supplier_email: supplier_email,
				supplier_phone: supplier_phone,
				supplier_address: supplier_address,
				reamrks: reamrks,
				supplier_id: supplier_id,
				status: status

			},
			success: function(data) {
				//alert(data.msg);
				$('#modal-animation-3').modal('hide');
				$("#cform")[0].reset();
				featch_list();



			}
		});
	});

	function checkSupplierMobile(mobile) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "supplier-mobile-check/" + mobile,
			data: {
				"mobile": mobile,
				"_token": _token,
			},
			success: function(data) {
				var msg = data;
				var textmesg = "Please try again another Mobile Number. already exits";
				if (msg == '1') {
					$("#mobilevalidation").text(textmesg);
					$("#supplier_phone").focus();
					$("#signup").hide();
				} else {
					var textmesg = '';
					$("#mobilevalidation").text(textmesg);
					$("#signup").show();
				}
			}
		});
	}
	// Edit
	function getbyId(supplier_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "supplier/searhSupplierId/" + supplier_id,
			data: {
				"supplier_id": supplier_id,
				"_token": _token,
			},
			success: function(data) {
				$("#supplier_id").val(data.supplier_id);
				$("#supplier_name").val(data.supplier_name);
				$("#supplier_contact_person_name").val(data.supplier_contact_person_name);
				$("#supplier_email").val(data.supplier_email);
				$("#supplier_phone").val(data.supplier_phone);
				$("#supplier_address").val(data.supplier_address);
				$("#reamrks").val(data.reamrks);
				$("#status").val(data.status);
				$('#modal-animation-3').modal();
			}
		});
	}
	function featch_list(query = '') {
		console.log("test");
		$.ajax({
			url: "{{ route('supplierlist.search') }}",
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
	$(document).on('keyup', '#searchproduct', function() {
		var query = $(this).val();
		featch_list(query);
	});
	featch_list();
	
</script>
@endsection