<?php $__env->startSection('title','Customer List'); ?>
<?php $__env->startSection('maincontent'); ?>
<script src="<?php echo e(url('admin/assets/js/jquery.min.js')); ?>"></script>
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
			<span><strong>Customer</strong> List</span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding: 10px;">
				<div class="row">
					<div class="col-md-11">
						<div class="form-group" style="text-align: right;">
							<a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();" style="display:none;">
								<i class="fa fa-plus"></i> Add </a>
							<input type="text" name="searchproduct" id="searchproduct" placeholder="Search" />
						</div>
					</div>
				</div>
				<div class="table-responsive">
					  <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
						<thead>
							<tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
								<th>SL</th>
								<th>Customer Name</th>
								<th>Customer Email</th>
								<th>Customer Phone</th>
								<th>Rgistration Date</th>
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
	<!--<form id="cform" enctype="multipart/form-data" action="<?php echo e(url('/admin/SaveProduct')); ?>" method="post">-->
	 <form id="cform">
        <?php echo e(csrf_field()); ?>

		<div class="modal-dialog modal-lg ">
			<div class="modal-content animated">
				<div class="modal-header bg-primary">
					<h5 class="modal-title text-white"><i class="fa fa-check"></i> Add Customer</h5>
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
								<div class="col-md-5">
									<div class="form-group" id="post">
										<label for="Xlarge-input" class="col-form-label">Customer Name</label>
										<input type="text" id="customer_name" name="customer_name" placeholder="Customer Name" style="width: 100%;" required>
										<input type="hidden" class="form-control" id="customer_id" name="customer_id">
									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Email</label>
										<input type="text" id="email" name="email" placeholder="Email" required style="width: 100%;" onkeyup="checkUserEmail(this.value);">
										<span id="emailvalidation" style="color: red; font-weight: bold;"></span>
									</div>
									<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Mobile</label>
										<input type="text" id="mobile" name="mobile" placeholder="Mobile" required style="width: 100%;" onkeyup="checkUserMobile(this.value);">
										<span id="mobilevalidation" style="color: red; font-weight: bold;"></span>
									</div>
                                        	
								</div>
								<div class="col-md-5">
								<div class="form-group">
										<label for="Xlarge-input" class="col-form-label">Address
											</label>
										<textarea name="address" id="address" placeholder="Address" required style="width: 100%;"></textarea>
									</div>
									<div class="form-group" style="display:none;">
										<label for="Xlarge-input" class="col-form-label">Useranme</label>
										<input type="text" id="customer_username" name="customer_username" placeholder="Username" required style="width: 100%;" autcomplete="off" onkeyup="checkUsername(this.value);">
										<span id="usernamevalidation" style="color: red; font-weight: bold;"></span>
									</div>
									<div class="form-group" style="display:none;">
										<label for="Xlarge-input" class="col-form-label">Password</label>
										<input type="password" id="customer_password" name="customer_password" placeholder="Password" required style="width: 100%;">
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
								<button type="submit" id="signup" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
						</div>
					</div>
	</form>
</div>
<!-- Modal -->

<script>
 function emptyfrm(){
    	$("#cform")[0].reset();
 }
 
 // ajax post
$(".btn-submit").click(function(e) {
    e.preventDefault();
    var _token = $("input[name='_token']").val();
    var customer_name = $("input[name=customer_name]").val();
    var email = $("input[name=email]").val();
    var mobile = $("input[name=mobile]").val();
    var address = $("#address").val();
    var customer_id = $("input[name=customer_id]").val();
    var status = $("select[name=status]").val();
    if (customer_name == '' || email == '' || mobile == '') {
        alert("Please insert blank filed.");
        return false;
    }
    $.ajax({
        type: 'POST',
        url: "save-customer",
        dataType: "json",
        data: {
            _token: _token,
            customer_name: customer_name,
            email: email,
            mobile: mobile,
            address: address,
            customer_id: customer_id,
            status: status
        },
        success: function(data) {
            $('#modal-animation-3').modal('hide');
            $("#cform")[0].reset();
             featch_list();
           
        }
    });
});
	 
function checkUserEmail(email) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "admin-check-customer-email/" + email,
			data: {
				"mobile": email,
				"_token": _token,
			},
			success: function(data) {
				var msg = data;
				var textmesg = "Please try again another Email Number. already exits";
				if (msg == '1') {
					$("#emailvalidation").text(textmesg);
					$("#email").focus();
					$("#signup").hide();
				} else {
					var textmesg = '';
					$("#emailvalidation").text(textmesg);
					$("#signup").show();
				}
			}
		});
	}

	function checkUserMobile(mobile) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "admin-check-customer-mobile/" + mobile,
			data: {
				"mobile": mobile,
				"_token": _token,
			},
			success: function(data) {
				var msg = data;
				var textmesg = "Please try again another Mobile Number. already exits";
				if (msg == '1') {
					$("#mobilevalidation").text(textmesg);
					$("#mobile").focus();
					$("#signup").hide();
				} else {
					var textmesg = '';
					$("#mobilevalidation").text(textmesg);
					$("#signup").show();
				}
			}
		});
	}

	function checkUsername(username) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "admin-check-customer/" + username,
			data: {
				"username": username,
				"_token": _token,
			},
			success: function(data) {
				var msg = data;
				var textmesg = "Please try again another Username. already exits";
				if (msg == '1') {
					$("#usernamevalidation").text(textmesg);
					$("#customer_username").focus();
					$("#signup").hide();
				} else {
					var textmesg = '';
					$("#usernamevalidation").text(textmesg);
					$("#signup").show();
				}
			}
		});
	}
	// Edit
	function getbyId(customer_id) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "customer/searhCustomerId/" + customer_id,
			data: {
				"customer_id": customer_id,
				"_token": _token,
			},
			success: function(data) {
                $("#customer_name").val(data.customer_name );
                $("#email").val(data.email);
                $("#mobile").val(data.mobile);
                $("#customer_id").val(data.customer_id);
                $("#address").val(data.address);
                $("#customer_username").val(data.customer_username);
                $("#status").val(data.status);
                $('#modal-animation-3').modal();
                featch_list();
			}
		});
	}
		function featch_list(query = '') {
			console.log("test");
			$.ajax({
				url: "<?php echo e(route('customerlist.search')); ?>",
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
		$(document).on('keyup', '#searchproduct', function() {
			var query = $(this).val();
			featch_list(query);
		});
        featch_list();
// new script 

var page = 1; //track user scroll as page number, right now page number is 1
load_more(page); //initial content load
$(window).scroll(function() { //detect page scroll
    if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
        page++; //page number increment
        load_more(page); //load content   
    }
});     
function load_more(page){
  $.ajax(
        {
            url: '?page=' + page,
            type: "get",
            datatype: "html",
            beforeSend: function()
            {
                $('.ajax-loading').show();
            }
        })
        .done(function(data)
        {
            if(data.length == 0){
            console.log(data.length);
               
                //notify user if nothing to load
                $('.ajax-loading').html("No more records!");
                return;
            }
            $('.ajax-loading').hide(); //hide loading animation once data is received
            $("#results").append(data); //append data into #results element          
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              alert('No response from server');
        });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/admin/pages/customer/customerlist.blade.php ENDPATH**/ ?>