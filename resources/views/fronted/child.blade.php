<?php $data = DB::table('tbl_setting')->first(); ?>
@extends('fronted.master')
@section('title','Xpesos - Buy and Sell Online')
@section('maincontent')

@include('fronted.common.homeBanner')

<div class="ps-site-features">
	<div class="container">
		<div class="ps-block--site-features ps-block--site-features-2">
			<div class="ps-block__item" style="padding:0px 10px;">
				<div class="ps-block__left"><i class="icon-rocket" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Free Delivery</h4>
					<p>for all orders over $50</p>
				</div>
			</div>
			<div class="ps-block__item" style="padding:0px 10px;">
				<div class="ps-block__left" style="margin-bottom: 0px;"><i class="icon-sync" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>30 Day Return</h4>
					<p>On Eligble Items</p>
				</div>
			</div>
			<div class="ps-block__item" style="padding:0px 10px;">
				<div class="ps-block__left" style="margin-bottom: 0px;"><i class="icon-credit-card" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Secure Payment</h4>
					<p>100% Secure payment</p>
				</div>
			</div>
			<div class="ps-block__item" style="padding:0px 10px;">
				<div class="ps-block__left" style="margin-bottom: 0px;"><i class="icon-bubbles" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>24/7 Support</h4>
					<p>Dedicated support</p>
				</div>
			</div>
			<div class="ps-block__item" style="padding:0px 10px;">
				<div class="ps-block__left" style="margin-bottom: 0px;"><i class="icon-gift" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Gift Service</h4>
					<p>Support gift service</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-best-sale-brands ps-section--furniture ps-section--furniture-new" style="border: none; padding-bottom: 0px;">
	<div class="container">

		<div class="ps-section__content">
			<ul class="ps-image-list ps-image-list-new">

				@foreach($category as $i)
				<li class="own-li"><a href="{{ $i->slug }}"><img src="{{ url('admin/'.$i->photo) }}" alt="category" style="width: 170px; height: 60px;">
						<p>{{ $i->category_name }}</p>
					</a>
				</li>

				@endforeach


			</ul>
		</div>
	</div>
</div>

<center>
								<div class="loader" style="display: none;"></div>
							</center>

<div class="ps-product-list" style="border:none; padding-top: 0px;">
	<div class="container">
		<div class="ps-section__header bgClrBeguni" style="background-color: #0000FF!important; border-radious: 1px;">
			<h3 style="color:white;">{{ $topselling_row->sp_category_name }}</h3>
			<ul class="ps-section__links">

				<li><a href="{{ url('shop-list/'.$topselling_row->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
	 
		<div class="ps-section__content ps-section__content-new" style="background-color: white; border-radius: 10px; margin-top: 10px; margin-bottom:10px;">
			<div id="topselling" style="display: none;"
			class="ps-carousel--nav owl-slider" data-owl-auto="false" 
			data-owl-loop="false" data-owl-speed="10000" data-owl-gap="20"
			 data-owl-nav="true" data-owl-dots="true" data-owl-item="6" 
			 data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3"
			  data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" 
			  data-owl-mousedrag="on">
				@foreach($top_selling as $i)
				<div class="ps-product mb-40" style="padding: 20px 8px 0; border-radious:10px; border-color: white;">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}">
							<img src="{{ url('admin/'.$i->photo1) }}" alt="product" style="width: 100%; height: 150px;" /></a>
						<?php
						if (!empty($i->percentage)) { ?>
							<div class="ps-product__badge"><?php
															echo $i->percentage . '%';
															?></div>
						<?php } ?>
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>

					<div class="ps-product__container">
						<div class="ps-product__content" style="color: #000;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover" style="border: none;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		</div>
	</div>
</div>

