@extends('fronted.master')
@section('title',$title)
@section('maincontent')
<style>
   .ps-store-list {
	padding-top: 10px;
}
</style>

<div class="ps-page--single ps-page--vendor">
    <section class="ps-store-list">
        <div class="container">
            <aside class="ps-block--store-banner">
                <div class="ps-block__content bg--cover" data-background="{{ url('fronted/img/storebackground.jpg') }}">
                    <h3><b>{{ $storerow->company }}</b></h3><a class="ps-block__inquiry" href="#"><i
                            class="fa fa-question"></i> Inquiry : {{ $storerow->mobile }} </a>
                </div>
                <div class="ps-block__user">
                    <div class="ps-block__user-content">
                        <p><i class="icon-map-marker"></i> {{ $storerow->address }}</p>
                        <p><i class="icon-envelope"></i> {{ $storerow->email }}</p>
                    </div>
                </div>
            </aside>
            <div class="ps-section__wrapper">
                <div class="ps-section__left">
                    <aside class="widget widget--vendor">
                        <h3 class="widget-title">Store Categories</h3>
                        <ul class="ps-list--arrow">
                            <?php
                           foreach($productCat as $i){
                        ?>
                            <li><a
                                    href="{{url('/store-category/'.$i->slug .'/'. $companySlug)}}">{{$i->category_name}}</a>
                            </li>
                            <?php } ?>

                        </ul>
                    </aside>

                </div>
                <div class="ps-section__right">
                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p><strong> <?php echo count($product);?></strong> Products found</p>
                            <div class="ps-shopping__actions">
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
                                                <div class="ps-product__thumbnail"><a
                                                        href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}">
                                                        <img src="{{ url('admin/'.$p->photo1) }}" alt="Product" style="height: 200px; width: 200px; border: 10px green transparent;" /></a>
                                                </div>
                                                <div class="ps-product__container"><a class="ps-product__vendor"
                                                        href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}" target="_blank"></a>
                                                    <div class="ps-product__content"><a class="ps-product__title"
                                                            href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}"
                                                            style="text-align:center;">{{$p->product_name}}</a>
                                                        <!-- <p class="ps-product__price sale">$990.99 <del>$1050.50 </del></p> -->
                                                        <p class="ps-product__price sale"><?php
                                    if ($p->percentage !== NULL && $p->special_price !== '0' && $p->regular_price !== '0') {
                                    ?>
                                                            <p style="font-size: 22px; color: red; text-align:center;">
                                                                ৳.{{$p->special_price}}</p>
                                                            <?php } elseif ($p->percentage == NULL && $p->special_price == '0' && $p->regular_price !== '0') { ?>
                                                            <del
                                                                style="font-size: 22px; text-align:center;">৳.{{$p->regular_price}}</del>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if ($p->special_price == '0' && $p->regular_price !== '0') { ?>
                                                        <?php
                                        if ($p->percentage !== NULL) {
                                        ?>
                                                        <p style="font-size: 22px; text-align:center;">
                                                            <del>৳.{{$p->regular_price}}</del></p>
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                        <p style="font-size: 22px; text-align:center;">
                                                            <del>৳.{{$p->regular_price}}</del></p>
                                                        <?php } ?></p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title"
                                                            href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}" target="_blank"
                                                            style="text-align:center;">{{$p->product_name}}</a>
                                                        <!-- <p class="ps-product__price sale">$990.99 <del>$1050.50 </del></p> -->
                                                        <p class="ps-product__price sale"><?php
                                    if ($p->percentage !== NULL && $p->special_price !== '0' && $p->regular_price !== '0') {
                                    ?>
                                                            <p style="font-size: 22px; color: red; text-align:center;">
                                                                ৳.{{$p->special_price}}</p>
                                                            <?php } elseif ($p->percentage == NULL && $p->special_price == '0' && $p->regular_price !== '0') { ?>
                                                            <del
                                                                style="font-size: 22px; text-align:center;">৳.{{$p->regular_price}}</del>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if ($p->special_price == '0' && $p->regular_price !== '0') { ?>
                                                        <?php
                                        if ($p->percentage !== NULL) {
                                        ?>
                                                        <p style="font-size: 22px; text-align:center;">
                                                            <del>৳.{{$p->regular_price}}</del></p>
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                        <p style="font-size: 22px; text-align:center;">
                                                            <del>৳.{{$p->regular_price}}</del></p>
                                                        <?php } ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>

                                    </div>
                                </div>
                                <div class="ps-pagination" style="display:none;">
                                    <ul class="pagination">
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ps-tab" id="tab-2">
                                <div class="ps-shopping-product">

                                    <?php 
   foreach ($product as $p) {
?>

                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}"><img
                                                    src="{{ url('admin/'.$p->photo1) }}" alt="Product" style="height: 200px; width: 200px;   border: 10px green transparent;" /></a>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title"
                                                    href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}"
                                                    style="margin-top:-20px;">{{$p->product_name}}</a>
                                                <div class="ps-product__rating">
                                                </div>
                                                <!-- <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p> -->
                                                <?php 
                                                    echo nl2br($p->pro_long_description);
                                                    ?>
                                            </div>
                                            <div class="ps-product__shopping">
                                                <?php
                                    if ($p->percentage !== NULL && $p->special_price !== '0' && $p->regular_price !== '0') {
                                    ?>
                                                <p style="font-size: 22px; color: red; text-align:center;">
                                                    ৳.{{$p->special_price}}</p>
                                                <?php } elseif ($p->percentage == NULL && $p->special_price == '0' && $p->regular_price !== '0') { ?>
                                                <del
                                                    style="font-size: 22px; text-align:center;">৳.{{$p->regular_price}}</del>
                                                </p>
                                                <?php } ?>
                                                <?php if ($p->special_price == '0' && $p->regular_price !== '0') { ?>
                                                <?php
                                        if ($p->percentage !== NULL) {
                                        ?>
                                                <p style="font-size: 22px; text-align:center;">
                                                    <del>৳.{{$p->regular_price}}</del></p>
                                                <?php } ?>
                                                <?php } else { ?>
                                                <p style="font-size: 22px; text-align:center;">
                                                    <del>৳.{{$p->regular_price}}</del></p>
                                                <?php } ?><a class="ps-btn" href="{{url('/product/'.$p->slug)}}">Add to
                                                    cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection