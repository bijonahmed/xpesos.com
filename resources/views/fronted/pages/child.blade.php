@extends('fronted.master')
@section('title','Welcome')
@section('maincontent')
<?php
$category = DB::table('tbl_category')->where('status', 1)->orderBy('tbl_category.sort', 'asc')->get();
?>
@include('fronted.common.homeBanner')
<div class="ps-site-features">
	<div class="container">
		<div class="ps-block--site-features ps-block--site-features-2">
			<div class="ps-block__item">
				<div class="ps-block__left"><i class="fa fa-archive" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Official Stores</h4>
					<p>&nbsp;</p>
				</div>
			</div>
			<div class="ps-block__item">
				<div class="ps-block__left"><i class="fa fa-money" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Airtime Cashback</h4>
					<p>&nbsp;</p>
				</div>
			</div>
			<div class="ps-block__item">
				<div class="ps-block__left"><i class="fa fa-cutlery" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Food</h4>
					<p>&nbsp;</p>
				</div>
			</div>
			<div class="ps-block__item">
				<div class="ps-block__left"><i class="fa fa-globe" aria-hidden="true"></i></div>
				<div class="ps-block__right">
					<h4>Global</h4>
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-best-sale-brands ps-section--furniture ps-section--furniture-new">
	<div class="container">

		<div class="ps-section__content">
			<ul class="ps-image-list ps-image-list-new">
				<li class="own-li"><a href="#"><img src="{{url('fronted/img/icons/Dress-icon-170x170.png')}}" alt="">
						<p>Women's Fashion</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="{{url('fronted/img/icons/Men-icon-170x170.png')}}"
							alt=""><br />
						<p>Men's Fashion</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="{{url('fronted/img/icons/Mobile-icon-170x170.png')}}"
							alt=""><br />
						<p>Phone & Accessories</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="{{url('fronted/img/icons/Kids-icon-170x170.png')}}"
							alt=""><br />
						<p>Toys Kids & Babies</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="img/icons/Home-170x170.png')}}" alt=""><br />
						<p>Home & Kitchen</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="img/icons/Health-and-Beau-170x170.png')}}" alt=""><br />
						<p>Health & Beauty</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="img/icons/Jewellery-170x170.png')}}" alt=""><br />
						<p>Jewellery & Watches</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="img/icons/iconfinder_204_-_Laptop_1739535-170x170.png')}}"
							alt=""><br />
						<p>Computer & office</p>
					</a></li>
				<li class="own-li"><a href="#"><img src="img/icons/Mobile-icon-170x170.png')}}" alt=""><br />
						<p>Phone & Accessories</p>
					</a></li>
			</ul>
		</div>
	</div>
</div>




<div class="ps-product-list">
	<div class="container">
		<div class="ps-section__header bgClrBeguni" style="background-color: #0000FF!important;">
			<h3 style="color:white;">Top selling items</h3>
			<ul class="ps-section__links">

				<li><a href="{{ url('shop-list/'.$catTopselling->slug) }}" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
				data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2"
				data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5"
				data-owl-duration="1000" data-owl-mousedrag="on">
                
                <?php
                         foreach($topselling_product as $i){
                ?>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="{{ url ('/product-details/'.$i->slug )}}"><img
								src="{{ url('admin/'.$i->photo1) }}" alt="product" style="height: 180px;" /></a>
                                    
                                    <?php
                        if(!empty($i->percentage)){?>
						<div class="ps-product__badge"><?php
                          echo $i->percentage.'%';                        
                        ?></div>
                            <?php }?>
                            
                            
						<ul class="ps-product__actions">
							<li><a href="{{ url ('/product-details/'.$i->slug )}}" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<!--<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>-->
							<li><a href="{{url ('/whishlist'.$i->slug)}}" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>

							<p class="ps-product__price sale">{{ $i->special_price }}&nbsp;<del>{{ $i->regular_price }}</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="{{url ('/product-details/'.$i->slug )}}">{{ $i->product_name }}</a>
							<p class="ps-product__price sale">{{ $i->special_price }}&nbsp;<del>{{ $i->regular_price }}</del></p>
						</div>
					</div>
				</div>
                    <?php }?>
                    
                    
				 
			</div>
		</div>
	</div>
