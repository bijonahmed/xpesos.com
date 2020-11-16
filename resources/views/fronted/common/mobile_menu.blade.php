<header class="header header--mobile" data-sticky="true">
    <div class="header__top">
        <div class="header__left">
            <p>Welcome to Xpesos Online Shopping Store !</p>
        </div>
        <div class="header__right">
            <ul class="navigation__extra">
                <li><a href="sell-on-xpesos.php">Sell on Xpesos</a></li>
                <li><a href="#">Tract your order</a></li>
                <li style="display: none;">
                    <div class="ps-dropdown"><a href="#">US Dollar</a>
                        <ul class="ps-dropdown-menu">
                            <li><a href="#">Us Dollar</a></li>
                            <li><a href="#">Euro</a></li>
                        </ul>
                    </div>
                </li>
                
            </ul>
        </div>
    </div>

    <div class="ps-search--mobile navigation--mobile" style=" background-color: white;">
        <a class="ps-logo" href="{{url('/')}}"><img src="{{url('fronted/img/logo_light.png')}}" alt=""></a>
        <form class="ps-form--search-mobile" action="http://nouthemes.net/html/martfury/index.html" method="get">
            <div class="form-group--nest">
                <input class="form-control" type="text" placeholder="Search something..." style="border-top-left-radius: 25px; border-bottom-left-radius: 25px;">
                <button style="background-color: #f68b1e; border-top-right-radius: 25px; border-bottom-right-radius: 25px;"><i class="icon-magnifier"></i></button>
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
                $sum = 0;
                $contents = Cart::getContent();
                foreach ($contents as $item) {
                    $pcode = DB::table('tbl_product')->where('product_id', $item->id)->first();
                ?>
                    <div class="ps-product--cart-mobile">
                        <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('admin/'.$pcode->photo1) }}" alt="" style="height:50px; width: 100%;"></a></div>
                        <div class="ps-product__content"><a class="ps-product__remove" href="#"><i class="icon-cross"></i></a><a href="product-details.php">{{$item->name}}</a>
                            <p> YOUNG SHOP</p><small><?php echo $pcode->special_price * $item->quantity ?></small>
                        </div>
                    </div>
                <?php } ?>


            </div>
            <div class="ps-cart__footer">
                <h3>Sub Total:<strong>$59.99</strong></h3>
                <figure><a class="ps-btn" href="{{ url('/view-cart' )}}">View Cart</a><a class="ps-btn" href="{{ url('/checkout' )}}">Checkout</a></figure>
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
            <?php foreach ($category as $v) {  ?>
                <li class="menu-item-has-children has-mega-menu"><a href="{{url('/shop-list-category/'.$v->slug)}}">{{ $v->category_name }}</a><span class="sub-toggle"></span>

                    <?php
                    $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                    $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                    foreach ($subcat as $v) {
                    ?>

                        <div class="mega-menu">

                            <div class="mega-menu__column">
                                <h4>{{$v->sub_cat_name}}<span class="sub-toggle"></span></h4>
                                <ul class="mega-menu__list">

                                    <?php
                                    $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('sub_cat_id', $v->sub_cat_id)->where('status', 1)->orderBy('sub_cat_id', 'desc')->get();
                                    foreach ($insubcat as $s) {  ?>
                                        <li><a href="{{url('/shop-list-multiple-category/'.$v->slug.'/'.$s->slug)}}">{{$s->sub_in_sub_cat_name}}</a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>

                        </div>
                    <?php } ?>

                </li>
            <?php } ?>

        </ul>
    </div>
</div>
<div class="navigation--list">
    <div class="navigation__content">
        <!-- <a class="navigation__item ps-toggle--sidebar" href="#menu-mobile"><i class="icon-menu"></i><span> Menu</span></a> -->
        <a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile"><i class="icon-list4"></i><span> Categories</span></a>
        <a class="navigation__item ps-toggle--sidebar" href="#wishlist"><i class="icon-heart"></i><span> Wishlist</span></a>
        <a class="navigation__item ps-toggle--sidebar" href="#cart-mobile"><i class="icon-bag2"></i><span> Cart</span></a>
        <a class="navigation__item ps-toggle--sidebar" href="#login"><i class="icon-user"></i><span> Login</span></a>

    </div>
</div>
<div class="ps-panel--sidebar" id="login">
    <div class="ps-panel__header bg-white">
        <div class="ps-form__content">
            <h5>Log In Your Account</h5>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Username or email address">
            </div>
            <div class="form-group form-forgot">
                <input class="form-control" type="text" placeholder="Password"><a href="#">Forgot?</a>
            </div>
            <div class="form-group">
                <div class="ps-checkbox">
                    <input class="form-control" type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me">Rememeber me</label>
                </div>
            </div>
            <div class="form-group submtit">
                <button class="ps-btn ps-btn--fullwidth">Login</button>
            </div>
        </div>
    </div>
    <div class="navigation__content"></div>
</div>
<div class="ps-panel--sidebar" id="menu-mobile">
    <div class="ps-panel__header">
        <h3>Menu</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <?php foreach ($category as $v) {  ?>
                <li class="current-menu-item menu-item-has-children"><a href="{{url('/')}}">{{ $v->category_name }}</a><span class="sub-toggle"></span>
                    <ul class="sub-menu">
                        <?php
                        $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                        $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                        foreach ($subcat as $v) {
                        ?>
                            <li><a href="{{url('/shop-list-category/'.$v->slug)}}">{{$v->sub_cat_name}}</a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>


        </ul>
    </div>
</div>