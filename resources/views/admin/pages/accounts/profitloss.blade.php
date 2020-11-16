@extends('admin.master')
@section('title',$title)
@section('maincontent')
@include('admin.common.datepicker')

<div class="content-wrapper">
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
									<span><strong>Profit Loss</strong> Report</span>
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
                        <br>
					</div>
                    <br>
				</form>
                
				<div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true"
                    class="fa fa-print"></i> Print</a></div>
				
					<center>
						<p><br>This report has been broken down into details</p>
					</center>
					<div id="printableArea">
					<table class="table" style="width: 100%;" id="profitloss">
						<thead class="thead-primary">
							<tr>
								<td class="text-center">Total Complete Order </td>
								<td class="text-center">Total Purchase</td>
								<td class="text-center">Total Expense</td>
								<td class="text-center">Total Salary</td>
								<td class="text-center">Total Amount</td>
							</tr>
						</thead>
						<tbody class="profitloss">
						</tbody>
					</table>
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
		$('#profitloss tbody tr').remove();
		$.ajax({
			url: "getReportProfitLoss?fdate=" + fdate + "&tdate=" + tdate,
			method: 'GET',
			dataType: 'json',
			success: function(data) {
				$('.profitloss').html(data.table_data);
			}
		})
	}

	$.noConflict();
	jQuery(document).ready(function($) {
		$("#fromdate").datepicker();
		$("#todate").datepicker();
		$("#status").val();

		var fdate = $("#fromdate").val();
		var tdate = $("#todate").val();
		//ready to get list
		$.ajax({
			url: "getReportProfitLoss?fdate=" + fdate + "&tdate=" + tdate,
			method: 'GET',
			dataType: 'json',
			success: function(data) {
				$('.profitloss').html(data.table_data);
			}
		})

	});
</script>
@endsection