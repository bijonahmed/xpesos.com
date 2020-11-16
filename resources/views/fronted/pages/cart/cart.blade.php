@extends('fronted.master')
@section('title','Add to Cart')
@section('maincontent')
<style>
    .ps-shopping-cart .ps-section__cart-actions {
        padding-top: 30px;
        padding-bottom: 30px;
        /* display: -webkit-box; */
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        flex-flow: row nowrap;
        -webkit-box-pack: justify;
        justify-content: space-between;
    }
</style>
<div class="ps-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <!--  <li><a href="shop-list.php">Shop</a></li>
            <li>Whishlist</li>-->
        </ul>
    </div>
</div>
<div class="ps-section--shopping ps-shopping-cart">
    <div class="container">
        <div class="ps-section__header">
            <h1 style="font-size: 30px;">Shopping Cart</h1>
        </div>
        <div class="ps-section__content">
            <div class="table-responsive">
                <table class="table ps-table--shopping-cart">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product name</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL</th>
                            <th>X</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $x = 1;
                        $sum = 0;
                        $contents = Cart::getContent();
                        foreach ($contents as $item) {
                            $pcode = DB::table('tbl_product')->where('product_id', $item->id)->first();
                        ?>
                            <tr>
                                <td><img src="{{ $pcode->photo1 }}" alt="image" style="height:100px; width: 100px;"></td>
                                <td>
                                    <a href="#">
                                        <?php
                                        $txt = $item->name;
                                        echo wordwrap($txt, 30, "<br />");
                                        if (!empty($item->attributes->has('size'))) {
                                            $size = json_encode($item->attributes->size, JSON_UNESCAPED_SLASHES);
                                            if (!empty($size)) {
                                                echo $output = str_replace('"', "", "$size");
                                            }
                                        }
                                        ?></a>

                                </td>
                                <td class="price">{{ $setting->currency }} {{$pcode->special_price}} <del>{{$pcode->regular_price}}</del></td>
                                <td>
                                    <form action="{{url('/update-product')}}" method="post" class="form-inline">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$item->id}}" size="1" class="form-control" />

                                        <div class="form-group--number" style="text-align: center; padding: 10px;">
                                            <input class="form-control" type="text" size="1" placeholder="1" id="quantity" name="quantity" style="height: 37px;" value="{{$item->quantity}}" onkeyup="if (/\D/g.test(this.value))
                                                    this.value = this.value.replace(/\D/g, '')">
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="icon-pencil"></i></button>

                                    </form>
                                </td>
                                <td><?php echo $setting->currency . ' ' . $pcode->special_price * $item->quantity ?></td>
                                <td><a href="{{url('/delete-product/'.$item->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><button class="btn btn-danger"><i class="icon-trash"></i></button></a></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="ps-section__cart-actions"><a class="ps-btn" href="{{ url('/') }}">
                    <i class="icon-arrow-left"></i> Back to Home</a>
                <!-- <a class="ps-btn ps-btn--outline" href="shop-default.html" style="border: none; padding: 13px 20px;">
                <i class="icon-sync"></i> Update cart</a> -->
            </div>
        </div>
        <div class="ps-section__footer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <figure>
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
                    <figure>
                        <figcaption>Calculate shipping</figcaption>
                        <div class="form-group">

                            <select class="form-control form-control-lg">
                                <option>Select a country / region...</option>
                                <option>Nigeria</option>
                                <option>United Kingdom(UK)</option>
                            </select><br>
                            <input class="form-control" type="text" placeholder="Country"><br>
                            <input class="form-control" type="text" placeholder="Town/City"><br>
                            <input class="form-control" type="text" placeholder="Postcode"><br>
                        </div>
                        <div class="form-group">
                            <button class="ps-btn ps-btn--outline">Update</button>
                        </div>
                    </figure>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                    <div class="ps-block--shopping-total">
                        <div class="ps-block__header">
                            <p>Subtotal <span> $<?php echo $setting->currency . ' ' . number_format(Cart::getSubTotal()); ?></span></p>
                        </div>
                        <div class="ps-block__content">
                            <ul class="ps-block__product">
                                <?php
                                $x = 1;
                                $sum = 0;
                                $contents = Cart::getContent();
                                foreach ($contents as $item) {
                                    $pcode = DB::table('tbl_product')->where('product_id', $item->id)->first();
                                ?>
                                    <li><span class="ps-block__shop">YOUNG SHOP Shipping</span>
                                        <span class="ps-block__shipping">Free Shipping</span>
                                        <span class="ps-block__estimate">Estimate for <strong>Viet Nam</strong>
                                            <a href="#">{{$item->name}} : {{ $item->quantity}} x {{ $pcode->special_price}}= <?php echo $setting->currency . ' ' . $pcode->special_price * $item->quantity; ?></a></span>
                                    </li>
                                <?php } ?>
                            </ul>
                            <h3>Total <span><?php echo $setting->currency . ' ' . number_format(Cart::getSubTotal()); ?></span></h3>
                        </div>
                    </div><a class="ps-btn ps-btn--fullwidth" href="{{ url('/checkout') }}">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection