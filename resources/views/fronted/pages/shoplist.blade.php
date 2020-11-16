@extends('fronted.master')
@section('title',$title)
@section('maincontent')
<div class="container">
	<div class="ps-breadcrumb">
		<div class="ps-container">
			<ul class="breadcrumb">
				<li><a href="{{ url('/') }}">Home</a></li>
				<li>Shop</li>
			</ul>
		</div>
	</div>
</div>
 
<div class="ps-promotion ps-promotion--2">
	<div class="container"><a class="ps-collection" href="#"><img src="{{url('fronted/img/promotions/home-2-3.jpg')}}" alt=""></a></div>
</div>
<div class="ps-page--shop" id="shop-sidebar">
	<div class="container">
		<div class="ps-layout--shop">
			<div class="ps-layout__left">
				<aside class="widget widget_shop">
					<h4 class="widget-title">Categories</h4>
					<ul class="ps-list--categories">
						<?php
						foreach ($category as $i) {
							$subcategory = DB::table('tbl_subcategory')->where('category_id', $i->category_id)->where('status', 1)->get();
						?>
							<li class="current-menu-item menu-item-has-children"><a href="{{ url ('/shop-list-category/'.$i->slug )}}">{{ $i->category_name }}</a>
								<span class="sub-toggle"><i class="fa fa-angle-down"></i></span>
								<ul class="sub-menu">
									<?php
									foreach ($subcategory as $i) {
									?>
										<li class="current-menu-item "><a href="{{ url ('/shop-list-category/'.$i->slug )}}">{{$i->sub_cat_name}}</a>
										<?php } ?>
										</li>
								</ul>
							</li>
						<?php } ?>
					 
					</ul>
				</aside>
				<aside class="widget widget_shop">
					<h4 class="widget-title">BY BRANDS</h4>
					<form class="ps-form--widget-search" action="#" method="get">
						<input class="form-control" type="text" placeholder="Brand Name" id="brand_name">
						<button><i class="icon-magnifier"></i></button>
					</form>
					<figure class="ps-custom-scrollbar" data-height="250">

						@foreach($brand as $i)
						<?php
						if (!empty($i->brand_id)) {
							$count = DB::table('tbl_product')->where('brand_id', $i->brand_id)->where('status', 1)->count();
						}
						?>
						<label for="brand-1_{{ $i->brand_id }}"><a href="{{ url('find-brand/'.$i->slug) }}"> {{ $i->brand_name }} ({{$count}})</a></label><br>
						<div class="ps-checkbox" style="display: none;">
							<input style="display: none;" class="form-control" type="checkbox" id="brand-1_{{ $i->brand_id }}" value="{{ $i->slug }}">

						</div>
						@endforeach
					</figure>
					<figure style="display:none;">
						<h4 class="widget-title">By Price</h4>
						<div class="ps-slider" data-default-min="13" data-default-max="1300" data-max="1311" data-step="100" data-unit="$"></div>
						<p class="ps-slider__meta">Price:<span class="ps-slider__value ps-slider__min"></span>-<span class="ps-slider__value ps-slider__max"></span></p>
					</figure>
					<figure style="display:none;">
						<h4 class="widget-title">By Price</h4>
						<div class="ps-checkbox">
							<input class="form-control" type="checkbox" id="review-1" name="review">
							<label for="review-1"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i></span><small>(13)</small></label>
						</div>
					</figure>
					<figure style="display:none;">
						<h4 class="widget-title">By Color</h4>
						<div class="ps-checkbox ps-checkbox--color color-1 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-1" name="size">
							<label for="color-1"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-2 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-2" name="size">
							<label for="color-2"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-3 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-3" name="size">
							<label for="color-3"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-4 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-4" name="size">
							<label for="color-4"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-5 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-5" name="size">
							<label for="color-5"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-6 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-6" name="size">
							<label for="color-6"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-7 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-7" name="size">
							<label for="color-7"></label>
						</div>
						<div class="ps-checkbox ps-checkbox--color color-8 ps-checkbox--inline">
							<input class="form-control" type="checkbox" id="color-8" name="size">
							<label for="color-8"></label>
						</div>
					</figure>
					<figure class="sizes">
						<h4 class="widget-title">BY SIZE</h4><a href="#">L</a><a href="#">M</a><a href="#">S</a><a href="#">XL</a>
					</figure>
				</aside>
			</div>
			<div class="ps-layout__right">
				<div class="ps-shopping ps-tab-root">
					<div class="ps-shopping__header">
						<p><strong> <?php echo count($product); ?></strong> Products found</p>
						<div class="ps-shopping__actions">
							<select class="ps-select" data-placeholder="Sort Items">
								<option>Sort by latest</option>
								<option>Sort by popularity</option>
								<option>Sort by average rating</option>
								<option>Sort by price: low to high</option>
								<option>Sort by price: high to low</option>
							</select>
							<div class="ps-shopping__view">
								<p>View</p>
								<ul class="ps-tab-list">
									<li class="active"><a href="#tab-1"><i class="icon-grid"></i></a></li>
									<li><a href="#tab-2"><i class="icon-list4"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="ps-tabs">
						<div class="ps-tab active" id="tab-1">
							<div class="ps-shopping-product">
								<div class="row">
									<?php
									foreach ($product as $p) {
									?>
										<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
											<div class="ps-product">
												<div class="ps-product__thumbnail">
													<a href="{{ url ('/product-details/'.$p->slug )}}"><img src="{{ $p->photo1 }}" alt="" style="height: 180px;"></a>
													<ul class="ps-product__actions">
														<li><a href="{{ url ('/product-details/'.$p->slug )}}" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
														<li><a href="{{url ('/whishlist')}}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
													</ul>
												</div>
												<div class="ps-product__container"><a class="ps-product__vendor" href="#">{{$p->product_name}}</a>
													<div class="ps-product__content"><a class="ps-product__title" href="{{ url ('/product-details/'.$p->slug )}}">{{ $p->product_name }}</a>
														<p class="ps-product__price">{{ $setting->currency }}{{ $p->special_price }}
															<del>{{ $p->regular_price }}</del></p>
													</div>
													<div class="ps-product__content hover"><a class="ps-product__title" href="{{ url ('/product-details/'.$p->slug )}}">{{ $p->product_name }}</a>
														<p class="ps-product__price">{{ $setting->currency }}{{ $p->special_price }}
															<del>{{ $p->regular_price }}</del></p>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="ps-tab" id="tab-2">
							<div class="ps-shopping-product">
								<?php
								foreach ($product as $p) {
								?>
									<div class="ps-product ps-product--wide">
										<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$p->slug )}}">
												<img src="{{ $p->photo1 }}" alt="product" style="height: 180px;"></a>
											<?php
											if (!empty($i->percentage)) { ?>
												<div class="ps-product__badge"><?php
																				echo $i->percentage . '%';
																				?></div>
											<?php } ?>
										</div>
										<div class="ps-product__container">
											<div class="ps-product__content"><a class="ps-product__title" href="{{ url ('/product-details/'.$p->slug )}}">{{ $p->product_name }}</a>
												<p class="ps-product__vendor">Sold by:<a href="#">Youngshop</a></p>
												<p>
													<?php echo nl2br("$p->pro_long_description"); ?>
												</p>
											</div>
											<div class="ps-product__shopping">
												<p class="ps-product__price sale">{{ $setting->currency }}{{ $p->special_price }}
													<del>{{ $p->regular_price }} </del> </p>

												<a class="ps-btn" href="{{url('add-to-cart')}}">Add to cart</a>
												<ul class="ps-product__actions">
													<li><a href="{{url ('/product-details/'.$p->slug)}}"><i class="icon-heart"></i> Wishlist</a></li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection