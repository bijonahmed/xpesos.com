<?php $data = DB::table('tbl_setting')->first(); ?>
<footer class="ps-footer">
	<div class="container">
		<div class="ps-footer__widgets">
			<aside class="widget widget_footer widget_contact-us">
				<h4 class="widget-title">Contact us</h4>
				<div class="widget_content">
					<p>Call us 24/7</p>
					<h3>{{ $data->tel }}
					</h3>
					<ul class="ps-list--social">
						<?php
						if (!empty($data->fblink)) {
						?>
							<li><a class="facebook" href="{{ $data->fblink }}"><i class="fa fa-facebook"></i></a></li>
						<?php } ?>

						<?php
						if (!empty($data->twitterlink)) {
						?>
							<li><a class="twitter" href="{{ $data->twitterlink }}"><i class="fa fa-twitter"></i></a></li>
						<?php } ?>
						<?php
						if (!empty($data->instragramlink)) {
						?>
							<li><a class="instagram" href="{{ $data->instragramlink }}"><i class="fa fa-instagram"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			</aside>
			<aside class="widget widget_footer">
				<h4 class="widget-title">Quick links</h4>
				<ul class="ps-list--link">
					<li><a href="{{ url('/policy') }}">Policy</a></li>
					<li><a href="{{ url('/trams-and-condition') }}">Term & Condition</a></li>
					<li><a href="{{ url('/privacy-and-policy') }}">Privacy and policiy</a></li>
					<li style="display: none;"><a href="#">Return</a></li>
					<li><a href="{{ url('/faq') }}">FAQs</a></li>
				</ul>
			</aside>
			<aside class="widget widget_footer">
				<h4 class="widget-title">Company</h4>
				<ul class="ps-list--link">
					<li><a href="{{ url('/about-us') }}">About Us</a></li>
					<li><a href="#">Affilate</a></li>
					<li><a href="#">Career</a></li>
					<li><a href="{{ url('/contact-us') }}">Contact</a></li>
				</ul>
			</aside>
			<aside class="widget widget_footer">
				<h4 class="widget-title">Bussiness</h4>
				<ul class="ps-list--link">
					<li><a href="{{ url('/sell-on-xpesos') }}">Sell on Xpesos</a></li>
					<li><a href="{{ url('/checkout') }}">Checkout</a></li>
					<li><a href="{{ url('/user-login-registration') }}">My account</a></li>
				</ul>
			</aside>
		</div>

		<div class="ps-footer__copyright">
			<p>{{ $data->copyright }}</p>
			<p><span>We Using Safe Payment For:</span><a href="#"><img src="{{url('fronted/img/payment-method/1.jpg')}}" alt="">
				</a><a href="#"><img src="{{url('fronted/img/payment-method/2.jpg')}}" alt=""></a>
				<a href="#"><img src="{{url('fronted/img/payment-method/3.jpg')}}" alt=""></a>
				<a href="#"><img src="{{url('fronted/img/payment-method/4.jpg')}}" alt=""></a>
				<a href="#"><img src="{{url('fronted/img/payment-method/5.jpg')}}" alt=""></a></p>
		</div>
	</div>
</footer>