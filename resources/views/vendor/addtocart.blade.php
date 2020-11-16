@extends('vendor.master')
@section('title','Add to cart')
@section('maincontent')
<style>
    .ps-section--shopping {
        padding: 20px 0;
    }
</style>
<?php 

$companySlug =  Session::get('companySlug'); 
?>
<div class="main-container container" style="background-color: white;">
    <br>
    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/store-details',$companySlug)}}">Home</a></li>
                    <li>Shopping Cart</li>
                </ul>
            </div>
        </div>
        <div class="ps-section--shopping ps-shopping-cart">
            <div class="container">
                <div class="ps-section__content">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                         $x = 1;
                        $sum =0;
                        $contents = Cart::getContent();
                        foreach ($contents as $item) {
                            $pcode = DB::table('tbl_product')->where('product_id', $item->id)->first();
                            ?>
                                <tr>
                                    <td>
                                        <div class="ps-product--cart">
                                            <div class="ps-product__thumbnail"><a href="#"><img
                                                        src="{{ asset('admin/'.$pcode->photo1) }}" alt="image"
                                                        style="height:100px; width: 100%;"></a></div>
                                            <div class="ps-product__content"><a href="#">{{$item->name}}<br><?php
                                            if (!empty($item->attributes->has('size'))) {
                                                $size = json_encode($item->attributes->size);
                                                if (!empty($size)) {
                                                    echo $output = str_replace('"', "", "$size");
                                                }
                                            }
                                            ?></a>
                                                <!-- <p>Sold By:<strong> YOUNG SHOP</strong></p> -->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price"> <strong><?php
                                    if ($pcode->percentage !== NULL && $pcode->special_price !== '0' && $pcode->regular_price !== '0') {
                                        ?>
                                            <span class="price-new" itemprop="price"
                                                style="color: red; font-weight: bold;"> {{$pcode->special_price}} ৳
                                            </span>
                                            <?php } elseif ($pcode->percentage == NULL && $pcode->special_price == '0' && $pcode->regular_price !== '0') { ?>
                                            <span class="price-new" itemprop="price"
                                                style="color: red; font-weight: bold;"> {{$pcode->regular_price}} ৳
                                            </span>
                                            <?php } ?>
                                            <?php if ($pcode->special_price == '0' && $pcode->regular_price !== '0') { ?>
                                            <?php
                                        if ($pcode->percentage !== NULL) {
                                            ?>
                                            <del>{{$pcode->regular_price}} ৳</del>
                                            <?php } ?>
                                            <?php } else { ?>
                                            <del>{{$pcode->regular_price}} ৳</del>
                                            <?php } ?>
                                        </strong></td>
                                    <form action="{{url('/vendor-update-product')}}" method="post" class="form-inline">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$item->id}}" size="1"
                                            class="form-control" />
                                        <td>
                                            <div class="form-group--number" style="text-align: center;">
                                                <input class="form-control" type="text" size="1" placeholder="1"
                                                    id="quantity" name="quantity" value="{{$item->quantity}}" onkeyup="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                            </div>
                                            <button type="submit">Edit</button>
                                        </td>
                                    </form>
                                    <td><?php
                                    if ($pcode->percentage !== NULL && $pcode->special_price !== '0' && $pcode->regular_price !== '0') {
                                        ?>
                                        {{'৳ ' . $pcode->special_price * $item->quantity}}
                                        <?php 
                                        $sum+= $pcode->special_price * $item->quantity;
                                        ?>
                                        <?php } elseif ($pcode->percentage == NULL && $pcode->special_price == '0' && $pcode->regular_price !== '0') { ?>
                                        {{'৳ ' . $pcode->regular_price * $item->quantity}}
                                        <?php 
                                                    $sum += $pcode->regular_price * $item->quantity;
                                        ?>
                                        <?php } ?>
                                        <?php if ($pcode->special_price == '0' && $pcode->regular_price !== '0') { ?>
                                        <?php
                                        if ($pcode->percentage !== NULL) {
                                            ?>
                                        {{'৳ ' . $pcode->regular_price * $item->quantity}}
                                        <?php 
                                                    $sum += $pcode->regular_price * $item->quantity;
                                        ?>
                                        <?php } ?>
                                        <?php }?></td>
                                    <td><a href="{{url('/item-delete-product/'.$item->id)}}"
                                            onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                class="icon-cross"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="ps-section__cart-actions" style="display:none;"><a class="ps-btn" href="{{url('/')}}"><i
                                class="icon-arrow-left"></i> Back to Shop</a><a class="ps-btn ps-btn--outline"
                            href="shop-default.html"><i class="icon-sync"></i> Update cart</a></div>
                </div>
                <div class="ps-section__footer">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <figure style="display:none;">
                                <figcaption>Coupon Discount</figcaption>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="">
                                </div>
                                <div class="form-group">
                                    <button class="ps-btn ps-btn--outline">Apply</button>
                                </div>
                            </figure>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <figure style="display:none;">
                                <figcaption>Calculate shipping</figcaption>
                                <div class="form-group">
                                    <select class="ps-select">
                                        <option value="1">America</option>
                                        <option value="2">Italia</option>
                                        <option value="3">Vietnam</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input class="form-control" type="text" placeholder="Town/City">
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input class="form-control" type="text" placeholder="Postcode/Zip">
                                </div>
                                <div class="form-group" style="display:none;">
                                    <button class="ps-btn ps-btn--outline">Update</button>
                                </div>
                            </figure>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block--shopping-total">
                                <div class="ps-block__header">
                                    <p>Subtotal <span> <?php echo "৳ " . number_format($sum); ?></span></p>
                                </div>
                                <div class="ps-block__content">
                                    <ul class="ps-block__product" style="display:none;">
                                        <li><span class="ps-block__shop">YOUNG SHOP Shipping</span><span
                                                class="ps-block__shipping">Free Shipping</span><span
                                                class="ps-block__estimate">Estimate for <strong>Viet Nam</strong><a
                                                    href="#"> MVMTH Classical Leather Watch In Black ×1</a></span></li>
                                        <li><span class="ps-block__shop">ROBERT’S STORE Shipping</span><span
                                                class="ps-block__shipping">Free Shipping</span><span
                                                class="ps-block__estimate">Estimate for <strong>Viet Nam</strong><a
                                                    href="#">Apple Macbook Retina Display 12” ×1</a></span></li>
                                    </ul>
                                    <h3>Total <span><?php echo "৳ " . number_format($sum); ?></span></h3>
                                </div>
                            </div><a class="ps-btn ps-btn--fullwidth" onclick="CheckOutMUltiple();">Proceed to
                                checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade-scale animate" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form enctype="multipart/form-data" method="post" action="{{ url('/save-orders-details') }}">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #4169E1;color: white;">

                        <p class="modal-title" id="myModalLabel" style="color: white;">
                            Please Enter Your Mobile Number</p>
                    </div>
                    <div class="modal-body">

                        <!-- <input type="hidden" name="toppart" id="toppart" />
<input type="hidden" name="bottompart" id="bottompart" /> -->
                        <input type="text" autocomplete="off" name="mobile_number" id="mobile_number"
                            placeholder="01xxxxxxxxx" maxlength="11" class="form-control" required onkeyup="if (/\D/g.test(this.value))
                                    this.value = this.value.replace(/\D/g, '');" />
                        <span>Enter your name & shipping address. </span>
                        <textarea class="form-control" name="shipping_details" id="shipping_details" requied></textarea>
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
    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <script>
        function CheckOutMUltiple() {
            $('#myModal').modal('show');
        }

        function continueShopping() {
            window.location.href = "{{url('/')}}";
        }
    </script>
    @endsection