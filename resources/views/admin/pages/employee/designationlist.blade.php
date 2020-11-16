@extends('admin.master')
@section('title','Designation List')
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
			<span><strong>Designation List</strong></span>
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
								<li class="breadcrumb-item active" aria-current="page">Desigantion</li>
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
								<th>Depatment Name</th>
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
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Designation</h5>
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
									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Designation Name</label>
										<input type="text" id="designation_name" name="designation_name" placeholder="Designation Name" style="width: 100%;" required onkeyup="checkDesiName(this.value)">
										<input type="hidden" class="form-control" id="designation_id" name="designation_id">
                                        <span id="validation" style="color: red; font-weight: bold;"></span>
                                        
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
	function emptyfrm() {
		$("#cform")[0].reset();
	}

	// ajax post
	$(".btn-submit").click(function(e) {
		e.preventDefault();
		var _token = $("input[name='_token']").val();
		var designation_name = $("input[name=designation_name]").val();
		var designation_id = $("input[name=designation_id]").val();
		var status = $("select[name=status]").val();
		if (designation_name == '') {
			alert("Please insert blank filed.");
              $("#designation_name" ).focus();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: "save-designation",
			dataType: "json",
			data: {
				_token: _token,
				designation_name: designation_name,
				designation_id: designation_id,
				status: status
			},
			success: function(data) {
				$('#modal-animation-3').modal('hide');
				$("#cform")[0].reset();
                alert("Successfully Save");
				featch_list();

			}
		});
	});

	
	function checkDesiName(designationname) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "admin-check-desname/" + designationname,
			data: {
				"designationname": designationname,
				"_token": _token,
			},
			success: function(data) {
				var msg = data;
				var textmesg = "Please try again another depatment. already exits";
				if (msg == '1') {
					$("#validation").text(textmesg);
					$("#designation_name").focus();
					$("#save").hide();
				} else {
					var textmesg = '';
					$("#validation").text(textmesg);
					$("#save").show();
				}
			}
		});
	}
	// Edit
	function getbyId(designation_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "designation/searhDesignationId/" + designation_id,
			data: {
				"designation_id": designation_id,
				"_token": _token,
			},
			success: function(data) {
				$("#designation_name").val(data.designation_name);
				$("#designation_id").val(data.designation_id);
				$("#status").val(data.status);
				$('#modal-animation-3').modal();
			}
		});
	}

	function featch_list(query = '') {
		console.log("test");
		$.ajax({
			url: "{{ route('designationlist.search') }}",
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