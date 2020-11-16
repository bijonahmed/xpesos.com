<?php $category = DB::table('tbl_category')->where('status', 1)->orderBy('tbl_category.sort', 'asc')->get();
$data = DB::table('tbl_setting')->where('status', 1)->first();
?><?php 
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

<header class="header header--mobile" data-sticky="true">
    <div class="header__top">
        <div class="header__left">
            <p>Welcome to {{ $data->name }}</p>
        </div>
    </div>
    <div class="navigation--mobile">
        <div class="navigation__left"><a class="ps-logo" href="{{url('/')}}"><img
                    src="{{ asset('admin/'.$data->photo) }}" alt="image" style="height:50px; width: 100%;"></a>
        </div>
        <div class="navigation__right">
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
                                <div class="ps-product__content"><a class="ps-product__remove" href="#"><i
                                            class="icon-cross"></i></a><a
                                        href="product-default.html">{{$item->name}}</a>
                                    <p>Total Quantity : {{$item->quantity}} </small>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="ps-cart__footer">
                            <h3>Sub Total:<strong><?php echo "৳ " . number_format(Cart::getSubTotal()); ?></strong></h3>
                            <figure><a class="ps-btn btn-block" href="{{url('/show-cart')}}"
                                    style="text-align: center;">View Cart</a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="ps-block--user-header">
                    <div class="ps-block__left"><i class="icon-user"></i></div>
                    <div class="ps-block__right"><a href="#">Login</a><a href="#">Register</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-search--mobile">
        <form class="ps-form--search-mobile" method="get">
            <div class="form-group--nest">
                <input class="form-control" type="text" placeholder="Search something...mobile" id="productname">
                <button><i class="icon-magnifier"></i></button>
            </div>
        </form>
    </div>
</header>
<div class="ps-panel--sidebar" id="cart-mobile">
    <div class="ps-panel__header">
        <h3>Shopping Cart</h3>
    </div>
    <div class="navigation__content">
        <div class="ps-cart--mobile">
            <div class="ps-cart__content">

                <?php
                         $x = 1;
                            $sum =0;
                        $contents = Cart::getContent();
                        foreach ($contents as $item) {
                              $pcode = DB::table('tbl_product')->where('product_name', $item->name)->first();
                            ?>
                <div class="ps-product--cart-mobile">
                    <div class="ps-product__thumbnail"><img src="{{ asset('admin/'.$pcode->photo1) }}" alt="image"
                            style="height:50px; width: 100%;"></div>
                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><a
                                href="product-default.html">{{$item->name}}</a>
                            <p>Total Quantity : {{$item->quantity}} </small>
                    </div>
                </div>
                <?php } ?>

            </div>
            <div class="ps-cart__footer">
                <h3>Sub Total:<strong><?php echo "৳ " . number_format(Cart::getSubTotal()); ?></strong></h3>
                <figure><a class="ps-btn btn-block" href="{{url('/show-cart')}}" style="text-align: center;">View
                        Cart</a>
                </figure>
            </div>
        </div>
    </div>
</div>
<div class="ps-panel--sidebar" id="navigation-mobile">
    <div class="ps-panel__header">
        <h3>Categories</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <li class="current-menu-item "><a href="{{url('/')}}">Home</a>
            </li>
            <?php  foreach ($productCat as $v) {  ?>
            <li class="current-menu-item menu-item-has-children has-mega-menu"><a
                    href="{{url('/store-category/'.$v->slug .'/'. $companySlug)}}">{{ $v->category_name }}</a><span class="sub-toggle"></span>
                <div class="mega-menu">
                    <?php
                $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                foreach ($subcat as $v) {
                                            ?>
                    <div class="mega-menu__column">
                        <h4>{{$v->sub_cat_name}}<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                            <?php $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('sub_cat_id', $v->sub_cat_id)->where('status', 1)->orderBy('sub_cat_id', 'desc')->get();
                         foreach ($insubcat as $s) {  ?>
                            <li class="current-menu-item "><a
                                    href="{{url('/store-products-list/'.$v->slug.'/'.$s->slug.'/'.$companySlug)}}">{{$s->sub_in_sub_cat_name}}</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                    <!-- <div class="mega-menu__column">
                <h4>Electronic<span class="sub-toggle"></span></h4>
                <ul class="mega-menu__list">
                    <li class="current-menu-item "><a href="#">Home Audio &amp; Theathers</a></li>
                </ul>
            </div> -->
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="navigation--list">
    <div class="navigation__content">
        <a class="navigation__item ps-toggle--sidebar" href="#menu-mobile"><i class="icon-menu"></i><span>
                Menu</span></a>
        <a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile"><i class="icon-list4"></i><span>
                Categories</span></a>
        <a class="navigation__item ps-toggle--sidebar" href="#cart-mobile"><i class="icon-bag2"></i><span>
                Cart</span></a></div>
</div>
<div class="ps-panel--sidebar" id="menu-mobile">
    <div class="ps-panel__header">
        <h3>Menu</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <li class="menu-item-has-children"><a href="{{url('/')}}">Home</a>
            <li class="current-menu-item "><a href="#">About us</a></li>
            <li class="current-menu-item "><a href="#">Policy</a></li>
            <li class="current-menu-item "><a href="#">Term & Condition</a></li>
            <li class="current-menu-item "><a href="#">Return</a></li>
            <li class="current-menu-item "><a href="#">Contact Us</a></li>
            </li>
        </ul>
    </div>
</div>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
    function cartAccess() {
        window.location.href = "{{url('/show-cart/')}}";
    }
    //Autocmoplete Product Search Desktop. 
    $('#productname').autocomplete({
        source: "{{ route('autocomplete.AutocompleteProductfetch') }}",
        minLength: 1,
        select: function(event, ui) {
            $('#productname').val(ui.item.value);
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };
</script>