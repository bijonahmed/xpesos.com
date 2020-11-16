@extends('admin.master')
@section('title','Edit Company Setting')
@section('maincontent')

<div class="content-wrapper">
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">

			</div>
		</div>
	</div><!-- End Row-->
</div>
<div class="modal fade" id="modal-animation-3">
	<form id="cform" enctype="multipart/form-data" action="{{url('/admin/savessetting')}}" method="post">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title"><i class="fa fa-plus"></i> Company Setting</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Name</label>
								<input type="text" value="{{ $data->name }}" id="name" name="name" placeholder="Name.." style="width: 100%;" required>
								<input type="hidden" class="form-control" value="{{ $data->setting_id }}" id="setting_id" name="setting_id">

							</div>
							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Telephone</label>

								<input type="text" style="width: 100%;" id="slug" value="{{ $data->tel }}" name="tel" placeholder="Tel" required>


							</div>

							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Email</label>

								<input type="text" style="width: 100%;" id="email" value="{{ $data->email }}" name="email" placeholder="Email" required>

							</div>

							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Address</label>

								<textarea style="width: 100%;" id="address" name="address">{{ $data->address }}</textarea>


							</div>

							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Hotline</label>

								<input type="text" style="width: 100%;" id="hotline" value="{{ $data->hotline }}" name="hotline" required>


							</div>


							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Currency</label>
								<input type="text" style="width: 100%;" id="currency" value="{{ $data->currency }}" name="currency" required>
							</div>

						</div>
						<div class="col-md-3">




							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Emergency</label>

								<input type="text" style="width: 100%;" id="emergency" value="{{ $data->emergency }}" name="emergency" required>

							</div>


							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Bkas Number</label>

								<input type="text" style="width: 100%;" id="bkasnumber" value="{{ $data->bkasnumber }}" name="bkasnumber" required>

							</div>
							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Call for Order</label>

								<input type="text" style="width: 100%;" id="bkasnumber" value="{{ $data->callfororder }}" name="callfororder" required>

							</div>

							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Received order</label>
								<textarea id="recived_order" style="width: 100%;" name="recived_order"><?php $text = str_replace("<br>", "\n", $data->recived_order);?> {{$text}}</textarea>
							</div>

							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Confirm order</label>
								<textarea id="confirm_order" style="width: 100%;" name="confirm_order"><?php $text = str_replace("<br>", "\n", $data->confirm_order);?> {{$text}}</textarea>
							</div>

							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Shipped order</label>
								<textarea id="shipped_order" style="width: 100%;" name="shipped_order"><?php $text = str_replace("<br>", "\n", $data->shipped_order);?> {{$text}}</textarea>
							</div>

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Delivery Charge</label>
								<input type="text" style="width: 100%;" id="dvcharge" name="dvcharge" required value="{{ $data->dvcharge }}">

							</div>



							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Copyright</label>

								<input type="text" style="width: 100%;" id="copyright" value="{{ $data->copyright }}" name="copyright" required>


							</div>


							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Description</label>

								<textarea id="description" style="width: 100%;" name="description">{{ $data->description }}</textarea>

							</div>
							<div class="form-group">
								<label for="Xlarge-input" class="col-form-label">Photo</label>

								<input type="file" id="photo" name="photo">
								<br /><span style="color: red;">Must be upload (230x230)</span><br>
								 <img src="{{ url('admin/'.$data->photo) }}"> 

							</div>
							<div class="form-group">
								<label for="large-input" class="col-form-label">Status</label>

								<select style="width: 100%;" id="status" name="status">
									<option value='1'>Active</option>
									<option value='0'>Inactive</option>
								</select>

							</div>
						</div>




					</div>

					<hr>


					<div class="row">
						<div class="col-md-12">
							Banner Setting Option<br>
							<table width="100%" border="0" style="color:black;">
								<tr>
									<td>Position Left </td>
									<td>Position Right </td>
								</tr>
								<tr>
									<td>1.<input type="file" id="banner1" name="banner1">(570x210)
										<input type="text" name="banner1_link" placeholder="Banner Link" value="{{ $data->banner1_link }}"><br>
										<img src="{{ url('admin/'.$data->banner1) }}">

									</td>
									<td>2.<input type="file" id="banner2" name="banner2">(570x210)
										<input type="text" name="banner2_link" placeholder="Banner Link" value="{{ $data->banner2_link }}">
										<img src="{{ url('admin/'.$data->banner2) }}"></td>
								</tr>
								<tr>
									<td>3.<input type="file" id="banner3" name="banner3">(570x210)
										<input type="text" name="banner3_link" placeholder="Banner Link" value="{{ $data->banner3_link }}">
										<img src="{{ url('admin/'.$data->banner3) }}"></td>
									<td>4.<input type="file" id="banner4" name="banner4">(570x210)
										<input type="text" name="banner4_link" placeholder="Banner Link" value="{{ $data->banner4_link }}">
										<img src="{{ url('admin/'.$data->banner4) }}"></td>
								</tr>

								<tr>
									<td>5.<input type="file" id="banner5" name="banner5">(570x210)
										<input type="text" name="banner5_link" placeholder="Banner Link" value="{{ $data->banner5_link }}">
										<img src="{{ url('admin/'.$data->banner5) }}"></td>
									<td>6.<input type="file" id="banner6" name="banner6">(570x210)
										<input type="text" name="banner6_link" placeholder="Banner Link" value="{{ $data->banner6_link }}">
										<img src="{{ url('admin/'.$data->banner6) }}"></td>
								</tr>
								<tr>
									<td colspan="2">7.<input type="file" id="banner7" name="banner7">(1170x245)
										<input type="text" name="banner7_link" placeholder="Banner Link" value="{{ $data->banner7_link }}"><br>
										<img src="{{ url('admin/'.$data->banner7) }}" style="width:100%; height: 245px;"></td>
								</tr>
							</table>
						</div>

					</div>


					<div class="modal-footer">
						<div id="showmsg" style="text-align: center;"></div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
							Close</button>
						<button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
						</button>
					</div>
				</div>
			</div>
	</form>
</div>
</div>
</div>
<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>

<script>
	// Add Slug
	function convertToSlug(str) {
		str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
		str = str.replace(/^\s+|\s+$/gm, '');
		str = str.replace(/\s+/g, '-');
		$("#slug").val(str);

		//return str;
	}
	// Edit
	$(document).ready(function() {
		 
		var status = '<?php echo $data->status; ?>';
		$('#status').val(status);
		$('#modal-animation-3').modal('show');
	});
</script>
@endsection