<div class="ps-product-list" style="border:none; padding-top: 0px;">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #FF0000!important; color: white;">
			<h3 style="color:white;">{{ $todaydeal_row->sp_category_name }}</h3>
			<ul class="ps-section__links">
				<li><a href="{{ url('shop-list/'.$todaydeal_row->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new" style="background-color: white; border-radius: 10px; margin-top: 10px; margin-bottom:10px;">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" 
			data-owl-speed="10000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" 
			data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="6" 
			data-owl-duration="1000" data-owl-mousedrag="on"
			id="todaydel" style="display: none;">
				@foreach($today_deal as $i)
				<div class="ps-product mb-40" style="padding: 20px 8px 0; border-radious:10px; border-color: white;">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}">
							<img src="{{ url('admin/'.$i->photo1) }}" alt="product" style="width: 100%; height: 150px;" /></a>
						<?php
						if (!empty($i->percentage)) { ?>
							<div class="ps-product__badge"><?php
															echo $i->percentage . '%';
															?></div>
						<?php } ?>
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>

					<div class="ps-product__container">
						<div class="ps-product__content" style="color: #000;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover" style="border: none;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>


<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="{{ $data->banner1_link }}"><img src="{{ url('admin/'.$data->banner1) }}" alt="" style="border-radius: 10px;"></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="{{ $data->banner2_link }}"><img src="{{ url('admin/'.$data->banner2) }}" alt="" style="border-radius: 10px;"></a>
			</div>
		</div>
	</div>
</div>


<div class="ps-product-list" style="border:none; padding-top: 0px;">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> {{ $selectedItems_row->sp_category_name }}</h3>
			<ul class="ps-section__links">
				<li><a href="{{ url('shop-list/'.$selectedItems_row->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new" style="background-color: white; border-radius: 10px; margin-top: 10px; margin-bottom:10px;">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
				@foreach($selected_Items as $i)
				<div class="ps-product mb-40" style="padding: 20px 8px 0; border-radious:10px; border-color: white;">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}">
							<img src="{{ url('admin/'.$i->photo1) }}" alt="product" style="width: 100%; height: 150px;" /></a>
						<?php
						if (!empty($i->percentage)) { ?>
							<div class="ps-product__badge"><?php
															echo $i->percentage . '%';
															?></div>
						<?php } ?>
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>

					<div class="ps-product__container">
						<div class="ps-product__content" style="color: #000;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover" style="border: none;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

<div class="ps-home-categories ps-section--furniture dsply-none">
	<div class="container">
		<div class="ps-section__header">
			<h3>Featured Categories</h3>
		</div>
		<div class="ps-section__content">
			<div class="row">
				@foreach($fcategory as $i)
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category" style="border-radius: 5px; background: white;">
						<a href="{{ url ('/shop-list-category/'.$i->slug )}}">
						</a><img src="{{ url('admin/'.$i->photo) }}" alt="category" style="width: 100%; height: 150px;">
						<p>{{ $i->post_title }}</p>
					</div>
				</div>
				@endforeach

			</div>
		</div>
	</div>
</div>

<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="{{ $data->banner3_link }}"><img src="{{ url('admin/'.$data->banner3) }}" alt="" style="border-radius: 10px;"></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="{{ $data->banner4_link }}"><img src="{{ url('admin/'.$data->banner4) }}" alt="" style="border-radius: 10px;"></a>
			</div>
		</div>
	</div>
</div>

<div class="ps-product-list" style="border:none; padding-top: 0px;">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> {{ $global_festival_row->sp_category_name }}</h3>
			<ul class="ps-section__links">
				<li><a href="{{ url('shop-list/'.$global_festival_row->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new" style="background-color: white; border-radius: 10px; margin-top: 10px; margin-bottom:10px;">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false"
			 data-owl-loop="false" data-owl-speed="10000" data-owl-gap="20"
			  data-owl-nav="true" data-owl-dots="true" data-owl-item="6" 
			  data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" 
			  data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" 
			  data-owl-mousedrag="on" id="globalfestival">
				@foreach($global_festival as $i)
				<div class="ps-product mb-40" style="padding: 20px 8px 0; border-radious:10px; border-color: white;">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}">
							<img src="{{ url('admin/'.$i->photo1) }}" alt="product" style="width: 100%; height: 150px;" /></a>
						<?php
						if (!empty($i->percentage)) { ?>
							<div class="ps-product__badge"><?php
															echo $i->percentage . '%';
															?></div>
						<?php } ?>
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>

					<div class="ps-product__container">
						<div class="ps-product__content" style="color: #000;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover" style="border: none;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="{{ $data->banner5_link }}"><img src="{{ url('admin/'.$data->banner5) }}" alt="" style="border-radius: 10px;"></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="{{ $data->banner6_link }}"><img src="{{ url('admin/'.$data->banner6) }}" alt="" style="border-radius: 10px;"></a>
			</div>
		</div>
	</div>
