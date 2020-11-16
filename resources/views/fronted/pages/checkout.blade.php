@extends('fronted.master')
@section('title',$title)
@section('maincontent')
<style>
	input {
		color: inherit;
		line-height: 1.5;
		height: 2.5em;
		padding: .25em 0;
		background-color: #f68b1e;
	}
</style>
<div class="ps-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="{{url('/')}}">Home</a></li>
			<li>Checkout</li>
		</ul>
	</div>
</div>

<div class="ps-checkout ps-section--shopping">
	<div class="container">
		<!--<div class="ps-section__header">
            <h1>Checkout Product</h1>
        </div>-->
		<div class="ps-section__content">

			<div class="row">
				<div class="col-xl-7 col-lg-8 col-md-12 col-sm-12  ">
					<p style="border: 1px solid #e6e4e4; background: #e6e4e4; color: black; font-size: 20px; text-align: center; padding: 10px; font-family: 'Work Sans', Arial, sans-serif;">Returning customer?
						<a data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="color: blue;">Click here to login </a></p>
					<div class="ps-tabs" id="panel">
						<div class="ps-tab active" id="sign-in">
							<div class="ps-form__content">



								<div class="collapse" id="collapseExample">
									<div class="card card-body">
										<h5>Log In Your Account</h5>
										<div class="form-group" style="width: 100%; margin-bottom: 1.5rem;">
											<input class="form-control" type="text" placeholder="Username" id="check_user_name" name="check_uer_name">
										</div>
										<div class="form-group form-forgot" style="width: 100%;">
											<input class="form-control" type="password" placeholder="Password" id="check_user_pass" name="check_user_pass">

										</div>

										<div class="form-group submtit" style="width: 25%;">
											<button class="ps-btn ps-btn--fullwidth" type="button" onclick="loginCustomer();">Login</button>
										</div>
									</div>
								</div>




							</div>
							<!--<div class="ps-form__footer">
                                    <p>Connect with:</p>
                                    <ul class="ps-list--social">
                                        <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a class="google" href="#"><i class="fa fa-google"></i></a></li>
                                        <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                </div>-->
						</div>
					</div>
					<form class="ps-form--checkout" action="{{ url('charge') }}" method="post">
						{{ csrf_field() }}


						<div class="ps-form__billing-info">
							<h3 class="ps-form__heading" style="margin-bottom: 30px;">Billing Details</h3>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">First Name<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="text" name="f_name" id="f_name" required="required">
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Last Name<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="text" name="l_name" id="l_name" required="required">
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Company Name
								</label>
								<div class="form-group__content">
									<input class="form-control" type="text" name="company_name" id="company_name">
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Email Address<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="email" name="email" id="email" required>
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Country<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<select class="form-control form-control-lg" id="country" name="country">
										<option>Select a country / region...</option>
										<option>Nigeria</option>
										<option>United Kingdom(UK)</option>
									</select><br>
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Phone<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="text" name="phone" id="phone" required>
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Address<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="text" name="address" id="address">
								</div>
							</div>

							<div class="form-group" style="margin-bottom: 6px; display:none;" id="labelUsername">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Username<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="text" name="customer_username" id="customer_username" onchange="checkUserName(this.value);">
									<span id="errormessage"></span>
								</div>
							</div>


							<div class="form-group" style="margin-bottom: 6px; display:none;" id="labelPassword">
								<label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;">Password<sup style="color: red; font-weight: 700;">*</sup>
								</label>
								<div class="form-group__content">
									<input class="form-control" type="password" name="customer_password" id="customer_password">
								</div>
							</div>


							<div class="form-group" style="margin-bottom: 6px;">
								<div class="ps-checkbox">
									<input class="form-control" type="checkbox" id="create-account" name="create_account" value="yes" onclick="showUserPass();">
									<label for="create-account">Create an account?</label>
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 6px;">
								<div class="ps-checkbox">
									<input class="form-control" type="checkbox" id="cb01" name="ship_diff_address" value="yes">
									<label for="cb01">Ship to a different address?</label>
								</div>
							</div>
							<h3 class="mt-40"> Addition information</h3>
							<div class="form-group" style="margin-bottom: 6px;">
								<label>Order Notes</label>
								<div class="form-group__content">
									<textarea class="form-control" rows="7" name="add_infor" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
								</div>
							</div>
						</div>
				</div>
				<div class="col-xl-5 col-lg-4 col-md-12 col-sm-12  ">
					<p style="border: 1px solid #e6e4e4; background: #e6e4e4; color: black; font-size: 20px; text-align: center; padding: 10px; font-family: 'Work Sans', Arial, sans-serif;">Have a coupon? <a data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample" style="color: blue;">
							Click here to enter your code</a></p>
					<div class="collapse" id="collapseExample2">
						<div class="card card-body">
							<figure>
								<figcaption>Coupon Discount</figcaption>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="">
								</div>
								<div class="form-group" style="width: 40%;">
									<button class="ps-btn ps-btn--fullwidth">Apply</button>
								</div>
							</figure>
						</div>
					</div>
					<div class="ps-form__total">
						<h3 class="ps-form__heading" style="font-family: 'Work Sans', Arial, sans-serif; margin-top:0px 20px;">Your Order</h3>
						<div class="content">
							<div class="ps-block--checkout-total" style="border:1px solid #bfbfbf; background-color: #f1f1f1;">
								<!--<div class="ps-block__header">
                                        <p>Product</p>
                                        <p>Total</p>
                                    </div>-->
								<div class="ps-block__content">
									<table class="table ps-block__products">
										<thead style="font-size: 18px;">
											<tr>
												<th>Product</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$x = 1;
											$sum = 0;
											$contents = Cart::getContent();
											foreach ($contents as $item) {
												$pcode = DB::table('tbl_product')->where('product_id', $item->id)->first();
											?>

												<tr>
													<td><a href="#"> <?php
																		$txt = $item->name;
																		echo wordwrap($txt, 50, "<br />");
																		if (!empty($item->attributes->has('size'))) {
																			$size = json_encode($item->attributes->size, JSON_UNESCAPED_SLASHES);
																			if (!empty($size)) {
																				echo $output = str_replace('"', "", "$size");
																			}
																		}
																		?></a>
														<!-- <p>Sold By:<strong>YOUNG SHOP</strong></p> -->
													</td>
													<td><?php echo $setting->currency . ' ' . $pcode->special_price * $item->quantity ?></td>
												</tr>

											<?php } ?>

										</tbody>
										<tfoot>
											<tr>
												<th style="font-size: 18px;">Subtotal</th>
												<input type="hidden" name="amount" value="<?php echo (int) Cart::getSubTotal(); ?>" />
												<td><span style="color: red; font-size: 18px;"><?php echo $setting->currency . ' ' . number_format(Cart::getSubTotal()); ?></span></td>
											</tr>
											<tr>
												<th>Coupon: first order discount</th>
												<td>-$0.55</td>
											</tr>
											<tr>
												<td>
													<h4>Shipping</h4>

													<div class="form-check">
														<input class="form-check-input" type="radio" name="shippingOption" id="shippingOption" checked value="Free UK Delivery 3-5 Days">
														<label class="form-check-label" for="exampleRadios1" style="margin-top: 4px;">
															Free UK Delivery 3-5 Days
														</label>
													</div>
													<div class="form-check">
														<input class="form-check-input" type="radio" name="shippingOption" id="shippingOption2" value="Local pickup ">
														<label class="form-check-label" for="exampleRadios2" style="margin-top: 4px;">
															Local pickup
														</label>
													</div>

												</td>
											</tr>
											<tr>
												<th style="font-size: 18px;">Total</th>
												<td><span style="color: red; font-size: 18px;"><?php echo $setting->currency . ' ' . number_format(Cart::getSubTotal()); ?></span></td>
											</tr>
										</tfoot>

									</table>
									<!--<h4 class="ps-block__title">Subtotal <span>$863.49</span></h4>-->
									<div class="ps-block__shippings">

										<!--<div class="form-check">
                                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked style="margin-top: 20px;">
                                              <label class="form-check-label" for="exampleRadios1" style="margin-top: 4px; margin-left: 30px;">
                                                 PayPal
                                                         <img src="img/payment-method/paypal.png" width="50%">
                                                         <a href="#" style="color: blue;">Why is PayPal?</a>
                                                    
                                              </label>
                                            </div>-->


										<p style="font-size: .92em; margin-left: 20px;">Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
									</div>
								</div>
							</div>
							<br>
							<p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p><br>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="exampleCheck1">

								<label class="form-check-label" for="exampleCheck1" style="margin-top: 4px;" required="required">I have read and agree to the website <a herf="#">terms and conditions</a>*</label>
							</div><br>
							<!-- <a class="ps-btn ps-btn--fullwidth">Make Payment &nbsp;&nbsp;<i class="fa fa-credit-card" aria-hidden="true"></i></a> -->
							<input type="submit" name="submit" id="continuebtn" class="btn btn-block" value="Pay Now Paypal">
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<script>
	function showUserPass() {
		$("#labelUsername").toggle();
		$("#labelPassword").toggle();
		$("#customer_username").attr("required", true);
		$("#customer_password").attr("required", true);
	}

	function checkUserName(username) {
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: "user/checkuserName/" + username,
			data: {
				"username": username,
				"_token": _token,
			},
			success: function(result) {

				if (result == 'yes') {
					$("#continuebtn").hide();
					$("#errormessage").text("Sorry already username exits.");
					$("#customer_username").focus();
				}
				if (result == 'no') {
					$("#errormessage").text("");
					$("#continuebtn").show();
				}

			}
		});

	}

	function loginCustomer() {
		var x = $("#check_user_name").val();
		var y = $("#check_user_pass").val();
		var _token = $("input[name='_token']").val();

		if (x == "" || y == "") {
			alert("Please Fillup Username / Password");
			$('#check_user_name').attr('required', 'required');
		}else{
			$.ajax({
            type: 'POST',
            dataType: "json",
            url: "{{ url('/customerUserNamePassword') }}",
            data: {
                "customer_username": x,
				"customer_password": y,
                "_token": _token,
            },
            success: function(result) {
				if (result == 'yes') {
					window.location.href = "{{ url('/customer-panel') }}";
                }
                if (result == 'no') {
					alert("User ID/ Password not mateching...");
					$('#check_user_name').focus();
                }

            }
        });


		}
	}
</script>
@endsection