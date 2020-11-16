<div class="ps-newsletter">
	<div class="container">
		<form class="ps-form--newsletter" action="<?php echo e(url('/send-newsletter')); ?>" method="post">
		<?php echo e(csrf_field()); ?>

			<div class="row">
				<div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 ">
					<div class="ps-form__left">
						<h3>Newsletter</h3>
						<p>Subcribe to get information about products and coupons</p>
					</div>
				</div>
				<div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 ">
					<div class="ps-form__right">
						<div style="color:green; text-align: center;"><?php
																		$messages = Session::get('newsletters');
																		if (!empty($messages)) {
																			echo $messages;
																			session::put('newsletters', null);
																		}
																		?></div>
						<div class="form-group--nest">
							<input class="form-control" type="email" required name="email_id" id="email_id" placeholder="Email address">
							<button class="ps-btn" type="submit">Subscribe</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/common/newsLetter.blade.php ENDPATH**/ ?>