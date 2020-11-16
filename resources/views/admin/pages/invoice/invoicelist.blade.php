@extends('admin.master')
@section('title','Invoice List')
@section('maincontent')
<style>
	link.active {
		color:
			#000;
		background-color:
			#fff;
		border-color:
			#dee2e6 #dee2e6 #fff;
	}
</style>
<div class="content-wrapper">
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 20px;">
            <div id="total_records"></div>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="text-align: right; padding: 1px;">

                                <a href="{{url('admin/create-a-new-invoice')}}">
                                <i class="fa fa-plus"></i> Create a new invoice</a>
									<input type="text" name="searchorder" id="searchorder" placeholder="Search" />
								</div>
							</div>
							<div class="table-responsive">
							<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
									<thead>
										<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
											<th>SL</th>
											<th>OrderId</th>
											<th>Total </th>
											<th>Advance </th>
											<th>Due </th>
											<th>Order Date</th>
											<th style="text-align: center;">Status</th>
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
		</div>
	</div><!-- End Row-->
</div>
</div>
</div>
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<script>
	// ajax post
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
				window.location.href = "orders/order-detail-information/" + data.order_id;
			}
		});
	}
	function featch_order_list(query = '') {
		$.ajax({
			url: "{{ route('listByInvoice.search') }}",
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
		featch_order_list(query);
	});
	featch_order_list();
</script>
@endsection