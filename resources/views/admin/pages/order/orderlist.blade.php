@extends('admin.master')
@section('title','Order List')
@section('maincontent')

<div class="content-wrapper">
	<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Order</strong> List</span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 20px;">

				<div class="row">
					<div class="col-md-12">
						<div class="form-group" style="text-align: right; padding: 1px;">
							<input type="text" name="searchorder" id="searchorder" placeholder="Search" />
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
							<thead>
								<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
									<th>SL</th>
									<th>Vendor Name (Mobile)</th>
									<th>OrderId</th>
									<th>Order Date</th>
									<th style="text-align: center;">Status</th>
									<?php 
									 $role_id = Session::get('role_id');
									 if($role_id == 1){
									?>
									<th>Action</th>
									 <?php } ?>
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
</div>
</div><!-- End Row-->
</div>

</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="message">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-body">
				<p style="font-size: 28px; font-weight: bold; color: green;">Successfully Update Order.</p>
			</div>

		</div>
	</div>
</div>
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<script>
	// ajax post
	$('#orderUpdateFrm').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: "update-order",
			method: "POST",
			data: new FormData(this),
			dataType: 'JSON',
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				featch_order_list();
				$('#modal-animation-3').modal('hide')
				$('#message').modal('show')
				setTimeout(function() {
					$('#message').modal('hide')
				}, 1000);
			}
		})
	});

	function getbyId(order_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "order/searchOrder/" + order_id,
			data: {
				"order_id": order_id,
				"_token": _token,
			},
			success: function(data) {
				//console.log(data);
				//console.log(data.order_id);
				window.location.href = "orders/order-detail-information/" + data;
			}
		});
	}

	function featch_order_list(query = '') {
		$.ajax({
			url: "{{ route('listByOrder.search') }}",
			method: 'GET',
			data: {
				query: query
			},
			dataType: 'json',
			success: function(data) {
				$('.tbodys').html(data.table_data);
				//  $('#total_records').text("Total:" + data.total_data);
			}
		})
	}
	$(document).on('keyup', '#searchorder', function() {
		var query = $(this).val();
		featch_order_list(query);
	});
	featch_order_list();
</script>
@endsection