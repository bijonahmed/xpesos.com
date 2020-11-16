@extends('admin.master')
@section('title',$title)
@section('maincontent')
<?php $setting = DB::table('tbl_setting')->first(); ?>
<div class="content-wrapper">
    <link rel="stylesheet" href="{{asset(url('admin/fstdropdown-master/fstdropdown.css'))}}">
    <script src="{{asset(url('admin/fstdropdown-master/fstdropdown.js'))}}"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="padding: 10px; text-algin: right;">
                <!-- <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" /> -->
                <center><span id="price_msg" style="font-size: 15px;"></span></center>
                <div id="printableArea">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <div class="alert-icon">
                                    <i class="icon-check"></i>
                                </div>
                                <div class="alert-message">
                                    <span><strong>Create</strong> a new order invoice.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary ipt btn-block" onClick="printdiv('div_print');" style="height: 50px;">
                                <i class="fa fa-print" aria-hidden="true"></i> Invoice Print</button>
                        </div>

                        <div class="col-md-2">
                        <a href="{{url('/admin/invoice-list')}}" style="color: white;">
						<button class="btn btn-danger btn-block" style="height: 50px;">
                                Back Invoice List </button>
						</a>
                        </div>
                      
                            <div class="modal fade" id="warningmodal" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-danger border-danger">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-white"><i class="fa fa-star"></i> Warning
                                                Message
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-white">
                                            <span id="message1"
                                                style="font-size: 22px; font-weight: bold; text-align: justify;"></span><br>
                                            <span id="message2"
                                                style="font-size: 22px; font-weight: bold; text-align: justify;"></span><br>
                                            <span id="message3"
                                                style="font-size: 22px; font-weight: bold; text-align: justify;"></span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal"><i
                                                    class="fa fa-times"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Modal -->
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 61%;" class="text-left"> <b>Order ID&nbsp;&nbsp;&nbsp;&nbsp;:
                                            </b>
                                            <?php 
                                            if(!empty($lastOrderRow->OrderId)){
                                               echo $lastOrderRow->OrderId ;
                                            }
                                            ?>
                                        </td>
                                        <td style="width: 32%; text-align: left;">
                                            <b>Order Date:</b> <?php echo date("Y-m-d");?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

            <form id="cform" enctype="multipart/form-data" action="{{url('/admin/UpdateOrderInvoice')}}"
            method="post">
                            {{ csrf_field() }}
                            <table class="table" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 61%;" class="text-left"> Customer
                                            Name&nbsp;&nbsp;&nbsp;&nbsp;:
                                            <input type="text" name="customer_name" value="{{$lastOrderRow->customer_name}}" required style="width: 50%;" />
                                            <br>
                                            Customer Address:<textarea name="address" rows="1" cols="5"
                                                style="width: 100%; margin-left: 5px; margin-top: 5px;"
                                                required>{{$lastOrderRow->address}}</textarea>
                                        </td>
                                        <td style="width: 100%; text-align: left;">Customer Phone:
                                         <input type="text" name="mobile" value="{{$lastOrderRow->mobile}}" required />
                                         <input type="hidden" name="cutomer_id" value="{{$lastOrderRow->customer_id}}" required />
                                         <input type="hidden" name="order_id" id="order_id" value="{{$lastOrderRow->order_id}}" />

                                         
                                            <!-- <br>
                                    <b>Shipping Method:</b> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
                <!-- start -->
                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Description</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> <select id="product_id" name="product_id" class="fstdropdown-select"
                                    onchange="getItemInfo(this.value);" style="width: 100%; height: 30px;">
                                    <option value="">Select Product</option>
                                    <?php
                            $x = 1;
                            foreach ($item as $val) {
                                ?>
                                    <option value="<?php echo $val->product_id; ?>">
                                        <?php echo $x . '. ' . $val->product_name . ' [' . $val->product_code . '] '; ?>
                                    </option>
                                    <?php
                                $x++;
                            }
                            ?>
                                </select> </td>
                            <td><input type="text" name="description" id="description"></td>
                            <td><input type="text" name="qnty" id="qnty" style="width: 80%;"
                                    onkeyup="getCalculationQty(this.value);"></td>
                            <td><input type="text" name="price" id="price" style="width: 80%;"
                                    onkeyup="getCalculation(this.value);"></td>
                            <td><span id="total"></span></td>
                            <td><button class="btn btn-primary btn-add-order">+</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%; color: black;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Qnty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="tbodydata">
                            </tbody>
                        </table><br>
                    </div>
                    <div class="row">
                        <div class="col-9">
                        </div>
                        <div class="col-2">
                            <span>Sub Total</span>
                            <input type="text" name="sub_total" id="grand_total" placeholder="Sub Total" value="{{$lastOrderRow->sub_total}}" required /><br>
                            <span>Delivery Charge</span>
                            <input type="text" name="dvcharge" id="dvcharge" value="{{$lastOrderRow->dvcharge}}" placeholder="Delivery Charge"
                                onkeyup="getDvCharge(this.value)" required /><br>
                            <span>Total</span><br>
                            <input type="text" name="total_amt" id="total_amt" value="{{$lastOrderRow->total_amt}}" placeholder="Total" required /><br>
                            <span>Advance</span><br>
                            <input type="text" name="advance" id="advance" value="{{$lastOrderRow->advance}}" placeholder="advance"
                                onkeyup="getAdvAmt(this.value)" required /><br>
                            <span>Due</span><br>
                            <input type="text" name="due" id="due" value="{{$lastOrderRow->due}}" placeholder="Due" required />
                        </div><br>
                    </div>
                    <br>
                </div>
              
                <div class="row">
                    <div class="col-md-6">
                        <label for="large-input" class="col-form-label">Billing Address</label>
                        <textarea name="billing_details" id="billing_details" style="width: 100%;">{{$lastOrderRow->billing_details}}</textarea><br>
                        <label for="large-input" class="col-form-label">Shipping Address</label>
                        <textarea name="shipping_details" id="shipping_details" style="width: 100%;">{{$lastOrderRow->shipping_details}}</textarea><br>
                    </div>
                    <div class="col-md-5">
                        Shipping Method
                        <select style="width: 100%;" id="select_method" name="select_method">
                            <option value='1'>Hello Courier</option>
                            <option value='2'>Pathao Courier</option>
                            <option value='3'>Sundarban Courier</option>
                            <option value='4'>S.A Paribahan</option>
                            <option value='5'>Self Service</option>
                            <option value='6'>Delivery Tiger</option>
                        </select>
                        <br>
                        Payment Method:
                        <select style="width: 100%;" id="payment_method" name="payment_method">
                            <option value='1'>Cash on Delivery</option>
                            <option value='2'>Online Payment</option>
                        </select>
                        <br>
                        Status
                        <select style="width: 100%;" id="status" name="status">
                            <option value='1'>Received Order</option>
                            <option value='2'>Confirm Order</option>
                            <option value='3'>Shipped Order</option>
                            <option value='4'>Complete Order</option>
                            <option value='5'>Cancel Order</option>
                            <option value='6'>Hold Order</option>
                            <option value='7'>Return Order</option>
                        </select>
                       
                    </div>
                 
                </div>
               
                <button type="submit" class="btn btn-primary btn-submit btn-block" style="height: 50px; margin-top: 20px;"><i class="fa fa-check-square-o"></i>
                    Save & New
                </button>
            </div>
        </div>
    </div>
    </form>
    <!-- =================================================================== Start Print ================================================================= -->


    <div id="div_print" style="display: none;">