</div>

<div class="ps-product-list">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #FF0000!important; color: white;">
			<h3 style="color:white;">Deals Of The Day | Just For You</h3>
			<ul class="ps-section__links">
				<li><a href="shop-grid.html" style="color:white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
				data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2"
				data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5"
				data-owl-duration="1000" data-owl-mousedrag="on">
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-home-categories ps-section--furniture dsply-none">
	<div class="container">
		<div class="ps-section__header">
			<h3>Collections Shipped From Abroad!</h3>
		</div>
		<div class="ps-section__content">
			<div class="row">
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/1.png')}}" alt="">
						<p>Sofas</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/2.png')}}" alt="">
						<p>Chairs</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/3.png')}}" alt="">
						<p>Tables</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/4.png')}}" alt="">
						<p>TV Boards</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/5.png')}}" alt="">
						<p>Storages</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/6.png')}}" alt="">
						<p>Rugs</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/7.png')}}" alt="">
						<p>Lamp &amp; Lighting</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/8.png')}}" alt="">
						<p>Furnishings</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/9.png')}}" alt="">
						<p>Ottomans</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/10.png')}}" alt="">
						<p>Shelfs</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/11.png')}}" alt="">
						<p>Kid Furnitures</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/icons/click-see-more.gif')}}" alt="">
						<p>See More...</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-1.jpg')}}" alt=""></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-2.jpg')}}" alt=""></a>
			</div>
		</div>
	</div>
</div>

<div class="ps-product-list">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> Express | Free Shipping On Selected Items!</h3>
			<ul class="ps-section__links">

				<li><a href="shop-grid.html" style="color: white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
				data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2"
				data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5"
				data-owl-duration="1000" data-owl-mousedrag="on">
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
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
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/1.png')}}" alt="">
						<p>Sofas</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/2.png')}}" alt="">
						<p>Chairs</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/3.png')}}" alt="">
						<p>Tables</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/4.png')}}" alt="">
						<p>TV Boards</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/5.png')}}" alt="">
						<p>Storages</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/6.png')}}" alt="">
						<p>Rugs</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/7.png')}}" alt="">
						<p>Lamp &amp; Lighting</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/8.png')}}" alt="">
						<p>Furnishings</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/9.png')}}" alt="">
						<p>Ottomans</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/10.png')}}" alt="">
						<p>Shelfs</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/11.png')}}" alt="">
						<p>Kid Furnitures</p>
					</div>
				</div>
				<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
					<div class="ps-block--category"><a href="shop-default.html"></a><img
							src="{{url('fronted/img/categories/furniture/4.png')}}" alt="">
						<p>TV Boards</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-1.jpg')}}" alt=""></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-2.jpg')}}" alt=""></a>
			</div>
		</div>
	</div>
</div>

<div class="ps-product-list">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> Global Festival | Shop From 3K Store</h3>
			<ul class="ps-section__links">

				<li><a href="shop-grid.html" style="color: white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
				data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2"
				data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5"
				data-owl-duration="1000" data-owl-mousedrag="on">
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
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
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-1.jpg')}}" alt=""></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-2.jpg')}}" alt=""></a>
			</div>
		</div>
	</div>
</div>

<div class="ps-product-list">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> Express | Fast Delivery on Women's Fashion</h3>
			<ul class="ps-section__links">
				<li><a href="shop-grid.html" style="color: white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
				data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2"
				data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5"
				data-owl-duration="1000" data-owl-mousedrag="on">
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ps-promotion ps-promotion--2 dsply-none">
	<div class="container"><a class="ps-collection" href="#"><img src="img/promotions/home-2-3.jpg')}}" alt=""></a>
	</div>
</div>

<div class="ps-best-sale-brands ps-section--furniture dsply-none">
	<div class="container">
		<div class="ps-section__header">
			<h3>TOP BRANDS</h3>
		</div>
		<div class="ps-section__content">
			<ul class="ps-image-list">
				<li><a href="#"><img src="{{url('fronted/img/brand/2-1.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-2.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-3.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-4.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-5.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-6.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-7.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-8.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-9.jpg')}}" alt=""></a></li>
				<li><a href="#"><img src="{{url('fronted/img/brand/2-10.jpg')}}" alt=""></a></li>
			</ul>
		</div>
	</div>
