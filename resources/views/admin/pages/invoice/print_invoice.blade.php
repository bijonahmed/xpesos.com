@extends('admin.master')
@section('title','Create a new order invoice')
@section('maincontent')
<?php $setting = DB::table('tbl_setting')->first(); ?>
<div class="content-wrapper">
    <link rel="stylesheet" href="{{asset(url('admin/fstdropdown-master/fstdropdown.css'))}}">
    <script src="{{asset(url('admin/fstdropdown-master/fstdropdown.js'))}}"></script>
    <div class="">
        <div class="">
            <div class="card" style="padding: 10px; text-algin: right;">
                <!-- <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" /> -->
                <center><span id="price_msg" style="font-size: 15px;"></span></center>
               
                    <div class="row">
                      
                        <div class="col-md-5">
                            <button class="btn btn-primary ipt btn-block" onClick="printdiv('div_print');"
                                style="height: 50px;">
                                <i class="fa fa-print" aria-hidden="true"></i> Invoice Print</button>
                        </div>

                        <div class="col-md-6">
                            <a href="{{url('/admin/invoice-list')}}"><button class="btn btn-danger btn-block"
                                    style="height: 50px;">
                                    <i class="fa fa-list" aria-hidden="true"></i> Back Invoice List</button></a>
                        </div>
    </div>

                        <!-- =================================================================== Start Print ================================================================= -->
                        <div id="div_print">

                            <div class="">
                                <div class="container">
                                    <center> <img src="{{ asset('admin/'.$setting->photo) }}" title="Your Store"
                                            alt="Your Store"
                                            style="height: 60px; width: 150px; text-align:center;" /><br>
                                        <u style="color: black; font-weight: bold;">Online Mega Shop</u>

                                    </center>

                                </div>

                                <div class="card" style="width: 100%;">
                                    <div class="card-header">
                                        Supplier Invoice
                                        <strong><?php echo date("d-M-Y");?></strong>

                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-10">
                                            <div class="col-sm-7">
                                                <h6 class="mb-3">From:</h6>
                                                <div>
                                                    <strong> {{ $setting->name }}</strong>
                                                </div>
                                                <div> <?php
                                $text = $setting->address;
                                echo nl2br($text);
                                ?></div>
                                                <div>Email: {{ $setting->email }}</div>
                                                <div>Phone: {{ $setting->tel }}</div>
                                            </div>

                                            <div class="col-sm-3">
                                                <h6 class="mb-3">To:</h6>
                                                <div>
                                                    Customer Information
                                                    <?php 
           $productlist= DB::table('tbl_order_details')
                            ->select(DB::raw('tbl_product.product_name,tbl_product.product_code,tbl_order_details.quantity,tbl_order_details.price'))
                            ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
                            ->where('tbl_order_details.order_id', $lastOrderRow->order_id)->get();

            $customer_details= DB::table('tbl_customer')->where('tbl_customer.customer_id', $lastOrderRow->customer_id)->first();
           
            ?>
                                                </div>
                                                <div>Customer Name: {{$customer_details->customer_name}}</div>
                                                <div>Customer address: {{$customer_details->address}}</div>
                                                <div>Phone: {{$customer_details->mobile}}</div>
                                            </div>

                                        </div>

                                        <div class="table-responsive-sm">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="center">#</th>
                                                        <th>Product Name</th>
                                                        <th>Product Code</th>
                                                        <th class="center">Qty</th>
                                                        <th class="right">Rate</th>
                                                        <th class="right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                        $x=1;
                        if(!empty($productlist)){
                            foreach($productlist as $item){
                        ?>
                                                    <tr>
                                                        <td class="center"><?php echo $x;?></td>
                                                        <td class="left strong"><?php echo $item->product_name;?></td>
                                                        <td class="left"><?php echo $item->product_code;?></td>
                                                        <td class="center"><?php echo $item->quantity;?></td>
                                                        <td class="right"><?php echo number_format($item->price);?></td>
                                                        <td class="right">
                                                            <?php echo number_format($item->quantity * $item->price) ;?>
                                                        </td>

                                                    </tr>
                                                    <?php 
                            $x++;
                            }}
                            ?>


                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-5">

                                            </div>

                                            <div class="col-lg-4 col-sm-5 ml-auto">
                                                <table class="table table-clear" style="margin-left: 20px;">
                                                    <tbody>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Sub Total</strong>
                                                            </td>
                                                            <td class="right">৳
                                                                {{$lastOrderRow->sub_total}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Delivery Charge</strong>
                                                            </td>
                                                            <td class="right">৳ {{$lastOrderRow->dvcharge}}</td>

                                                        </tr>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td class="right">৳ {{$lastOrderRow->total_amt}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Advance</strong>
                                                            </td>
                                                            <td class="right">
                                                                <strong>৳ {{$lastOrderRow->advance}}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="left">
                                                                <strong>Due</strong>
                                                            </td>
                                                            <td class="right">
                                                                <strong>৳{{$lastOrderRow->due}}</strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        </div>
                          </div>

<!--=================================================================== End Print ====================================================================-->
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<script>
function printdiv(printpage) {
    var headstr = "<html><head><title></title></head><body>";
    var footstr = "</body>";
    var newstr = document.all.item(printpage).innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + newstr + footstr;
    window.print();
    document.body.innerHTML = oldstr;
    return false;
}
</script>
@endsection