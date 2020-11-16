@extends('vendor.master')
@section('title',$title)
@section('maincontent')
<style>
#shop-categories {
	background-color: #f5f5f5;
	padding-bottom: 10px;
}
</style>

<div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/store-details',$companySlug)}}">Home</a></li>
                <li>Shop categories</li>
            </ul>
        </div>
    </div>
    <div class="ps-page--shop" id="shop-categories">
        <div class="container-fluid">
           
            <div class="ps-block--categories-box">
                <div class="ps-block__header">
                    <h3>{{$title}}</h3>
                </div>
                <div class="ps-block__content" style="text-align: center;">
                
                <?php
                foreach ($product as $p) {
                    ?>
                    <div class="ps-block__item">

                    <a class="ps-block__overlay" href="{{url('/store-product-details/'.$p->slug.'/'.$companySlug)}}" target="_self"></a>
                    <img src="{{ url('admin/'.$p->photo1) }}" alt="{{$p->product_name}}">
                    <?php if (!empty($p->percentage)) { ?>
                    <p style="font-size: 18px; color: red; border-right: 5px solid red;"><b><?php echo "-" . $p->percentage . "%"; ?> OFF</b></p>
                    <?php } ?>
                        <p>{{$p->product_name}}</p>
                        
                        <?php
                                if ($p->percentage !== NULL && $p->special_price !== '0' && $p->regular_price !== '0') {
                                    ?>
                                    <p class="" style="font-size: 22px; color: red;">৳.{{$p->special_price}}
                                    <?php } elseif ($p->percentage == NULL && $p->special_price == '0' && $p->regular_price !== '0') { ?>
                <del style="font-size: 22px; font-weight: bold;">৳.{{$p->regular_price}}</del></p>
                <?php } ?>
                <?php if ($p->special_price == '0' && $p->regular_price !== '0') { ?>
                                    <?php
                                    if ($p->percentage !== NULL) {
                                        ?>
<p class="" style="font-size: 22px; font-weight: bold;"> <del>৳.{{$p->regular_price}}</del></p>
<?php } ?>
                                <?php } else { ?>
                                    <p class="" style="font-size: 22px; font-weight: bold;"><del>৳.{{$p->regular_price}}</del></p>
                                    <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
@endsection