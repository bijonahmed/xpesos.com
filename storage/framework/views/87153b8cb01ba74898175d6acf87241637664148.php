<?php $data = DB::table('tbl_setting')->first(); ?>
<footer class="ps-footer">
	<div class="container">
		<div class="ps-footer__widgets">
			<aside class="widget widget_footer widget_contact-us">
				<h4 class="widget-title">Contact us</h4>
				<div class="widget_content">
					<p>Call us 24/7</p>
					<h3><?php echo e($data->tel); ?>

					</h3>
					<ul class="ps-list--social">
						<?php
						if (!empty($data->fblink)) {
						?>
							<li><a class="facebook" href="<?php echo e($data->fblink); ?>"><i class="fa fa-facebook"></i></a></li>
						<?php } ?>

						<?php
						if (!empty($data->twitterlink)) {
						?>
							<li><a class="twitter" href="<?php echo e($data->twitterlink); ?>"><i class="fa fa-twitter"></i></a></li>
						<?php } ?>
						<?php
						if (!empty($data->instragramlink)) {
						?>
							<li><a class="instagram" href="<?php echo e($data->instragramlink); ?>"><i class="fa fa-instagram"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			</aside>
			<aside class="widget widget_footer">
				<h4 class="widget-title">Quick links</h4>
				<ul class="ps-list--link">
					<li><a href="<?php echo e(url('/policy')); ?>">Policy</a></li>
					<li><a href="<?php echo e(url('/trams-and-condition')); ?>">Term & Condition</a></li>
					<li><a href="<?php echo e(url('/privacy-and-policy')); ?>">Privacy and policiy</a></li>
					<li style="display: none;"><a href="#">Return</a></li>
					<li><a href="<?php echo e(url('/faq')); ?>">FAQs</a></li>
				</ul>
			</aside>
			<aside class="widget widget_footer">
				<h4 class="widget-title">Company</h4>
				<ul class="ps-list--link">
					<li><a href="<?php echo e(url('/about-us')); ?>">About Us</a></li>
					<li><a href="#">Affilate</a></li>
					<li><a href="#">Career</a></li>
					<li><a href="<?php echo e(url('/contact-us')); ?>">Contact</a></li>
				</ul>
			</aside>
			<aside class="widget widget_footer">
				<h4 class="widget-title">Bussiness</h4>
				<ul class="ps-list--link">
					<li><a href="<?php echo e(url('/sell-on-xpesos')); ?>">Sell on Xpesos</a></li>
					<li><a href="<?php echo e(url('/checkout')); ?>">Checkout</a></li>
					<li><a href="<?php echo e(url('/user-login-registration')); ?>">My account</a></li>
				</ul>
			</aside>
		</div>

		<div class="ps-footer__copyright">
			<p><?php echo e($data->copyright); ?></p>
			<p><span>We Using Safe Payment For:</span><a href="#"><img src="<?php echo e(url('fronted/img/payment-method/1.jpg')); ?>" alt="">
				</a><a href="#"><img src="<?php echo e(url('fronted/img/payment-method/2.jpg')); ?>" alt=""></a>
				<a href="#"><img src="<?php echo e(url('fronted/img/payment-method/3.jpg')); ?>" alt=""></a>
				<a href="#"><img src="<?php echo e(url('fronted/img/payment-method/4.jpg')); ?>" alt=""></a>
				<a href="#"><img src="<?php echo e(url('fronted/img/payment-method/5.jpg')); ?>" alt=""></a></p>
		</div>
	</div>
</footer><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/common/footer.blade.php ENDPATH**/ ?>