</div>

<div class="ps-product-list">
	<div class="container">
		<div class="ps-section__header bgClrBlue" style="background-color: #0000FF!important;">
			<h3 style="color: white;"> Express | Fast Delivery on Home & Office</h3>
			<ul class="ps-section__links">

				<li><a href="shop-grid.html" style="color: white;">View All</a></li>
			</ul>
		</div>
		<div class="ps-section__content ps-section__content-new">
			<div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000"
				data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2"
				data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5"
				data-owl-duration="1000" data-owl-mousedrag="on">
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/2.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-11%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Apple
								iPhone 7 Plus 128 GB – Red Color</a>

							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Apple iPhone 7 Plus 128 GB – Red Color</a>
							<p class="ps-product__price sale">$820.99 <del>$893.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/6.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-17%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Samsung
								Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Samsung Gallaxy A8 8GB Ram – Sliver Version</a>
							<p class="ps-product__price sale">$542.99 <del>$592.00</del></p>
						</div>
					</div>
				</div>
				<div class="ps-product mb-40">
					<div class="ps-product__thumbnail"><a href="product-details.php"><img
								src="{{url('fronted/img/products/technology/7.jpg')}}" alt="" /></a>
						<div class="ps-product__badge">-10%</div>
						<ul class="ps-product__actions">
							<li><a href="product-details.php" data-toggle="tooltip" data-placement="top"
									title="Read More"><i class="icon-bag2"></i></a></li>
							<li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i
										class="icon-eye"></i></a></li>
							<li><a href="wishlist.php" data-toggle="tooltip" data-placement="top"
									title="Add to Whishlist"><i class="icon-heart"></i></a></li>
						</ul>
					</div>
					<div class="ps-product__container">
						<div class="ps-product__content"><a class="ps-product__title" href="product-details.php">Yuntab
								K107 10.1 Inch Quad Core CPU MT6580</a>

							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
						</div>
						<div class="ps-product__content hover"><a class="ps-product__title"
								href="product-details.php">Yuntab K107 10.1 Inch Quad Core CPU MT6580</a>
							<p class="ps-product__price sale">$99.99 <del>$102.00</del></p>
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
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-1.jpg')}}" alt=""></a>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 "><a class="ps-collection mb-30" href="#"><img
						src="{{url('fronted/img/promotions/home-2-2.jpg')}}" alt=""></a>
			</div>
		</div>
	</div>
</div>

<div class="ps-home-promotions dsply-none">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
				<h3> Online Shopping - No. 1 Shopping Destination</h3>
				<p class="shoping-pera">What is Lorem Ipsum?
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
					industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
					and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
					leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
					with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
					publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br /><br />

					Why do we use it?
					It is a long established fact that a reader will be distracted by the readable content of a page
					when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
					distribution of letters, as opposed to using 'Content here, content here', making it look like
					readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their
					default model text, and a search for 'lorem ipsum' will uncover many web sites still in their
					infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose
					(injected humour and the like).

				</p>
			</div>
		</div>
	</div>
</div>

<script src="{{url('fronted/plugins/jquery-1.12.4.min.js')}}"></script>
<script>
	$(document).ready(function() {
		var _token = $('input[name="_token"]').val();
		load_data('', _token);
		$(".loader").show();

		function load_data(id = "", _token) {
			$.ajax({
				url: "{{ route('productcatWise.search') }}",
				method: "GET",
				dataType: 'json',
				data: {
					id: id,
					_token: _token
				},
				success: function(data) {
					$(".loader").hide();
					$('#load_more_button').remove();
					$('#showdata').append(data.data);
				}
			})
		}
		$(document).on('click', '#load_more_button', function() {
			var id = $(this).data('id');
			$('#load_more_button').html('<b>Loading...</b>');
			load_data(id, _token);
		});
	});
</script>
@endsection