@extends('admin.master')
@section('title','Post List')
@section('maincontent')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<div class="content-wrapper">
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">

				<div class="card-header">
					<div class="row">
						<div class="col-md-8">
							<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();">
								<i class="fa fa-plus"></i> Create a new Post </a>

						</div>
						<div class="col-md-2" style="text-align:right;">
							<a href="#" onclick="location.reload();emptyfrm();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload
							</a>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-md-12">
						<div class="form-group" style="text-align: right; padding: 10px;">
							<input type="text" name="searchnews" id="searchnews" placeholder="Search" />
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
						<thead>
							<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
								<th>SL</th>
								<th>Menu</th>
								<th>Sub Menu</th>
								<th>In Sub Menu</th>
								<th>Post Title</th>
								<th>Entry Date</th>
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
	<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SavePost')}}" method="post">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-star"></i> Add Post</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Menu</label>
						<select id="menu_id" name="menu_id" required="required" onchange="getMenuVal(this.value);" style="width: 100%;">
							<option value="">Select Menu</option>
							<?php
                                foreach ($menu as $val) {
                                    ?>
							<option value="<?php echo $val->menu_id; ?>"><?php echo $val->name; ?></option>
							<?php
                                }
                                ?>
						</select>
					</div>
					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Sub Menu</label>

						<select id="sub_menu_id" name="sub_menu_id" onchange="getSubMenuVal(this.value);" style="width: 100%;">
							<option value="">Select Sub Menu</option>
							<?php
                                foreach ($submenu as $val) {
                                    ?>
							<option value="<?php echo $val->sub_menu_id; ?>"><?php echo $val->name; ?></option>
							<?php
                                }
                                ?>
						</select>

					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Sub In Menu</label>
						<select id="sub_in_sub_id" name="sub_in_sub_id" style="width: 100%;">
							<option value="">Select in Sub Menu</option>
							<?php
                               foreach ($in_sub_menu as $val) {
                                    ?>
							<option value="<?php echo $val->sub_in_sub_id; ?>"><?php echo $val->name; ?></option>
							<?php
                                }
                                ?>
						</select>

					</div>

					<div class="form-group" id="post">
						<label for="Xlarge-input" class="col-form-label">Post Title</label>

						<input type="text" id="post_title" name="post_title" placeholder="Post Title.." onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" style="width: 100%;">
						<input type="hidden" class="form-control" id="post_id" name="post_id">
					</div>
					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Slug</label>
						<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">
					</div>

					<div class="form-group">
						<label for="Xlarge-input" class="col-form-label">Description</label>
						<textarea id="post_description" name="post_description" style="width: 100%;"></textarea>

					</div>
					<div class="form-group row">
						<label for="Xlarge-input" class="col-sm-3 col-form-label">Photo</label>
						<div class="col-sm-9">
							<input type="file" id="photo" name="photo">
							<br /><span style="color: red;">Must be upload</span>
							<div id="insertedImages"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="large-input" class="col-form-label">Status</label>

						<select class="form-control form-control" id="status" name="status">
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>

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
	function emptyfrm() {

		$('#cform')[0].reset();
	}
	// Data Table List View
	CKEDITOR.replace('post_description');

	function convertToSlug(str) {
		//replace all special characters | symbols with a space
		str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
		// trim spaces at start and end of string
		str = str.replace(/^\s+|\s+$/gm, '');
		// replace space with dash/hyphen
		str = str.replace(/\s+/g, '-');
		$("#slug").val(str);
		//return str;
	}
	// Edit
	function getbyId(post_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "post/searhPostId/" + post_id,
			data: {
				"post_id": post_id,
				"_token": _token,
			},
			success: function(data) {
				var id = data.post_id;
				urls = "editpost/" + post_id,
					window.open(urls, '_blank');
			}

		});

		// $('#modal-animation-3').modal('show');
		// CKEDITOR.replace( 'post_description' );

	}

	$(document).ready(function() {
		//  alert("test");
		featch_post_list();

		function featch_post_list(query = '') {
			console.log("test");
			$.ajax({
				url: "{{ route('listByPost.search') }}",
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

		$(document).on('keyup', '#searchnews', function() {
			var query = $(this).val();
			featch_post_list(query);
		});

	});

	function getMenuVal(menu_id) {
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/get-sub-menu")}}',
			data: {
				menu_id: menu_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(response) {
				$("#sub_menu_id").empty();
				remove_submenu();
				$.each(response, function(index, submenu) {
					$("#sub_menu_id").append('<option value="' + submenu.sub_menu_id + '">' + submenu
						.name + '</option>');
				});
				// $("select[name=district_id]").val(response.district_id);
			}

		});

	}

	function getSubMenuVal(sub_menu_id) {
		condition(sub_menu_id);
		$.ajax({
			type: "get",
			url: '{{URL::to("admin/sub-menu-in-menu")}}',
			data: {
				sub_menu_id: sub_menu_id,
				_token: $('#token').val()
			},
			dataType: 'json',
			success: function(response) {

				$("#sub_in_sub_id").empty();
				remove_insubmenu();
				$.each(response, function(index, insubmenu) {
					$("#sub_in_sub_id").append('<option value="' + insubmenu.sub_in_sub_id + '">' +
						insubmenu
						.name + '</option>');
				});
				// $("select[name=district_id]").val(response.district_id);
			}

		});

	}

	function condition(sub_menu_id) {
		if (sub_menu_id == 1) {
			// $('#post').hide();
			$('#mname').show();
			$('#dname').show();
		} else {
			//$('#post').show();
			$('#mname').hide();
			$('#dname').hide();

		}
	}

	function remove_insubmenu() {
		$('#sub_in_sub_id').append('<option selected="selected" value="">Select</option>');
	}

	function remove_submenu() {
		$('#sub_menu_id').append('<option selected="selected" value="">Select</option>');
	}
</script>
@endsection