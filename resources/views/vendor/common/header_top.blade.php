<?php 
$category = DB::table('tbl_category')->where('status', 1)->orderBy('tbl_category.sort', 'asc')->get();
?>
<style>
.menu > li > a {
	display: inline-block;
	padding: 20px 15px;
	font-size: 16px;
	font-weight: 400;
	line-height: 20px;
	color: #000;
}
.header .header__top {
    padding: 25px 0;
    background-color: #ded36c3b;
    border-bottom: 1px solid rgba(0, 0, 0, 0.15);
}
.navigation {
    background-color: #ded36c3b;
}
.navigation .navigation__right {
	display: -webkit-box;
	display: flex;
	-webkit-box-orient: horizontal;
	-webkit-box-direction: normal;
	flex-flow: row nowrap;
	-webkit-box-pack: justify;
	justify-content: space-between;
	-webkit-box-align: center;
	align-items: center;
	padding-left: 1px;
}
.navigation .navigation__left {
    max-width: 200px;
}
.ui-autocomplete {
    position: absolute;
    top: 0;
    left: 0;
    cursor: default;
    background-color: #fff;
    border: 1px solid #aaaaaa;
    max-height: 500px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
    /* add padding to account for vertical scrollbar */
    z-index: 1000 !important;
}
</style>
<?php 
$companySlug = Session::get('companySlug');
$userId = Session::get('user_id');
$productCat = DB::table('tbl_product')
              ->select(DB::raw('tbl_category.category_id,tbl_category.category_name,tbl_category.slug'))
              ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
              ->where('tbl_product.user_id', $userId)
              ->where('tbl_product.status', 1)
              ->orderBy('tbl_product.product_id', 'desc')
              ->groupBy('tbl_product.category_id')
              ->limit(5)
              ->get();