<div class="container">
    <div class="container">
        <center> <img src="{{ asset('admin/'.$setting->photo) }}" title="Your Store" alt="Your Store"
                style="height: 60px; width: 150px; text-align:center;" /><br>
            <u style="color: black; font-weight: bold;">Online Mega Shop</u>

        </center>

    </div>

    <div class="card">
        <div class="card-header">
            Supplier Invoice
            <strong><?php echo date("d-M-Y");?></strong>

        </div>
        <div class="card-body">

            <div class="row mb-4">
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
                    <div>Customer  Name: {{$customer_details->customer_name}}</div>
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
                            <td class="right"><?php echo number_format($item->quantity * $item->price) ;?></td>
                            
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

    function getDvCharge(dvCharge) {
        var grandtotal = $("#grand_total").val();
        var total_amt = parseInt(grandtotal) + parseInt(dvCharge);
        $("#total_amt").val(total_amt);
    }

    function getAdvAmt(advanceAmt) {
        var totalAmt = $("#total_amt").val();
        var dueAmt = parseInt(totalAmt) - parseInt(advanceAmt);
        $("#due").val(dueAmt);
    }

    function relaod() {
        location.reload();
    }

    function removeProduct(product_id,order_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: "/admin/product-remove-order-wise",
            data: {
                "product_id": product_id,
                "order_id": order_id,
                "_token": _token,
            },
            success: function(data) {
                editfeatch_list(order_id);
            }
        });
    }
    $(".btn-add-order").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var order_id = $("input[name=order_id]").val();
        var product_id = $("select[name=product_id]").val();
        var description = $("input[name=description]").val();
        var qnty = $("input[name=qnty]").val();
        var price = $("input[name=price]").val();
        if (product_id == '' || qnty == '' || description == '' || price == '') {
            alert("Please input box fillup.");
            $("#product_id").focus();
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "/admin/addEdit-order-invoice",
            dataType: "json",
            data: {
                _token: _token,
                order_id: order_id,
                product_id: product_id,
                description: description,
                qnty: qnty,
                price: price
            },
            success: function(data) {
                $("#total").html('');
                $("#product_id").val('');
                $("#description").val('');
                $("#qnty").val('');
                $("#price").val('');
                editfeatch_list(order_id);
            }
        });
    });
