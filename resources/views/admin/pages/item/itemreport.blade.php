@extends('admin.master')
@section('title','Item Report')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>
<div class="content-wrapper">

	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-11">
			<div class="card" style="padding: 10px;">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="{{url('/admin/item-list')}}">Back Item List</a></li>
						<li class="breadcrumb-item active" aria-current="page">Item Report</li>
					</ol>
				</nav>
				<br>

				<div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true" class="fa fa-print"></i> Print</a></div><br>
				<div id="printableArea">
					<table width="100%" border="1" class="table-hover">
						<tr>
							<td width="14%"> Item Name </td>
							<td width="60%">:<b> {{$row->product_name}}</b></td>
						</tr>
						<tr>
							<td>Item Code </td>
							<td colspan="3">:<b> {{$row->product_code}}</b> </td>
						</tr>
					</table>
					<center style="font-size: 18px; font-weight: bold;"><b><u style="color: green;">
								<br>
								(Opening Stock- {{$opening_stock->qnty}}),
								(Total Selling- {{$sout}}),
								(Total Purchase- <?php echo $purchase_data;?>) ,
								(Total Qty In Hand-
								<?php 
                            $openingBalance= $opening_stock->qnty;
                            $totalSelling= $sout;
                            $totalPurchase= $purchase_data;
                            $totalStock = $openingBalance + $totalPurchase - $totalSelling; 
                            if(isset($totalStock)){
                                echo $totalStock;
                            }
                            ?>)

							</u></b></center>

					<div class="row">
						<div class="col-md-5">
							<u><b>Purchase (Stock In Summary)</b></u><br>
							<table width="100%" border="1" class="table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Invoice ID</th>
										<th>Invoice Date</th>
										<th style="text-align: center;">Quantity</th>
									</tr>
								</thead>
								<tbody>
									<?php 
                                $x=1;
                                foreach ($purchase as $data) {
                                    ?>
									<tr>
										<td>&nbsp;<?php echo $x; $x++;?></td>
										<td>&nbsp;{{$data->supp_Invoice_id}}</td>
										<td>&nbsp;<?php echo date("d-m-Y", strtotime($data->invoice_date)) ?></td>
										<td style="text-align: center;">&nbsp;{{$data->qnty}}</td>
									</tr>
									<?php } ?>
								</tbody>

							</table>

						</div>
						<div class="col-md-6">
							<u><b>Selling (Stock Out Summary)</b></u><br>

							<table width="100%" border="1" class="table-hover">
								<thead>
									<tr>
										<th>&nbsp;#</th>
										<th style="text-align: center;">Order No</th>
										<th style="text-align: center;">Date</th>
										<th style="text-align: center;">Quantity</th>
									</tr>
								</thead>
								<tbody>
									<?php 
                                $x=1;
                                foreach ($stock_out as $data) {
                                
                                    ?>
									<tr>
										<td>&nbsp;<?php echo $x; $x++;?></td>
										<td style="text-align: center;">{{$data->OrderId}}</td>
										<td style="text-align: center;"><?php echo date("d-M-Y",strtotime($data->rdate))?></td>
										<td style="text-align: center;">{{$data->order_qnty}}</td>
									</tr>
									<?php } ?>
								</tbody>

							</table>
						</div>

					</div>
					<hr>
					<table width="100%" border="1">
						<tr>
							<td width="1015">
								<div align="right">Opening Stock</div>
							</td>
							<td width="78" style="text-align: right;">&nbsp;{{$openingBalance}}</td>
						</tr>
						<tr>
							<td>
								<div align="right">Total Purchase (+) </div>
							</td>
							<td style="text-align: right;">{{$totalPurchase}}</td>
						</tr>
						<tr>
							<td>
								<div align="right">Total Selling (-) </div>
							</td>
							<td style="text-align: right;">{{$totalSelling}}</td>
						</tr>
						<tr>
							<td>
								<div align="right"><strong><u>Total Qty In Hand</u></strong></div>
							</td>
							<td style="text-align: right; color: black; ">{{$totalStock}}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div><!-- End Row-->
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
</script>
@endsection