<?php
    $img = 'http://karughor.com/admin/'.$product->photo1;
    $productName = 'http://karughor.com/admin/'.$product->product_name; 
    $url= 'http://karughor.com/product/'.$product->slug;
    $pro_long_description= 'http://karughor.com/product/'.$product->pro_long_description;
    ?>

@extends('vendor.master')
@section('title',$title)
@section('maincontent')
@include('vendor.common.meta', [
'url' => $url,
'img' => $img,
'ogtitle' => $productName,
'des' => $pro_long_description
])
<style>
    .ps-footer {
        padding-top: 10px;
    }

    .ps-section--default {
        margin-bottom: 05px;
    }

    .ps-page--product {
        padding-top: 05px;
    }
</style>
<div class="ps-breadcrumb">
    <div class="ps-container">
        <ul class="breadcrumb">
            <li><a href="{{url('/store-details',$companySlug)}}">Home</a></li>
            <li>{{$product->product_name}}</li>
        </ul>
    </div>
</div>

<div class="ps-page--product ps-page--product-box">
    <div class="container-fluid">
        <div class="ps-product--detail ps-product--box">
            <div class="ps-product__header ps-product__box">
                <div class="ps-product__thumbnail" data-vertical="true">
                    <figure>
                        <div class="ps-wrapper">
                            <div class="ps-product__gallery" data-arrow="true">
                                <?php
                                        if (!empty($product->photo1)) {
                                            ?>
                                <div class="item"><a href="{{ url('admin/'.$product->photo1) }}"><img
                                            src="{{ url('admin/'.$product->photo1) }}"
                                            alt="{{$product->product_name}}"></a></div>
                                <?php } ?>

                                <?php
                                        if (!empty($product->photo2)) {
                                            ?>
                                <div class="item"><a href="{{ url('admin/'.$product->photo1) }}"><img
                                            src="{{ url('admin/'.$product->photo2) }}"
                                            alt="{{$product->product_name}}"></a></div>
                                <?php } ?>

                                <?php
                                        if (!empty($product->photo3)) {
                                            ?>
                                <div class="item"><a href="{{ url('admin/'.$product->photo3) }}"><img
                                            src="{{ url('admin/'.$product->photo1) }}"
                                            alt="{{$product->product_name}}"></a></div>
                                <?php } ?>

                                <?php
                                        if (!empty($product->photo4)) {
                                            ?>
                                <div class="item"><a href="{{ url('admin/'.$product->photo4) }}"><img
                                            src="{{ url('admin/'.$product->photo1) }}"
                                            alt="{{$product->product_name}}"></a></div>
                                <?php } ?>

                                <?php
                                        if (!empty($product->photo5)) {
                                            ?>
                                <div class="item"><a href="{{ url('admin/'.$product->photo5) }}"><img
                                            src="{{ url('admin/'.$product->photo1) }}"
                                            alt="{{$product->product_name}}"></a></div>
                                <?php } ?>

                            </div>
                        </div>
                    </figure>
                    <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">
                        <?php if (!empty($product->photo1)) {
                                            ?>
                        <div class="item"><img src="{{ url('admin/'.$product->photo1) }}"
                                alt="{{$product->product_name}}"></div>
                        <?php } ?>

                        <?php if (!empty($product->photo2)) {
                                            ?>
                        <div class="item"><img src="{{ url('admin/'.$product->photo2) }}"
                                alt="{{$product->product_name}}"></div>
                        <?php } ?>

                        <?php if (!empty($product->photo3)) {
                                            ?>
                        <div class="item"><img src="{{ url('admin/'.$product->photo3) }}"
                                alt="{{$product->product_name}}"></div>
                        <?php } ?>

                        <?php if (!empty($product->photo4)) {
                                            ?>
                        <div class="item"><img src="{{ url('admin/'.$product->photo4) }}"
                                alt="{{$product->product_name}}"></div>
                        <?php } ?>

                        <?php if (!empty($product->photo5)) {
                                            ?>
                        <div class="item"><img src="{{ url('admin/'.$product->photo5) }}"
                                alt="{{$product->product_name}}"></div>
                        <?php } ?>

                    </div>
                </div>
                <div class="ps-product__info">
                    <h1>{{$product->product_name}} Code: {{$product->product_code}}</h1>
                    <div class="ps-product__meta">
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous"
                            src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v6.0&appId=176443367098252&autoLogAppEvents=1">
                        </script>
                        <div class="fb-share-button" data-href="{{$url}}" data-layout="button_count" data-size="large">
                            <a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwellfoodsylhet.com%2Fproduct%2Fcelebration-cake&amp;src=sdkpreparse"
                                class="fb-xfbml-parse-ignore">Share</a></div>
                        <div class="like-btn iframe like-btn social_net_button">
                            <div class="fb-like custom-button btn btn-block"
                                data-href="https://www.facebook.com/KaruGhorMegaShop/?epa=SEARCH_BOX" data-send="false"
                                data-layout="button_count" data-show-faces="false" data-action="Like"></div>
                        </div>

                    </div>

                    <h4 class="ps-product__price">

                        <?php
                                    if ($product->percentage !== NULL && $product->special_price !== '0' && $product->regular_price !== '0') {
                                        ?>
                        <span class="price-new" itemprop="price" style="color: red; font-weight: bold;">
                            {{$product->special_price}} ৳ </span>
                        <?php } elseif ($product->percentage == NULL && $product->special_price == '0' && $product->regular_price !== '0') { ?>
                        <del>{{$product->regular_price}} ৳</del>
                        <?php } ?>
                        <?php if ($product->special_price == '0' && $product->regular_price !== '0') { ?>
                        <?php
                                        if ($product->percentage !== NULL) {
                                            ?>
                        <del>{{$product->regular_price}} ৳</del>
                        <?php } ?>

                        <?php } else { ?>
                        <del>{{$product->regular_price}} ৳</del>
                        <?php } ?>

                    </h4>

                    <div class="ps-product__desc">
                        <div class="inner-box-desc">

                            <div class="model"><span>Product Code:</span> {{$product->product_code}}</div>
                            <?php
    if (!empty($product->pro_brand_name)) {
        ?>
                            <div class="model"><span>Brand:</span> {{$product->pro_brand_name}}</div>
                            <?php } ?>

                            <span class="price-old" style="display: none;"><span>Regular Price:</span> </span>
                            <div class="reward" style="display: none;"><span>Special Price:</span>
                                {{$product->special_price}} Tk.</div>
                            <?php
    if ($product->pro_option == 1) {
        ?>
                            <div class="form-check-inline" onclick="topPart('S');">
                                <?php if (!empty($product->s_height)) {?>
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="small" name="optradio">S
                                    (Small)
                                </label>
                                <?php }?>

                                <div style="display:none;" id="smalls">
                                    <?php
                if (!empty($product->s_length)) {
                    echo "<b>Length: </b>" . $product->s_length . ', ';
                }
                if (!empty($product->s_height)) {
                    echo "<b>Height: </b>" . $product->s_height . ', ';
                }
                if (!empty($product->s_width)) {
                    echo "<b>Width: </b>" . $product->s_width . '';
                }
                ?>

                                </div>
                            </div>
                            <div class="form-check-inline">
                                <?php if (!empty($product->m_length)) {?>
                                <label class="form-check-label" onclick="topPart('M');">
                                    <input type="radio" class="form-check-input" id="medium" name="optradio">M
                                    (Medium)
                                </label>
                                <?php } ?>
                                <div style="display:none;" id="mediums">
                                    <?php
                if (!empty($product->m_length)) {
                    echo "<b>Length: </b>" . $product->m_length . ', ';
                }
                if (!empty($product->m_height)) {
                    echo "<b>Height: </b>" . $product->m_height . ', ';
                }
                if (!empty($product->m_width)) {
                    echo "<b>Width: </b>" . $product->m_width . '';
                }
                ?>
                                </div>
                            </div>
                            <div class="form-check-inline" onclick="topPart('L');">
                                <?php if (!empty($product->l_length)) {?>
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="large" name="optradio">L
                                    (Large)
                                </label>
                                <?php } ?>
                                <p style="display:none;" id="larges">
                                    <?php
                if (!empty($product->l_length)) {
                    echo "<b>Length: </b>" . $product->l_length . ', ';
                }
                if (!empty($product->l_height)) {
                    echo "<b>Height: </b>" . $product->l_height . ', ';
                }
                if (!empty($product->l_width)) {
                    echo "<b>Width: </b>" . $product->l_width . '';
                }
                ?>  </p>

                            </div>
                            <div class="form-check-inline" onclick="topPart('XL');">
                                <?php if (!empty($product->xl_length)) {?>
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="extralarge" name="optradio">XL
                                    (Extra Large)
                                </label>
                                <?php } ?>
                                <p style="display:none;" id="xls">
                                    <?php
                if (!empty($product->xl_length)) {
                    echo "<b>Length: </b>" . $product->xl_length . ', ';
                }
                if (!empty($product->xl_height)) {
                    echo "<b>Height: </b>" . $product->xl_height . ', ';
                }
                if (!empty($product->xl_width)) {
                    echo "<b>Width: </b>" . $product->xl_width . '';
                }
                ?>
                                </p>

                            </div>
                            <div class="form-check-inline" onclick="topPart('XXL');">
                                <?php if (!empty($product->xxl_length)) {?>
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="xxlarge" name="optradio">XXL
                                    (Extra Extra Large)
                                </label>
                                <?php } ?>
                                <p style="display:none;" id="xxls">

                                    <?php
                if (!empty($product->xxl_length)) {
                    echo "<b>Length: </b>" . $product->xxl_length . ', ';
                }
                if (!empty($product->xxl_height)) {
                    echo "<b>Height: </b>" . $product->xxl_height . ', ';
                }
                if (!empty($product->xxl_width)) {
                    echo "<b>Width: </b>" . $product->xxl_width . '';
                }
                ?></p>
                            </div>
                            <?php } elseif ($product->pro_option == 2) { ?>

                            <?php if (!empty($product->bottom_28)) {?>
                            <div class="form-check-inline" onclick="bottomPart('bottom_28');">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottomoptradio">28
                                </label>
                                <div style="display:none;" id="bottom_28">
                                    <b>{{$product->bottom_28}}</b>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if (!empty($product->bottom_30)) {?>
                            <div class="form-check-inline" onclick="bottomPart('bottom_30');">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottomoptradio">30
                                </label>
                                <div style="display:none;" id="bottom_30">
                                    <b> {{$product->bottom_30}}</b>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if (!empty($product->bottom_32)) {?>
                            <div class="form-check-inline" onclick="bottomPart('bottom_32');">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottomoptradio">32
                                </label>
                                <div style="display:none;" id="bottom_32">
                                    <b> {{$product->bottom_32}}</b>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if (!empty($product->bottom_34)) {?>
                            <div class="form-check-inline" onclick="bottomPart('bottom_34');">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottomoptradio">34
                                </label>
                                <div style="display:none;" id="bottom_34">
                                    <b> {{$product->bottom_34}}</b>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if (!empty($product->bottom_36)) {?>
                            <div class="form-check-inline" onclick="bottomPart('bottom_36');">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="bottomoptradio">36
                                </label>
                                <div style="display:none;" id="bottom_36">
                                    <b> {{$product->bottom_36}}</b>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <div class="model"><span>Delivery Charge:</span> {{$setting->dvcharge}}</div>
                            <div class="model"><span>Bkash Merchant No:</span> {{$setting->bkasnumber}}</div>

                            <div><span><b style="font-weight: bold;">Call For Order</b>:</span>
                                {{$setting->callfororder}}
                            </div>
                            <?php if ($product->pro_option == 1) {
        ?>
                            <button class="ps-btn btn btn-primary btn-block" onclick="topordermodal();"
                                style="background-color: #4169E1; color: white;"><b>Single Order</b></button>
                            <?php } else if ($product->pro_option == 2) { ?>
                            <button class="ps-btn btn btn-primary btn-block" onclick="bottomordermodal();"
                                style="background-color: #4169E1; color: white;"><b>Single Order</b></button>
                            <?php } else { ?>
                            <button class="ps-btn btn btn-primary btn-block"
                                style="background-color: #4169E1; color: white;" onclick="ordermodal();"><b>Single
                                    Order</b></button>
                            <?php } ?>
                        </div>
                    </div>
                    <form method="post" id="upload_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="ps-product__shopping">
                            <figure>
                                <figcaption>Quantity</figcaption>
                                <div class="form-group--number">
                                    <input class="form-control" type="text" placeholder="1" size="5" name="qty" id="qty"
                                        value="{{$product->qty}}">
                                    <input type="hidden" id="product_id" name="product_id"
                                        value="{{$product->product_id}}">
                                </div>
                            </figure>
                            <?php if ($product->pro_option == 1) {
                                        ?>
                            <a class="ps-btn ps-btn--black" onclick="topordermodalAddtoCart();">Add to cart</a>
                            <?php } else if ($product->pro_option == 2) { ?>
                            <a class="ps-btn ps-btn--black" onclick="bottomordermodaladdtoCart();">Add to cart</a>
                            <?php } else { ?>
                            <a class="ps-btn ps-btn--black" onclick="ordermodalAddtoCart();">Add to cart</a>
                            <?php } ?>

                        </div>
                    </form>
                </div>
            </div>

            <div class="ps-section--default" style="background-color: white;">
                <div class="ps-section__header">
                    <h3>Related products</h3>
                </div>
                <div class="ps-section__content">
                    <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true"
                        data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true"
                        data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3"
                        data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">

            <?php
                                $relatedProduct = DB::table('tbl_product')->where('category_id', $product->category_id)->get();
                                foreach ($relatedProduct as $item) {
                                    ?>

                        <div class="ps-product">
                            <div class="ps-product__thumbnail"><a href="{{url('/store-product-details/'.$item->slug.'/'.$companySlug)}}">
                                    <img src="{{ url('admin/'.$item->photo1) }}" alt="{{$item->product_name}}"></a>

                            </div>
                            <div class="ps-product__container"><a class="ps-product__vendor" href="#">Bijon's Store</a>
                                <div class="ps-product__content"><a class="ps-product__title"
                                        href="{{url('/store-product-details/'.$item->slug.'/'.$companySlug)}}">
                                        {{$item->product_name}}</a>
                                    <?php if ($item->percentage !== NULL && $item->special_price !== '0' && $item->regular_price !== '0') {
                                                                        ?>
                                    <span class="price-new" itemprop="price" style="color: red; font-weight: bold;">
                                        {{$item->special_price}} ৳ </span>
                                    <?php } elseif ($item->percentage == NULL && $item->special_price == '0' && $item->regular_price !== '0') { ?>
                                    <span class="price-new" itemprop="price" style="color: red; font-weight: bold;">
                                        <del>{{$item->regular_price}} ৳</del> </span>
                                    <?php } ?>
                                    <?php if ($item->special_price == '0' && $item->regular_price !== '0') { ?>
                                    <?php
                                                                        if ($item->percentage !== NULL) {
                                                                            ?>
                                    <span class="price-old"><del>{{$item->regular_price}} ৳</del></span>
                                    <?php } ?>

                                    <?php } else { ?>
                                    <span class="price-old"><del>{{$item->regular_price}} ৳</del></span>
                                    <?php } ?><br>

                                </div>
                                <div class="ps-product__content hover"><a class="ps-product__title"
                                        href="{{url('/store-product-details/'.$item->slug.'/'.$companySlug)}}">{{$item->product_name}}</a>

                                    <?php if ($item->percentage !== NULL && $item->special_price !== '0' && $item->regular_price !== '0') {
                                                                        ?>
                                    <span class="price-new" itemprop="price" style="color: red; font-weight: bold;">
                                        {{$item->special_price}} ৳ </span>
                                    <?php } elseif ($item->percentage == NULL && $item->special_price == '0' && $item->regular_price !== '0') { ?>
                                    <span class="price-new" itemprop="price" style="color: red; font-weight: bold;">
                                        <del>{{$item->regular_price}} ৳</del> </span>
                                    <?php } ?>
                                    <?php if ($item->special_price == '0' && $item->regular_price !== '0') { ?>
                                    <?php
                                                                        if ($item->percentage !== NULL) {
                                                                            ?>
                                    <span class="price-old"><del>{{$item->regular_price}} ৳</del></span>
                                    <?php } ?>

                                    <?php } else { ?>
                                    <span class="price-old"><del>{{$item->regular_price}} ৳</del></span>
                                    <?php } ?><br>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <br>
</div>

</div>

<div class="modal" tabindex="-1" role="dialog" id="message">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p style="font-size: 22px; font-weight: bold;text-align: center; color: green;">
                    {{$setting->recived_order}}</p>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade-scale animate" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #4169E1;color: white;">

                    <p class="modal-title" id="myModalLabel" style="color: white;">
                        {{$product->product_name}}</p>
                </div>
                <div class="modal-body">
                    <p>Please Enter Your Mobile Number</p>
                    <input type="hidden" name="product_id" value="{{$product->product_id}}" id="product_id" />
                    <input type="hidden" name="toppart" id="toppart" />
                    <input type="hidden" name="bottompart" id="bottompart" />
                    <input type="hidden" name="regular_price" id="regular_price" value="{{$product->regular_price}}" />
                    <input type="text" name="mobile_number" id="mobile_number" placeholder="01xxxxxxxxx" maxlength="11"
                        class="form-control" required onkeyup="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '');
                                                enableordernow();" />
                    <span>Enter your name & shipping address. </span>
                    <textarea class="form-control" name="shipping_details" id="shipping_details" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="order" class="btn btn-primary btn-submit btn-block"
                        style="font-size: 18px;"><i class="fa fa-check-square-o"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal" tabindex="-1" role="dialog" id="error">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p style="font-size: 22px; font-weight: bold;color: red; text-align: center;">Please select
                    any size.
                </p>
            </div>
        </div>
    </div>
</div>
<script src="{{url(url('admin/urls/js/jquery.min.js'))}}"></script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v6.0'
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function writeAReivew() {
        // e.preventDefault();
        var _token = $("input[name='_token']").val();
        var product_id = $("input[name=product_id]").val();
        var name = $("input[name=name]").val();
        var review_description = $("#review_description").val();
        if (name == "" || review_description == "") {
            alert("Please Enter Your name and Review Description");
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "{{ url('/write-to-review') }}",
            dataType: "json",
            data: {
                _token: _token,
                product_id: product_id,
                name: name,
                review_description: review_description
            },
            success: function(data) {
                location.reload();
            }
        });
    }

    function topPart(size) {
        if (size == 'S') {
            // alert(size);
            $('#smalls').show();
            $('#mediums').hide();
            $('#larges').hide();
            $('#xls').hide();
            $('#xxls').hide();
            $('#toppart').val(size);
        } else if (size == 'M') {
            $('#mediums').show();
            $('#smalls').hide();
            $('#larges').hide();
            $('#xxls').hide();
            $('#xls').hide();
            $('#toppart').val(size);
        } else if (size == 'L') {
            $('#larges').show();
            $('#mediums').hide();
            $('#smalls').hide();
            $('#xls').hide();
            $('#xxls').hide();
            $('#toppart').val(size);
        } else if (size == 'XL') {
            $('#xls').show();
            $('#larges').hide();
            $('#mediums').hide();
            $('#smalls').hide();
            $('#xxls').hide();
            $('#toppart').val(size);
        } else if (size == 'XXL') {
            $('#xxls').show();
            $('#xls').hide();
            $('#larges').hide();
            $('#mediums').hide();
            $('#smalls').hide();
            $('#topparts').val(size);
        }
    }

    function bottomPart(size) {
        if (size == "bottom_28") {
            $('#bottom_28').show();
            $('#bottom_30').hide();
            $('#bottom_36').hide();
            $('#bottom_32').hide();
            $('#bottompart').val(28);
        } else if (size == "bottom_30") {
            $('#bottom_30').show();
            $('#bottom_28').hide();
            $('#bottom_36').hide();
            $('#bottom_32').hide();
            $('#bottompart').val(30);
        } else if (size == "bottom_32") {
            $('#bottom_32').show();
            $('#bottom_28').hide();
            $('#bottom_36').hide();
            $('#bottom_30').hide();
            $('#bottom_34').hide();
            $('#bottompart').val(32);
        } else if (size == "bottom_34") {
            $('#bottom_34').show();
            $('#bottom_28').hide();
            $('#bottom_36').hide();
            $('#bottom_32').hide();
            $('#bottom_30').hide();
            $('#bottompart').val(34);
        } else if (size == "bottom_36") {
            $('#bottom_36').show();
            $('#bottom_28').hide();
            $('#bottom_32').hide();
            $('#bottom_30').hide();
            $('#bottom_34').hide();
            $('#bottompart').val(36);
        }
    }
    // ajax post
    function topordermodalAddtoCart() {
        var radiochk = $("input[name='optradio']:checked").val();
        if (typeof radiochk === "undefined") {
            $('#error').modal('show');
        } else {
            var _token = $("input[name='_token']").val();
            var product_id = $("input[name=product_id]").val();
            var qty = $("input[name=qty]").val();
            var toppart = $("input[name=toppart]").val();
            // console.log(toppart);
            // var bottompart = $("input[name=bottompart]").val();
            $.ajax({
                type: 'POST',
                url: "{{ url('/add-to-cart') }}",
                dataType: "json",
                data: {
                    _token: _token,
                    product_id: product_id,
                    qty: qty,
                    toppart: toppart
                },
                success: function(data) {
                    location.replace("{{ url('/store-show-cart') }}");
                }
            });
        }
    }

    function bottomordermodaladdtoCart() {
        var radiochk = $("input[name='bottomoptradio']:checked").val();
        if (typeof radiochk === "undefined") {
            $('#error').modal('show');
        } else {
            var _token = $("input[name='_token']").val();
            var product_id = $("input[name=product_id]").val();
            var qty = $("input[name=qty]").val();
            // var toppart = $("input[name=toppart]").val();
            var bottompart = $("input[name=bottompart]").val();
            $.ajax({
                type: 'POST',
                url: "{{ url('/add-to-cart') }}",
                dataType: "json",
                data: {
                    _token: _token,
                    product_id: product_id,
                    qty: qty,
                    //    toppart: toppart,
                    bottompart: bottompart
                },
                success: function(data) {
                    location.replace("{{ url('/store-show-cart') }}");
                }
            });
        }
    }
    //no condition
    function ordermodalAddtoCart() {
        var _token = $("input[name='_token']").val();
        var product_id = $("input[name=product_id]").val();
        var qty = $("input[name=qty]").val();
        $.ajax({
            type: 'POST',
            url: "{{ url('/add-to-cart') }}",
            dataType: "json",
            data: {
                _token: _token,
                product_id: product_id,
                qty: qty
            },
            success: function(data) {
                location.replace("{{ url('/store-show-cart') }}")
            }
        });
    }

    function topordermodal() {
        radiochk = $("input[name='optradio']:checked").val();
        if (typeof radiochk === "undefined") {
            $('#error').modal('show');
        } else {
            $('#myModal').modal('show');
        }
    }

    function bottomordermodal() {
        radiochk = $("input[name='bottomoptradio']:checked").val();
        if (typeof radiochk === "undefined") {
            $('#error').modal('show');
        } else {
            $('#myModal').modal('show');
        }
    }

    function ordermodal() {
        $('#myModal').modal('show');
    }

    function enableordernow() {
        $('#order').prop('disabled', false);
    }
    $(document).ready(function() {
        $('#order').prop('disabled', true);
        var zoomCollection = '.large-image img';
        $(zoomCollection).elevateZoom({
            zoomType: "inner",
            lensSize: "200",
            easing: true,
            gallery: 'thumb-slider',
            cursor: 'pointer',
            loadingIcon: 'fronted/image/theme/lazy-loader.gif',
            galleryActiveClass: "active"
        });
    });
    $(".btn-submit").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var product_id = $("input[name=product_id]").val();
        var mobile_number = $("input[name=mobile_number]").val();
        var toppart = $("input[name=toppart]").val();
        var bottompart = $("input[name=bottompart]").val();
        var product_qty = $("#product_qty").val();
        var regular_price = $("#regular_price").val();
        var shipping_details = $("#shipping_details").val();
        if (mobile_number == "" || shipping_details == "") {
            alert("Please Enter Your Mobile Number / Shipping Address");
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "{{ url('/save-orders-ajax') }}",
            dataType: "json",
            data: {
                _token: _token,
                product_id: product_id,
                toppart: toppart,
                bottompart: bottompart,
                product_qty: product_qty,
                regular_price: regular_price,
                shipping_details: shipping_details,
                mobile_number: mobile_number
            },
            success: function(data) {
                //window.location.replace("{{ url('/success') }}");
                $('#myModal').modal('hide');
                $('#message').modal('show');
                $('#mobile_number').val("");
                setTimeout(function() {
                    $('#message').modal('hide')
                }, 4000);
            }
        });
    });
</script>
@endsection