var orderId= <?php echo $lastOrderRow->order_id; ?>;
    function editfeatch_list(orderId) {
	console.log(orderId);
        var _token = $("input[name='_token']").val();

        $.ajax({
            url: "/admin/editprolistbyInvoice/",
            method: 'POST',
            data: {
                orderId: orderId,
                _token: _token
            },
            dataType: 'json',
            success: function(data) {
                //alert(data.total_sum);
                $('.tbodydata').html(data.table_data);
                $('#total_records').text(data.total_data);
                $('#grand_total').val(data.total_sum);
            }
        })
    }
    editfeatch_list(orderId);

    function getItemInfo(product_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "/admin/invoice/search-product/" + product_id,
            data: {
                "product_id": product_id,
                "_token": _token,
            },
            success: function(data) {
                var specialprice = data.special_price;
                var pricemsg = " Qunatity : " + data.qty + "Pic , [Special Price " + data.special_price +
                    "] [Regular Price " + data.regular_price + "]";
                $("#price_msg").html(pricemsg);
                var qty = $("#qnty").val();
                var price = $("#price").val();
                $("#total").html(qty * price);
            }
        });
    }

    function getCalculation(price) {
        var qty = $("#qnty").val();
        $("#total").html(price * qty);
    }

    function getCalculationQty(qty) {
        checkQty(qty);
        var price = $("#price").val();
        $("#total").html(qty * price);
    }

    function checkQty(qty) {
        var _token = $("input[name='_token']").val();
        var product_id = $("#product_id").val();
        var qty = qty;
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: "/admin/check-product-qty/",
            data: "product_id=" + product_id + "&qty=" + qty + "&_token=" + _token,
            success: function(data) {
                if (data.msg == "large") {
                    var message1 = "Your Total Qty In Hand " + data.stockin + " pic.";
                    var message2 = "But you are giving " + qty + " pic.";
                    var message3 ="Please go to Purchages Invoice.";
                    $("#qnty").val("");
                    $("#qnty").focus();
                    $("#message1").html(message1);
                    $("#message2").html(message2);
                    $("#message3").html(message3);
                    $('#warningmodal').modal('show')
                }
            }
        });
    }

function selectElement(){
        $("#select_method").val('<?php echo $lastOrderRow->select_method ?>');
        $("#payment_method").val('<?php echo $lastOrderRow->payment_method ?>');
        $("#status").val('<?php echo $lastOrderRow->status?>');
}
selectElement();

    </script>
    @endsection