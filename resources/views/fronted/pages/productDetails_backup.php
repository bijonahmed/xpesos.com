@extends('fronted.master')
@section('title',$title)
@section('maincontent')
<div class="container">
	<div class="ps-breadcrumb">
		<div class="ps-container">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}">Home</a></li>
				<li>{{ $product->product_name }}</li>
			</ul>
		</div>
	</div>
</div>
<div class="ps-page--product ps-page--product-box">
	<div class="container">
		<div class="ps-product--detail ps-product--box">
			<div class="ps-product__header ps-product__box">
				<div class="ps-product__thumbnail" data-vertical="true">
					<figure>
						<div class="ps-wrapper">
							<div class="ps-product__gallery" data-arrow="true">
								<?php
								if (!empty($product->photo1)) {
								?>
									<div class="item"><a href="{{ $product->photo1 }}">
											<img src="{{ $product->photo1 }}" alt=""></a></div>
								<?php } ?>
								<?php
								foreach ($showimg as $i) {
								?>
									<div class="item"><a href="{{ $i->guid }}"><img src="{{ $i->guid }}"></a></div>
								<?php } ?>

							</div>
						</div>
					</figure>
					<div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">
						<?php
						if (!empty($product->photo1)) {
						?>
							<div class="item"><img src="{{ $product->photo1 }}" alt=""></div>
						<?php } ?>
						<?php
						foreach ($showimg as $i) {
						?>
							<div class="item"><a href="{{ $i->guid }}"><img src="{{ $i->guid }}"></a></div>
						<?php } ?>
					</div>
				</div>
				<div class="ps-product__info">
					<h1>{{ $product->product_name }}</h1>
					<div class="ps-product__meta">
						<p style="display: none;">Brand:<a href="#">Sony</a></p>
						<div class="ps-product__rating">
							<select class="ps-rating" data-read-only="true">
								<option value="1">1</option>
								<option value="1">2</option>
								<option value="1">3</option>
								<option value="1">4</option>
								<option value="2">5</option>
							</select><span>(1 review)</span>
						</div>
					</div>
					<h4 class="ps-product__price">{{ $setting->currency }}{{ $product->special_price }}
						<del>{{ $product->regular_price }}</del></h4>
					<div class="ps-product__desc">
						<p style="display: none;">Sold By:<a href="#"><strong> Go Pro</strong></a></p>
						<p>
							<?php echo nl2br("$product->pro_long_description"); ?>
						</p>

					</div>
					<div class="ps-product__variations">
						<figure style="display: none;">
							<figcaption>Color</figcaption>
							<div class="ps-variant ps-variant--color color--1"><span class="ps-variant__tooltip">Black</span></div>
							<div class="ps-variant ps-variant--color color--2"><span class="ps-variant__tooltip"> Gray</span></div>
						</figure>
					</div>
					<form class="ps-form--newsletter" id="upload_form" method="post" action="{{url('/add-to-cart')}}">
						{{ csrf_field() }}
						<div class="ps-product__shopping">
							<figure>
								<figcaption>Quantity</figcaption>
								<div class="form-group--number">
									<button class="up"><i class="fa fa-plus"></i></button>
									<button class="down"><i class="fa fa-minus"></i></button>
									<input class="form-control" type="text" name="qty" placeholder="1" value="1" required>
								</div>
							</figure>
							<input type="hidden" name="product_id" value="{{ $product->product_id }}" />
							<button class="ps-btn ps-btn--black" type="submit">Add to cart</button>
					</form>
					<a class="ps-btn" href="{{ url('checkout') }}">Buy Now</a>
					<div class="ps-product__actions"><a href="#"><i class="icon-heart"></i></a><a href="#"></a></div>
				</div>
				<div class="ps-product__specification"><a class="report" href="#">Report Abuse</a>
					<p><strong>SKU:</strong> {{ $product->product_code }}</p>
					<p class="categories"><strong> Categories:</strong>
						@if(!empty($product->category_name))
						<a href="#">{{$product->category_name}}</a>
						@endif

						@if(!empty($product->sub_cat_name))
						<a href="#">{{$product->sub_cat_name}}</a>
						@endif

						@if(!empty($product->sub_in_sub_cat_name))
						<a href="#">{{$product->sub_in_sub_cat_name}}</a>
						@endif

						<p class="tags" style="display: none;"><strong> Tags</strong><a href="#">sofa</a>,<a href="#">technologies</a>,<a href="#">wireless</a></p>
				</div>
				<div class="ps-product__sharing" style="display: none;"><a class="facebook" href="#"><i class="fa fa-facebook"></i></a><a class="twitter" href="#"><i class="fa fa-twitter"></i></a><a class="google" href="#"><i class="fa fa-google-plus"></i></a><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></div>
			</div>
		</div>
		<div class="ps-product__content ps-tab-root">
			<div class="row">
				<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 ">
					<div class="ps-product__box">
						<ul class="ps-tab-list">
							<li class="active"><a href="#tab-1">Description</a></li>
							<li><a href="#tab-2">Specification</a></li>
							<li><a href="#tab-3">Vendor</a></li>
							<li><a href="#tab-4">Reviews (1)</a></li>
							<li><a href="#tab-5">Questions and Answers</a></li>
							<li><a href="#tab-6">More Offers</a></li>
						</ul>
						<div class="ps-tabs">
							<div class="ps-tab active" id="tab-1">
								<div class="ps-document">
									<?php echo nl2br("$product->pro_long_description"); ?>
								</div>
							</div>
							<div class="ps-tab" id="tab-2">
								<div class="table-responsive">
									<table class="table table-bordered ps-table ps-table--specification">
										<tbody>
											<tr>
												<td>Color</td>
												<td>Black, Gray</td>
											</tr>
											<tr>
												<td>Style</td>
												<td>Ear Hook</td>
											</tr>
											<tr>
												<td>Wireless</td>
												<td>Yes</td>
											</tr>
											<tr>
												<td>Dimensions</td>
												<td>5.5 x 5.5 x 9.5 inches</td>
											</tr>
											<tr>
												<td>Weight</td>
												<td>6.61 pounds</td>
											</tr>
											<tr>
												<td>Battery Life</td>
												<td>20 hours</td>
											</tr>
											<tr>
												<td>Bluetooth</td>
												<td>Yes</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="ps-tab" id="tab-3">
								<h4>GoPro</h4>
								<p>Digiworld US, New York’s no.1 online retailer was established in May 2012 with the aim and vision to become the one-stop shop for retail in New York with implementation of best practices both online</p><a href="#">More Products from gopro</a>
							</div>
							<div class="ps-tab" id="tab-4">
								<div class="row">
									<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 ">
										<div class="ps-block--average-rating">
											<div class="ps-block__header">
												<h3>4.00</h3>
												<select class="ps-rating" data-read-only="true">
													<option value="1">1</option>
													<option value="1">2</option>
													<option value="1">3</option>
													<option value="1">4</option>
													<option value="2">5</option>
												</select><span>1 Review</span>
											</div>
											<div class="ps-block__star"><span>5 Star</span>
												<div class="ps-progress" data-value="100"><span></span></div><span>100%</span>
											</div>
											<div class="ps-block__star"><span>4 Star</span>
												<div class="ps-progress" data-value="0"><span></span></div><span>0</span>
											</div>
											<div class="ps-block__star"><span>3 Star</span>
												<div class="ps-progress" data-value="0"><span></span></div><span>0</span>
											</div>
											<div class="ps-block__star"><span>2 Star</span>
												<div class="ps-progress" data-value="0"><span></span></div><span>0</span>
											</div>
											<div class="ps-block__star"><span>1 Star</span>
												<div class="ps-progress" data-value="0"><span></span></div><span>0</span>
											</div>
										</div>
									</div>
									<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
										<form class="ps-form--review" action="#" method="get">
											<h4>Submit Your Review</h4>
											<p>Your email address will not be published. Required fields are marked<sup>*</sup></p>
											<div class="form-group form-group__rating">
												<label>Your rating of this product</label>
												<select class="ps-rating" data-read-only="false">
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>
											<div class="form-group">
												<textarea class="form-control" rows="6" placeholder="Write your review here"></textarea>
											</div>
											<div class="row">
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
													<div class="form-group">
														<input class="form-control" type="text" placeholder="Your Name">
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
													<div class="form-group">
														<input class="form-control" type="email" placeholder="Your Email">
													</div>
												</div>
											</div>
											<div class="form-group submit">
												<button class="ps-btn">Submit Review</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="ps-tab" id="tab-5">
								<div class="ps-block--questions-answers">
									<h3>Questions and Answers</h3>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Have a question? Search for answer?">
									</div>
								</div>
							</div>
							<div class="ps-tab active" id="tab-6">
								<p>Sorry no more offers available</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 ">
					<div class="ps-product__box">
						<aside class="widget widget_same-brand">
							<h3>Same Brand</h3>
							<div class="widget__content">
								<?php $relatedProduct = DB::table('tbl_product')->where('category_id', $product->category_id)->limit(2)->get();
								foreach ($relatedProduct as $item) {
								?>
									<div class="ps-product">
										<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$item->slug )}}">
												<img src="{{ $item->photo1 }}" alt="product" style="height: 180px;"></a>
											<div class="ps-product__badge">{{ $product->percentage }}</div>
											<ul class="ps-product__actions">
												<li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
												<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
												<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
											</ul>
										</div>
										<div class="ps-product__container"><a class="ps-product__vendor" href="#">Robert's Store</a>
											<div class="ps-product__content"><a class="ps-product__title" href="{{ url ('/product-details/'.$item->slug )}}">Grand Slam Indoor Of Show Jumping Novel</a>
												<div class="ps-product__rating">
													<select class="ps-rating" data-read-only="true">
														<option value="1">1</option>
														<option value="1">2</option>
														<option value="1">3</option>
														<option value="1">4</option>
														<option value="2">5</option>
													</select><span>01</span>
												</div>
												<p class="ps-product__price sale">{{ $setting->currency }}{{ $product->special_price }} <del>{{ $product->regular_price }} </del></p>
											</div>
											<div class="ps-product__content hover"><a class="ps-product__title" href="{{ url ('/product-details/'.$item->slug )}}">Grand Slam Indoor Of Show Jumping Novel</a>
												<p class="ps-product__price sale">{{ $setting->currency }}{{ $product->special_price }} <del>{{ $product->regular_price }} </del></p>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</aside>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ps-section--default">
		<div class="ps-section__header">
			<h3>Related products</h3>
		</div>
		<div class="ps-section__content">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
				<?php $relatedProduct = DB::table('tbl_product')->where('category_id', $product->category_id)->get();
				foreach ($relatedProduct as $item) {
				?>
					<div class="ps-product">
						<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$item->slug )}}">
								<img src="{{ $item->photo1 }}" alt="product" style="height: 180px; width: 150px;"></a>
							<ul class="ps-product__actions">
								<li><a href="#" data-toggle="tooltip" data-placement="top" title="Read More"><i class="icon-bag2"></i></a></li>
								<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
								<li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
							</ul>
						</div>
						<div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>
							<div class="ps-product__content"><a class="ps-product__title" href="{{ url ('/product-details/'.$item->slug )}}">{{ $product->product_name }}</a>
								<div class="ps-product__rating">
									<select class="ps-rating" data-read-only="true">
										<option value="1">1</option>
										<option value="1">2</option>
										<option value="1">3</option>
										<option value="1">4</option>
										<option value="2">5</option>
									</select><span>01</span>
								</div>
								<p class="ps-product__price">{{ $setting->currency }}{{ $product->special_price }} <del>{{ $product->regular_price }}</del></p>
							</div>
							<div class="ps-product__content hover"><a class="ps-product__title" href="{{ url ('/product-details/'.$item->slug )}}">{{ $product->product_name }}</a>
								<p class="ps-product__price">{{ $setting->currency }}{{ $product->special_price }}
									<del>{{ $product->regular_price }}</del></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</div>
@endsection