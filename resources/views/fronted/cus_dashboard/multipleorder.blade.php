@extends('fronted.master')
@section('title',$title)
@section('maincontent')

<div class="container">

    <div class="row" style="margin: 30px 0px;">
        <div class="col-md-3">
            <ul class="list-group">
                @include('fronted.cus_dashboard.sidebar')
            </ul>
        </div>
        <div class="col-md-9">
            <div class="table-responsive active">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td colspan="2" class="text-left">Order Details</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 50%;" class="text-left"> <b>Order ID:</b>
                                {{ $mulripleorder->OrderId }}
                                <br>
                                <b>Order Date:</b> <?php echo date("d-m-Y", strtotime($mulripleorder->order_date)) ?>
                            </td>
                            <td style="width: 50%;" class="text-left"> <b>Payment Method:</b> Cash On Delivery
                                <br>


                                <b>Shipping Method:</b> Courier Services </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" border="0">
                    <thead>
                        <tr style="background-color: #e6e6e6;">
                            <td style="width: 33%; vertical-align: top;" class="text-left">Form.</td>

                            <?php
                            if (!empty($multipleorder->billing_details)) {
                            ?>
                                <td style="width: 33%; vertical-align: top;" class="text-left">Billing Address</td>
                            <?php } else { ?>
                                <td style="width: 33%; vertical-align: top;" class="text-left"></td>
                            <?php } ?>

                            <td style="width: 34%; vertical-align: top;" class="text-left">Shipping Address</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">
                                {{ $setting->name }}<br>
                                <?php
                                $text = $setting->address;
                                echo nl2br($text);
                                ?><br>
                                Phone: {{ $setting->tel }}<br>
                                Email: {{ $setting->email }}<br>
                            </td>
                            <td class="text-left">

                                <?php if (!empty($multipleorder->billing_details)) {
                                    echo $multipleorder->billing_details;
                                } ?>

                            </td>
                            <td class="text-left">
                                <?php
                                if (isset($mulripleorder->mobile)) {
                                    echo " Mobile:" . $mulripleorder->mobile;
                                }

                                if (isset($mulripleorder->mobile)) {
                                    echo " Shipping Address:" . $mulripleorder->shipping_details;
                                }
                                ?><br>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left">Product Name</td>
                                <td class="text-left">Product Code</td>
                                <td class="text-right">Quantity</td>
                                <td class="text-right">Price</td>
                                <td class="text-right">Total</td>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sum = 0;
                            foreach ($productsInfo as $item) {
                                $sum += $item->quantity * $item->price;
                            ?>
                                <tr>
                                    <td class="text-left">{{$item->product_name}}</td>
                                    <td class="text-left">{{$item->product_code}}</td>
                                    <td class="text-right">{{$item->quantity}}</td>
                                    <td class="text-right">{{$item->price}}</td>
                                    <td class="text-right"><?php echo number_format($item->quantity * $item->price); ?></td>


                                </tr>
                            <?php  } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-right"><b>Sub-Total</b></td>
                                <td class="text-right"><?php echo number_format($sum); ?></td>

                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-right"><b>Total</b></td>
                                <td class="text-right">
                                    <?php echo $sum; ?>
                                </td>

                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="buttons clearfix">
                    <div class="pull-right"><a class="btn btn-primary" href="{{url('/customer-panel')}}">Continue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection