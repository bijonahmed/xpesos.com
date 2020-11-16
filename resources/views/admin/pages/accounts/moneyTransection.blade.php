@extends('admin.master')
@section('title','Money Transaction')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
			<span><strong>Money</strong> Transaction</span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="card" style="width: 100%;">
		<div class="card-body">
			<ul class="nav nav-tabs nav-tabs-primary">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#tabe-1"><i class="icon-home"></i> <span class="hidden-xs">Money Transaction</span></a>
				</li>
				<li class="nav-item" style="display:none;">
					<a class="nav-link" data-toggle="tab" href="#tabe-2"><i class="icon-user"></i> <span class="hidden-xs">Money Transaction Summary</span></a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div id="tabe-1" class="tab-pane active">
					<div class="row">
						<div class="col-lg-12">
							<div class="card" style="padding: 20px;">
								<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<div class="row">
										<div class="col-md-6">
										</div>
										<div class="col-md-6">
											<div class="form-group" style="text-align: right; padding: 1px;">
												<a href="#" data-toggle="modal" data-target="#modal-animation-4">
													<i class="fa fa-plus"></i> Create Money Transaction </a>
												<input type="text" name="searchorder" id="searchorder" placeholder="Search" />
											</div>
										</div>
										<div class="table-responsive">
											<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
												<thead>
													<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
														<th>SL</th>
                                                        <th>Rec. Name</th>
														<th>Company Name</th>
														<th>Email</th>
														<th>Mobile</th>
														<th>Payment Date </th>
														<th>Amount </th>
														<th>Cash Type </th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody class="tbodys">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!-- End Row-->
				</div>
				<div id="tabe-2" class="tab-pane fade">

					<div class="row">
						<div class="col-md-6">
							<input type="text" id="fromdate" class="fmt" autocomplete="off" name="fromdate" placeholder="From Date" value="<?php echo date("d-m-Y");?>" style="width: 100%" required>
						</div>
						<div class="col-md-6">
							<input type="text" id="todate" class="fmt" name="todate" autocomplete="off" placeholder="To Date" value="<?php echo date("d-m-Y");?>" style="width: 100%" required onchange="setDateValue(this.value);">
						</div>


					</div>
					<br>
					<center>
						<div class="loader" id="loader" style="display:none;"></div>
					</center>
					<div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true" class="fa fa-print"></i> Print</a></div><br>
					<div id="printableArea">
						<div class="table-responsive">
							<div align="left"><b>Cash In Status</b></div>
							<table class="table-striped table-hover" style="width: 100%; color:black;">
								<thead>
									<tr style="background-color: green;color: white; border-radius: 0 6px 0 0">
										<th style="text-align: center;">SL</th>
										<th style="text-align: left;">Receiver Name</th>
										<th style="text-align: left;">Company Name</th>
										<th style="text-align: left;">Mobile</th>
										<th style="text-align: left;">Payment Type</th>
										<th style="text-align: center;">Amount</th>
									</tr>
								</thead>
								<tbody class="cash_in_data">
								</tbody>

							</table>
							<hr>
							<div align="left"><b>Cash Out Status</b></div>
							<table class="table-striped table-hover" style="width: 100%; color:black;">
								<thead>
									<tr style="background-color: green;color: white; border-radius: 0 6px 0 0">
										<th style="text-align: center;">SL</th>
										<th style="text-align: left;">Receiver Name</th>
										<th style="text-align: left;">Company Name</th>
										<th style="text-align: left;">Mobile</th>
										<th style="text-align: left;">Payment Type</th>
										<th style="text-align: center;">Amount</th>
									</tr>
								</thead>
								<tbody class="cash_out_data">
								</tbody>
							</table>
							<div align="right"><span class="currentBalace" style="font-size: 22px; font-weight: bold; color: red;"></span></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</div>
</div>
</div>
<form enctype="multipart/form-data" id="upload_form">
	{{ csrf_field() }}
	<div class="modal fade" id="modal-animation-4">
		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-star"></i> Money Transaction</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Receiver Name</label>
						<input type="text" id="reciver_name" name="reciver_name" placeholder="Receiver Name" required style="width: 100%;">
						<input type="hidden" id="op_balanceid" name="op_balanceid">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Company Name</label>
						<input type="text" id="company_name" name="company_name" placeholder="Company Name" required style="width: 100%;">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Email ID</label>
						<input type="text" id="email" name="email" placeholder="Email ID" required style="width: 100%;">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Mobile No</label>
						<input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" required style="width: 100%;">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Address</label>
						<input type="text" id="address" name="address" placeholder="Address" required style="width: 100%;">
					</div>
					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Amount</label>
						<input type="text" id="amount" name="amount" placeholder="Amount" required style="width: 100%;">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Cash Type</label>
						<!--<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">-->
						<select style="width: 100%;" name="cash_type" id="cash_type">
							<option value="Cash In">Cash In</option>
							<option value="Cash Out">Cash Out</option>
						</select>
					</div>


					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Payment Type</label>
						<!--<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">-->
						<select style="width: 100%;" name="payment_type" id="payment_type" onchange="PaymentMode(this.value);">
							<option value="Cash">Cash</option>
							<option value="Bank">Bank</option>
						</select>
					</div>
					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Payment Date</label>
						<input type="text" id="payment_date" autocomplete="off" name="payment_date" placeholder="From Date" required style="width: 100%;">
					</div>

					<div class="form-group" style="display: none;" id="bank_area">
						<label for="Xlarge-input" class="col-form-label">Select Bank</label>
						<!--<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">-->
						<select id="bank_id" name="bank_id" style="width: 100%;">
							<option value="">Select Bank</option>
							<?php
                                    foreach ($bank as $val) {
                                    $name =  $val->bank_name ? ' ['. $val->bank_name.']' : "";
                                        ?>
							<option value="<?php echo $val->bank_id; ?>"><?php echo $name ; ?>
							</option>
							<?php
                                    }
                                    ?>
						</select>
					</div>
					<div class="form-group" style="display: none;" id="chaque_no">
						<label for="Xlarge-input" class="col-form-label">Chaque No</label>
						<input type="text" id="chaqueno" autocomplete="off" name="chaque_no" placeholder="Chaque No" required style="width: 100%;">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Reamrks</label>
						<textarea id="reamrks" name="reamrks" style="width: 100%;"></textarea>
					</div>

					<div class="form-group" style="display: none;">
						<label for="large-input" class="col-form-label">Status</label>
						<select id="status" name="status" style="width: 100%;">
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>

				</div>


				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
					<button type="button" class="btn btn-primary btn-block" onclick="saveData();" style="margin-top: -1px;"><i class="fa fa-check-square-o"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</form>