</div>

<div class="ps-product-list" style="border:none; padding-top: 0px;">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> {{ $women_fashion_row->sp_category_name }}</h3>
			<ul class="ps-section__links">
				<li><a href="{{ url('shop-list/'.$women_fashion_row->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new" style="background-color: white; border-radius: 10px; margin-top: 10px; margin-bottom:10px;">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000" 
			data-owl-gap="20" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" 
			data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" 
			data-owl-mousedrag="on" id="womenFashion">
				@foreach($women_fashion as $i)
				<div class="ps-product mb-40" style="padding: 20px 8px 0; border-radious:10px; border-color: white;">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}">
							<img src="{{ url('admin/'.$i->photo1) }}" alt="product" style="width: 100%; height: 150px;" /></a>
						<?php
						if (!empty($i->percentage)) { ?>
							<div class="ps-product__badge"><?php
															echo $i->percentage . '%';
															?></div>
						<?php } ?>
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>

					<div class="ps-product__container">
						<div class="ps-product__content" style="color: #000;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover" style="border: none;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

<div class="ps-promotion ps-promotion--2 dsply-none">
	<div class="container"><a class="ps-collection" href="{{ $data->banner7_link }}"><img src="{{ url('admin/'.$data->banner7) }}" alt=""></a></div>
</div>

<div class="ps-best-sale-brands ps-section--furniture dsply-none">
	<div class="container">
		<div class="ps-section__header">
			<h3>TOP BRANDS</h3>
		</div>
		<div class="ps-section__content">
			<ul class="ps-image-list">
				@foreach ($brand as $i)
				<li><a href="#"><img src="{{ url('admin/'.$i->photo) }}" alt="brand"></a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>

<div class="ps-product-list" style="border:none; padding-top: 0px;">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> {{ $home_office_row->sp_category_name }}</h3>
			<ul class="ps-section__links">
				<li><a href="{{ url('shop-list/'.$home_office_row->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new" style="background-color: white; border-radius: 10px; margin-top: 10px; margin-bottom:10px;">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
			 data-owl-gap="20" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" 
			 data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="6" data-owl-duration="1000" 
			 data-owl-mousedrag="on" id="homeOffice">
				@foreach($home_office as $i)
				<div class="ps-product mb-40" style="padding: 20px 8px 0; border-radious:10px; border-color: white;">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}">
							<img src="{{ url('admin/'.$i->photo1) }}" alt="product" style="width: 100%; height: 150px;" /></a>
						<?php
						if (!empty($i->percentage)) { ?>
							<div class="ps-product__badge"><?php
															echo $i->percentage . '%';
															?></div>
						<?php } ?>
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>

					<div class="ps-product__container">
						<div class="ps-product__content" style="color: #000;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover" style="border: none;"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale" style="color: #000; line-height: 17px;">{{ $setting->currency }}{{ $i->special_price }} <br /><del style="font-size:13px;">{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

<div class="download-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<img src="{{url('fronted/img/bg/mobile-Ad.png')}}" class="img-responsive" />
			</div>
			<div class="col-md-6">
				<div class="download-text">
					<h1>Download xpesos App Now!</h1>
					<p>Personalise your selling and shopping experience by downloading xpesos app on your mobile</p>
					<form class="ps-form--newsletter" id="upload_form" action="{{url('/send-newsletter')}}" method="post">
						{{ csrf_field() }}
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
					</form>
				</div>
				<div class="download_icon">
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
							<img src="{{url('fronted/img/icons/playstore.png')}}" class="img-responsive" />
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
							<img src="{{url('fronted/img/icons/applestore.png')}}" class="img-responsive" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
				<h3> Online Shopping</h3>
				<p class="shoping-pera">
					<?php
					$description = $data->description;
					echo nl2br("$description");
					?>
				</p>
			</div>
		</div>
	</div>
</div>

@endsection