?>
<header class="header header--1" data-sticky="true">
        <div class="header__top">
            <div class="ps-container">
                <div class="header__left">
                    <div class="menu--product-categories">
                        <div class="menu__toggle"><i class="icon-menu"></i><span> Shop by Department</span></div>
                        <div class="menu__content">
                            <ul class="menu--dropdown">
                            <?php 
                            foreach ($productCat as $v) {  ?>
                                <li class="current-menu-item menu-item-has-children has-mega-menu">
                                <a href="{{url('/store-category/'.$v->slug .'/'. $companySlug)}}">{{ $v->category_name }}</a> 
                                    <?php
                                        $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                        $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                        foreach ($subcat as $v) {
                                            ?>
                                    <div class="mega-menu">
                                          <?php 
                                                foreach($searchsubcat as $scat)  {
                                                    ?>
                                        <div class="mega-menu__column">
                                            <h4><a href="{{url('/store-products/'.$scat->slug)}}" style="font-weight: bold;">{{$scat->sub_cat_name}}<span class="sub-toggle"></span></a></h4>
                                            <ul class="mega-menu__list">
                                            <?php 
                                            $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('sub_cat_id', $scat->sub_cat_id)->where('status', 1)->orderBy('sub_cat_id', 'desc')->get();
                                            foreach ($insubcat as $s) {  ?>
                                                <li class="current-menu-item "><a href="{{url('/products-list/'.$scat->slug.'/'.$s->slug.'/'.$companySlug)}}">{{$s->sub_in_sub_cat_name}}</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div><a class="ps-logo" href="{{url('/')}}"><img src="{{ url('admin/'.$data->photo) }}" alt="logo"></a>
                </div>
                <div class="header__center">
                    <form class="ps-form--quick-search" action="{{url('/search-product')}}" method="post">
                        {{ csrf_field() }}
                        <input class="form-control" type="text" placeholder="I'm shopping for..." id="product_name">
                        <button>Search</button>
                    </form>
                </div>
                <div class="header__right">
                    <div class="header__actions">
                        <div class="ps-cart--mini"><a class="header__extra" href="#"><i
                                    class="icon-bag2"></i><span><i><?php echo count(Cart::getContent()); ?></i></span></a>
                            <div class="ps-cart__content">
                            <div class="ps-cart__items">
                            <?php
                         $x = 1;
                            $sum =0;
                        $contents = Cart::getContent();
                        foreach ($contents as $item) {
                              $pcode = DB::table('tbl_product')->where('product_name', $item->name)->first();
                            ?>
<div class="ps-product--cart-mobile">
                                <div class="ps-product__thumbnail"><img src="{{ asset('admin/'.$pcode->photo1) }}"
                                alt="image" style="height:50px; width: 100%;"></div>
                                <div class="ps-product__content"><a class="ps-product__remove" href="#"><a href="#">{{$item->name}}</a>
                                    <p>Total Quantity : {{$item->quantity}} </small>
                                </div>
                            </div>
                                    <?php } ?>
                                </div>
                                <div class="ps-cart__footer">
                                <h3>Sub Total:<strong><?php echo "৳ " . number_format(Cart::getSubTotal()); ?></strong></h3>
                                <figure><a class="ps-btn btn-block" href="{{url('/show-cart')}}" style="text-align: center;">View Cart</a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="ps-block--user-header">
                            <div class="ps-block__left"><i class="icon-user"></i></div>
                            <div class="ps-block__right">
                            <?php if (!empty($customer_id = Session::get('customer_id'))) { ?>
                                <a href="{{url('/customer-panel')}}">My Dashboad</a>
                                <a href="{{url('/logoutCustomer')}}">Logout</a>
                                <?php } else { ?>
                            <a href="{{url('/customer-login-registration')}}">Customer Login/Register</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navigation">
            <div class="ps-container">
                <div class="navigation__left">
                    <div class="menu--product-categories">
                        <div class="menu__toggle"><i class="icon-menu"></i><span> Shop by Department</span></div>
                        <div class="menu__content">
                            <ul class="menu--dropdown">
                            <?php  foreach ($productCat as $v) {  ?>
                                <li class="current-menu-item menu-item-has-children has-mega-menu">
                                <a href="{{url('/store-category/'.$v->slug .'/'. $companySlug)}}">{{$v->category_name}}</a> 
                                    <?php
                                        $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                        $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                        foreach ($subcat as $v) {
                                            ?>
                                    <div class="mega-menu">
                                          <?php 
                                                foreach($searchsubcat as $scat)  {
                                                    ?>
                                        <div class="mega-menu__column">
                                            <h4><a href="{{url('/store-products/'.$scat->slug.'/'.$companySlug)}}" style="font-weight: bold;">{{$scat->sub_cat_name}}<span class="sub-toggle"></span></a></h4>
                                            <ul class="mega-menu__list">
                                            <?php 
                                            $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('sub_cat_id', $scat->sub_cat_id)->where('status', 1)->orderBy('sub_cat_id', 'desc')->get();
                                            foreach ($insubcat as $s) {  ?>
                                                <li class="current-menu-item "><a href="{{url('/store-products-list/'.$scat->slug.'/'.$s->slug.'/'.$companySlug)}}">{{$s->sub_in_sub_cat_name}}</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="navigation__right">
                    <ul class="menu">
                        <li><a href="{{url('/store-details',$companySlug)}}">Home</a></li>
                        <?php  foreach ($productCat as $v) {  ?>
                        <li><a href="{{url('/store-category/'.$v->slug .'/'. $companySlug)}}">{{$v->category_name}}</a>
                        </li>
                        <?php } ?>
                    </ul>
                      <ul class="navigation__extra">
                        <li><a href="{{url('/vendor-login-registration')}}">Sell on Fashionnista</a></li>
                        <li><a href="#">Tract your order</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
    function cartAccess() {
window.location.href = "{{url('/show-cart/')}}";
}
    //Autocmoplete Product Search Desktop. 
	$('#product_name').autocomplete({
		source: "{{ route('vendorAutocomplete.vendorAutocompleteProductfetch') }}",
		minLength: 1,
		select: function(event, ui) {
			$('#product_name').val(ui.item.value);
		}
	}).data('ui-autocomplete')._renderItem = function(ul, item) {
		return $("<li class='ui-autocomplete-row'></li>")
			.data("item.autocomplete", item)
			.append(item.label)
			.appendTo(ul);
	};
    </script>