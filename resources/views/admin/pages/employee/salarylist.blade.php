@extends('admin.master')
@section('title','Salary List')
@section('maincontent')
 
<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="content-wrapper">
<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Salary List</strong></span>
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
								<li class="breadcrumb-item active" aria-current="page">Salary List</li>
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
					<table class="table-hover" style="width: 100%; color:#000;">
						<thead>
							<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
								<th>SL</th>
                                <th>Date</th>
								<th>Employee Name</th>
                                <th>Employee Mobile</th>
                                <th>Salary</th>
							</tr>
						</thead>
						<tbody class="tbody">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
	<form id="cform" enctype="multipart/form-data" action="{{url('/admin/CreateSalary')}}" method="post">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Salary</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">

                            	<div class="form-group" style="margin-top: -30px;">
										<label for="Xlarge-input" class="col-form-label">Date</label>
										<input type="text" id="pay_date" name="pay_date" placeholder="Selected Date" required style="width: 100%;" autcomplete="off">
									</div>
								<table style="width: 100%;" border="1">
									<thead>
										<tr>
											<th>#SL</th>
											<th>Employee Name</th>
											<th>Salary</th>
										</tr>
									</thead>

									<tbody class="test">
                                    	<?php
                                        $x=1;
                                    foreach($employeelist as $v){
                                ?>
                                
										<tr>
                                        <input type="hidden" name="employeeid[]" value="<?php echo $v->employeeid;?>"/>
											<td><?php echo $x; $x++;?></td>
											<td><?php echo $v->employeename;?></td>
											<td><?php echo $v->salary;?></td>
										</tr>
								<?php } ?>
									</tbody>

								</table>
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
    
    	$.noConflict();
	jQuery(document).ready(function($) {
		$("#pay_date").datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
            });
        
	});
    
    function featch_list(query = '') {
		console.log("test");
		$.ajax({
			url: "{{ route('salarylist.search') }}",
			method: 'GET',
			data: {
				query: query
			},
			dataType: 'json',
			success: function(data) {
				$('.tbody').html(data.table_data);
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