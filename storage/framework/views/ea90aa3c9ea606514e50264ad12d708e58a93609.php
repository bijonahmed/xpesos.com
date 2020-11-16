<?php $setting = DB::table('tbl_setting')->first(); ?>
<style>
    .header--standard .ps-form--quick-search input {
        border: 1px solid #e1e1e1;
    }

    .ui-autocomplete {
        max-height: 500px;
        max-width: 75%;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }

    * html .ui-autocomplete {
        height: 500px;
    }

    .fixed-height {
        padding: 1px;
        max-height: 200px;
        overflow: auto;
    }
</style>

<div style="background: white;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="#">
                    <img src="<?php echo e(url('fronted/img/ads/top-strip-buy.gif')); ?>" class="img-responsive" style="width: 100%;" />
                </a>
            </div>
        </div>
    </div>
</div>

<header class="header header--standard header--market-place-1" data-sticky="true" style="background: white;">
    <div class="header__content">
        <div class="container">
            <div class="header__content-left">
                <div class="menu--product-categories">
                    <div class="menu__toggle"><i class="icon-menu"></i><span> Shop by Department</span></div>
                    <div class="menu__content">
                        <ul class="menu--dropdown">
                            <?php
                            $category = DB::table('tbl_category')->where('status', 1)->orderBy('tbl_category.sort', 'asc')->get();
                            $categoryhome = DB::table('tbl_category')->where('status', 1)->orderBy('tbl_category.sort', 'asc')->limit(5)->get();
                            foreach ($category as $v) {  ?>
                                <li class="current-menu-item menu-item-has-children has-mega-menu">
                                    <a href="<?php echo e(url('/shop-list-category/'.$v->slug)); ?>"><?php echo e($v->category_name); ?></a>
                                    <?php
                                    $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                    $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                    foreach ($subcat as $v) {
                                    ?>

                                        <div class="mega-menu">
                                            <div class="row">
                                                <?php
                                                foreach ($searchsubcat as $scat) {
                                                ?>
                                                    <div class="mega-menu__column col-sm-6">
                                                        <h4><a href="<?php echo e(url('/shop-list-category/'.$scat->slug)); ?>" style="font-weight: bold;"><?php echo e($scat->sub_cat_name); ?><span class="sub-toggle"></span></a></h4>
                                                        <ul class="mega-menu__list">
                                                            <?php
                                                            $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('sub_cat_id', $scat->sub_cat_id)->where('status', 1)->limit(4)->orderBy('sub_cat_id', 'desc')->get();
                                                            foreach ($insubcat as $s) {  ?>
                                                                <li class="current-menu-item "><a href="<?php echo e(url('/shop-list-multiple-category/'.$scat->slug.'/'.$s->slug)); ?>"><?php echo e($s->sub_in_sub_cat_name); ?></a></li>
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
                </div><a class="ps-logo" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(url('admin/'.$setting->photo)); ?>" alt=""> </a>
            </div>
            <div class="header__content-center">
                <form class="ps-form--quick-search" action="<?php echo e(url('/search-product')); ?>" method="get">
                    <?php echo csrf_field(); ?>
                    <input class="form-control" type="text" id="product_name" placeholder="I'm shopping for..." style="border-top-left-radius: 25px; border-bottom-left-radius: 25px;">
                    <button style="border-top-right-radius: 25px; border-bottom-right-radius: 25px;">Search</button>
                </form>
            </div>
            <div class="header__content-right">
                <div class="header__actions"><a class="header__extra" href="#"><i class="icon-heart"></i><span><i>0</i></span></a>
                    <div class="ps-cart--mini"><a class="header__extra" href="#"><i class="icon-bag2"></i><span><i>0</i></span></a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items">
                                <?php
                                $x = 1;
                                $sum = 0;
                                $contents = Cart::getContent();
                                foreach ($contents as $item) {
                                    $pcode = DB::table('tbl_product')->where('product_id', $item->id)->first();
                                ?>

                                    <div class="ps-product--cart-mobile">
                                        <div class="ps-product__thumbnail"><a href="#"><img src="<?php echo e($pcode->photo1); ?>" alt="" style="height:50px; width: 100%;"></a></div>
                                        <div class="ps-product__content"></a><a href="<?php echo e(url('/product-details/'.$pcode->slug)); ?>">
                                                <?php echo e($item->name); ?></a>
                                            <p><small> <?php echo e($item->quantity); ?> x <?php echo e($setting->currency); ?> <?php echo e($pcode->special_price); ?> = <?php
                                                                                                                                    $item->quantity;
                                                                                                                                    $pcode->special_price;
                                                                                                                                    echo $setting->currency . ' ' . $item->quantity * $pcode->special_price;; ?> </small>
                                        </div>
                                    </div>

                                <?php } ?>


                            </div>
                            <div class="ps-cart__footer">
                                <h3>Sub Total:<strong><?php echo $setting->currency . ' ' . number_format(Cart::getSubTotal()); ?></strong></h3>
                                <figure><a class="ps-btn" href="<?php echo e(url('/view-cart' )); ?>">View Cart</a><a class="ps-btn" href="<?php echo e(url('/checkout' )); ?>">Checkout</a></figure>
                            </div>
                        </div>
                    </div>
                    <div class="ps-block--user-header">
                        <div class="ps-block__left"><i class="icon-user"></i></div>
                        <div class="ps-block__right">
                            <?php if (!empty($customer_id = Session::get('customer_id'))) { ?>
                                <a href="<?php echo e(url('/logoutCustomer')); ?>">Logout</a>
                            <?php } else { ?>
                                <a href="<?php echo e(url('/customer-login-registration')); ?>">Login</a>
                                <a href="<?php echo e(url('/customer-login-registration')); ?>">Register</a>
                            <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="container">
            <div class="navigation__left">
                <div class="menu--product-categories">
                    <div class="menu__toggle"><i class="icon-menu"></i><span> Shop by Department</span></div>
                    <div class="menu__content">
                        <ul class="menu--dropdown">
                            <?php foreach ($category as $v) {  ?>
                                <li class="current-menu-item menu-item-has-children has-mega-menu">
                                    <a href="<?php echo e(url('/shop-list-category/'.$v->slug)); ?>"><?php echo e($v->category_name); ?></a>
                                    <?php
                                    $subcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                    $searchsubcat = DB::table('tbl_subcategory')->where('category_id', $v->category_id)->where('status', 1)->orderBy('category_id', 'desc')->get();
                                    foreach ($subcat as $v) {
                                    ?>
                                        <div class="mega-menu">

                                            <?php
                                            foreach ($searchsubcat as $scat) {
                                            ?>
                                                <div class="row">
                                                    <div class="mega-menu__column col-sm-6">
                                                        <h4><a href="<?php echo e(url('/shop-list-category/'.$scat->slug)); ?>" style="font-weight: bold;"><?php echo e($scat->sub_cat_name); ?><span class="sub-toggle"></span></a></h4>
                                                        <ul class="mega-menu__list">
                                                            <?php
                                                            $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('sub_cat_id', $scat->sub_cat_id)->where('status', 1)->orderBy('sub_cat_id', 'desc')->get();
                                                            foreach ($insubcat as $s) {  ?>
                                                                <li class="current-menu-item "><a href="<?php echo e(url('/shop-list-multiple-category/'.$scat->slug.'/'.$s->slug)); ?>"><?php echo e($s->sub_in_sub_cat_name); ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
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
                </ul>
                <div class="ps-block--header-hotline inline">
                    <p><a href="<?php echo e(url('/sell-on-xpesos')); ?>" class="sell-spesos-link" style="color: black; font-size:15px;">Sell on Xpesos &nbsp;</a></p>|
                    <p><a href="<?php echo e(url('/track-your-order')); ?>" class="sell-spesos-link" style="color: black; font-size:15px;">&nbsp; Track Your Order &nbsp;</a></p>
                </div>
            </div>
        </div>
    </nav>
</header><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/common/header.blade.php ENDPATH**/ ?>