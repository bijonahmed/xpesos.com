<?php
$data = DB::table('tbl_setting')->where('status', 1)->first();

?> 

<style>
.ps-footer__copyright {
	/* padding: 35px 0; */
	display: -webkit-box;
	display: flex;
	-webkit-box-orient: horizontal;
	-webkit-box-direction: normal;
	flex-flow: row nowrap;
	-webkit-box-pack: justify;
	justify-content: space-between;
	border-top: 1px solid #e1e1e1;
}
.ps-footer {
    padding-top: 10px;
}
</style>
<footer class="ps-footer">
<div class="ps-container">
    <div class="ps-footer__widgets">
        <aside class="widget widget_footer widget_contact-us">
            <h4 class="widget-title">Contact us</h4>
            <div class="widget_content">
                <p>Call us Hotline 24/7</p>
                <p> {{ $data->hotline }}  </p>
                <p>Address: {{ $data->address }}</p>
                <p>Email: {{ $data->email }}</p>  <br>
                <ul class="ps-list--social">
                <?php 
                if(!empty($data->fblink)){
                ?>
                    <li><a class="facebook" href="{{ $data->fblink }}"><i class="fa fa-facebook"></i></a></li>
                <?php } ?>

                <?php 
                if(!empty($data->twitterlink)){
                ?>
                    <li><a class="twitter" href="{{ $data->twitterlink }}"><i class="fa fa-twitter"></i></a></li>
                    <?php } ?>
                    <?php 
                if(!empty($data->instragramlink)){
                ?>
                    <li><a class="instagram" href="{{ $data->instragramlink }}"><i class="fa fa-instagram"></i></a></li>
                    <?php } ?>
                </ul>
            </div>
        </aside>
        <aside class="widget widget_footer">
            <h4 class="widget-title">Quick links</h4>
            <ul class="ps-list--link">
                <li><a href="#">Policy</a></li>
                <li><a href="#">Term & Condition</a></li>
                <li><a href="#">Shipping</a></li>
                <li><a href="#">Return</a></li>
                <li><a href="faqs.html">FAQs</a></li>
            </ul>
        </aside>
        <aside class="widget widget_footer">
            <h4 class="widget-title">Company</h4>
            <ul class="ps-list--link">
                <li><a href="about-us.html">About Us</a></li>
                <li><a href="#">Affilate</a></li>
                <li><a href="#">Career</a></li>
                <li><a href="contact-us.html">Contact</a></li>
            </ul>
        </aside>
        <aside class="widget widget_footer">
            <h4 class="widget-title">Bussiness</h4>
            <ul class="ps-list--link">
                <li><a href="#">Our Press</a></li>
                <li><a href="checkout.html">Checkout</a></li>
                <li><a href="my-account.html">My account</a></li>
                <li><a href="shop-default.html">Shop</a></li>
            </ul>
        </aside>
    </div>
    
    <div class="ps-footer__copyright">
        <p>{{$data->copyright}}</p>
        <p><span>We Using Safe Payment For:</span><a href="#"><img src="{{asset('fronted/img/payment-method/1.jpg')}}" alt=""></a><a
                href="#"><img src="{{asset('fronted/img/payment-method/2.jpg')}}" alt=""></a><a href="#"><img
                    src="{{asset('fronted/img/payment-method/3.jpg')}}" alt=""></a><a href="#"><img src="{{asset('fronted/img/payment-method/4.jpg')}}"
                    alt=""></a><a href="#"><img src="{{asset('fronted/img/payment-method/5.jpg')}}" alt=""></a></p>
    </div>
</div>
</footer>