</div>

<script>
	function setDateValue(todate) {
		var fromdate = $("#fromdate").val();
        $("#loader").show();
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/moneyTraSummaryReport")}}',
			data: {
				fromdate: fromdate,
				todate: todate,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(data) {
				$('.cash_in_data').html(data.cash_in_data);
				$('.cash_out_data').html(data.cash_out_data);
				$('.currentBalace').html('Current Balance: ' + data.currentBalace + ' /=');
                $("#loader").hide();
			}
		});
	}


	jQuery(document).ready(function($) {
		$("#fromdate").datepicker();
		$("#todate").datepicker();
	});
	// ajax post
	function saveData() {
		var _token = $("input[name='_token']").val();
		var reciver_name = $("input[name=reciver_name]").val();
		var company_name = $("input[name=company_name]").val();
		var email = $("input[name=email]").val();
		var mobile_no = $("input[name=mobile_no]").val();
		var address = $("input[name=address]").val();
		var op_balanceid = $("input[name=op_balanceid]").val();
		var payment_type = $("select[name=payment_type]").val();
		var cash_type = $("select[name=cash_type]").val();
		var payment_date = $("input[name=payment_date]").val();
		var bank_id = $("select[name=bank_id]").val();
		var chaque_no = $("input[name=chaque_no]").val();
		var amount = $("input[name=amount]").val();
		var reamrks = $("#reamrks").val();
		var status = $("select[name=status]").val();

		if (reciver_name == "") {
			alert("Please write or select all blank filed.");
			$("#subcategory_id").focus();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: "save-opeining-balance",
			dataType: "json",
			data: {
				_token: _token,
				reciver_name: reciver_name,
				company_name: company_name,
				email: email,
				mobile_no: mobile_no,
				address: address,
				op_balanceid: op_balanceid,
				payment_type: payment_type,
				cash_type: cash_type,
				payment_date: payment_date,
				bank_id: bank_id,
				chaque_no: chaque_no,
				amount: amount,
				reamrks: reamrks,
				status: status
			},
			success: function(data) {
				$("#upload_form")[0].reset();
				featch_list();
                $('#modal-animation-4').modal('hide');
			}
		});
	}


	function PaymentMode(val) {
		//alert(val);
		if (val == "Bank") {
			$("#bank_area").show();
			$("#chaque_no").show();
		} else {
			$("#bank_area").hide();
			$("#chaque_no").hide();
		}
	}
	jQuery(document).ready(function($) {
		$("#payment_date").datepicker();
	});

	// ajax post
	function getbyId(op_balanceid) {

		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "find-opening-balance-row/" + op_balanceid,
			data: {
				"op_balanceid": op_balanceid,
				"_token": _token,
			},
			success: function(data) {
				//console.log(data);

				if (data.payment_type == "Bank") {
					$("#bank_area").show();
					$("#chaque_no").show();

				} else {
					$("#bank_area").hide();
					$("#chaque_no").hide();
				}

				$("#amount").val(data.amount);
				$("#bank_id").val(data.bank_id);
				$("#chaqueno").val(data.chaque_no);
				$("#subcategory_id").val(data.sub_category_id);
				$("#payment_date").val(data.payment_date);
				$("#payment_type").val(data.payment_type);
				$("#reciver_name").val(data.reciver_name);
				$("#company_name").val(data.company_name);
				$("#email").val(data.email);
				$("#address").val(data.address);
				$("#mobile_no").val(data.mobile_no);
				$("#reamrks").val(data.reamrks);
				$("#status").val(data.status);
                $("#cash_type").val(data.cash_type);
				$("#op_balanceid").val(data.op_balanceid);

				$('#modal-animation-4').modal('show');

			}
		});
	}

	function featch_list(query = '') {
		$.ajax({
			url: "{{ route('listOpeningBalance.search') }}",
			method: 'GET',
			data: {
				query: query
			},
			dataType: 'json',
			success: function(data) {
				$('.tbodys').html(data.table_data);
				$('#total_records').text("Total Invoice:" + data.total_data);
			}
		})
	}
	$(document).on('keyup', '#searchorder', function() {
		var query = $(this).val();
		featch_list(query);
	});
	featch_list();
	// Print
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>
@endsection