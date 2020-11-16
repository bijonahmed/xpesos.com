@extends('admin.master')
@section('title',$title)
@section('maincontent')
@include('admin.common.datepicker')
<style>
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
			<span><strong>{{$title}}</strong></span>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px; text-algin: right;">
				<!-- <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" /> -->
				<center><span id="price_msg" style="font-size: 15px;"></span></center>

				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-primary alert-dismissible" role="alert">
							<div class="alert-icon">
								<i class="icon-check"></i>
							</div>
							<div class="alert-message">
								<span><strong>Details</strong> Report</span>
							</div>
						</div>
					</div>
				</div>

				<form enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
							<input type="text" id="fromdate" autocomplete="off" name="fromdate" placeholder="From Date" style="width: 100%;" value="<?php echo date("d-m-Y");?>" required>
						</div>
						<div class="col-md-6">
							<input type="text" id="todate" name="todate" autocomplete="off" placeholder="To Date" style="width: 100%;" value="<?php echo date("d-m-Y");?>" onchange="getReport(this.value)" required>
						</div>
					</div>
					<br>
				</form>
				<div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true" class="fa fa-print"></i> Print</a></div>
				<center>
					<div class="loader" id="loader" style="display:none;"></div>
				</center>
				<div id="printableArea">
					<center>
						<p><u><b>Vendor Transection Details</b></u></p>
					</center>
					<table style="width: 100%; color:black;" id="vendorpayment" class="table-hover table-striped">
						<thead class="thead-primary">
							<tr style="background-color: black; color:white;">
								<td class="text-left"> &nbsp;Vendor Name</td>
								<td class="text-center">Total Amount</td>
								<td class="text-center">Due Amount</td>
								<td class="text-center"></td>
								<td class="text-center"></td>
							</tr>
						</thead>
						<tbody class="vendorpayment">
						</tbody>
					</table>
					<center>
						<p><u><b>Expense Details</b></u></p>
					</center>
					<table style="width: 100%; color:black;" id="expense" class="table-hover table-striped">
						<thead class="thead-primary">
							<tr style="background-color: black; color:white;">
								<td class="text-left"> &nbsp;Expense Name</td>
								<td class="text-center">Payment Type</td>
								<td class="text-center">Bank Information</td>
								<td class="text-center">Payment Date</td>
								<td class="text-center">Amount</td>
							</tr>
						</thead>
						<tbody class="expense">
						</tbody>
					</table>
					<center>
						<p><u><b>Salary Details</b></u></p>
					</center>
					<table style="width: 100%; color:black;" id="salary" class="table-hover table-striped">
						<thead class="thead-primary">
							<tr style="background-color: black; color:white;">
								<td class="text-left"> &nbsp;Employee Name</td>
								<td class="text-center">Payment Type</td>
								<td class="text-center">Bank Information</td>
								<td class="text-center">Payment Date</td>
								<td class="text-center">Amount</td>
							</tr>
						</thead>
						<tbody class="salary">
						</tbody>
					</table>
					<span class="toalSum"></span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	// Print
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}

	function getReport(tdate) {
		var fdate = $("#fromdate").val();
		if (fdate == "") {
			alert("Please Select Date...");
			$("#fromdate").focus();
		}
		$("#loader").show();
		$('#expense tbody tr').remove();
		$('#vendorpayment tbody tr').remove();
		$('#salary tbody tr').remove();
		$.ajax({
			url: "getDetailsReport?fdate=" + fdate + "&tdate=" + tdate,
			method: 'GET',
			dataType: 'json',
			success: function(data) {
				$('.expense').html(data.expense);
				$('.vendorpayment').html(data.vendorpayment);
				$('.salary').html(data.salary);
				$('.toalSum').html(data.toalSum);
				$("#loader").hide();
			}
		})
	}

	function defaultchecKingDetailsReport() {
		var fdate = $("#fromdate").val();
		var tdate = $("#todate").val();
		$('#expense tbody tr').remove();
		$('#vendorpayment tbody tr').remove();
		$('#salary tbody tr').remove();
		$.ajax({
			url: "getDetailsReport?fdate=" + fdate + "&tdate=" + tdate,
			method: 'GET',
			dataType: 'json',
			success: function(data) {
				$('.expense').html(data.expense);
				$('.vendorpayment').html(data.vendorpayment);
				$('.salary').html(data.salary);
				$('.toalSum').html(data.toalSum);
			}
		})
	}
	$.noConflict();
	jQuery(document).ready(function($) {
		$("#fromdate").datepicker();
		$("#todate").datepicker();
		$("#status").val();
		defaultchecKingDetailsReport();
	});
</script>
@endsection