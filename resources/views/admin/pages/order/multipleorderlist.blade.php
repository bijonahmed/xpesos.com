@extends('admin.master')
@section('title','Order Invoice')
@section('maincontent')

<?php $setting = DB::table('tbl_setting')->first(); 

?>
<div class="content-wrapper">
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-md-5">
            <a href="{{url('/admin/order-list')}}"><i class="fa fa-arrow-circle-left"> Back</i></a>
        </div>
        <div class="col-md-5" style="text-align:right;">
            <a href="#" onclick="relaod();">Reload</a></div>
    </div>
   
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="padding: 10px; text-algin: right;">

                <div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true" class="fa fa-print"></i> Print</a></div><br>
                <div id="printableArea">
                    <div class="container">
                        <center> <img src="{{ url('admin/'.$setting->photo) }}" title="Your Store" alt="Your Store"
                                      style="height: 60px; width: 150px; text-align:center;" /><br>
                            <u style="color: black; font-weight: bold;">xpesos.com</u><br>
                           <img src="data:image/png;base64,{{ base64_encode($barcode_orderId) }}" style="height: 40px; width: 10%;"/>

                        </center>

                    </div>


                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="2" class="text-left"><b>Order Details</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 61%;" class="text-left"> <b>Order ID:</b>
                                    {{ $multipleorder->OrderId }}
                                    <br>
                                    <b>Order Date:</b>
                                    <?php echo date("d-m-Y", strtotime($multipleorder->order_date)) ?></td>
                                <td style="width: 32%; text-align: left;"><b>Payment Method:</b> Cash On Delivery</center>
                                    <br>
                                    <b>Shipping Method:</b>
                                    <?php
                                    if ($multipleorder->select_method == "1") {
                                        echo "Hello Courier";
                                    } elseif ($multipleorder->select_method == "2") {
                                        echo "Patho Courier";
                                    } elseif ($multipleorder->select_method == "3") {
                                        echo "Sundarban Courier";
                                    } elseif ($multipleorder->select_method == "4") {
                                        echo "S.A Paribahan";
                                    } elseif ($multipleorder->select_method == "5") {
                                        echo "Self Service";
                                    } elseif ($multipleorder->select_method == "6") {
                                        echo "Delivery Tiger";
                                    }
                                    ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>



                    <table class="table">
                        <thead>
                            <tr style="background-color: #e6e6e6;">
                                <td style="width: 33%; vertical-align: top;" class="text-left"><b>Form</b></td>

                                <?php
                                if (!empty($multipleorder->billing_details)) {
                                    ?>
                                    <td style="width: 33%; vertical-align: top;" class="text-left"><b>Billing Address</b></td>
                                <?php } else { ?>
                                    <td style="width: 33%; vertical-align: top;" class="text-left"></td>
                                <?php } ?>

                                <td style="width: 34%; vertical-align: top;" class="text-left"><b>Shipping Address</b></td>
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

                                    <?php
                                    if (!empty($multipleorder->billing_details)) {
                                        //echo $multipleorder->billing_details;
                                        $text = $multipleorder->billing_details;
                                        echo nl2br($text);
                                    }
                                    ?>

                                </td>
                                <td class="text-left">
                                    Mobile: {{ $multipleorder->mobile }}<br>
                                    <?php
                                    if (!empty($multipleorder->shipping_details)) {
                                        //echo $multipleorder->billing_details;
                                        $text = $multipleorder->shipping_details;
                                        echo nl2br($text);
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover" border="1">
                            <thead>
                                <tr style="background-color: #e6e6e6;">
                                    <td class="text-left"><b>Product Name</b></td>
                                    <td class="text-left"><b>Product Code</b></td>
                                    <td class="text-right"><b>Quantity</b></td>
                                    <td class="text-right"><b>Price</b></td>
                                    <td class="text-right"><b>Total</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum = 0;
                                foreach ($order as $item) {
                                    if (!empty($item->quantity)) {
                                        $qty=$item->quantity;
                                    } else {
                                        $qty=1;
                                    }
                                    $sum+= $qty * $item->cus_price;

                                    ?>
                                    <tr>
                                        <td class="text-left">{{$item->product_name}} <b><?php
                                                if (!empty($item->size)) {
                                                    echo " (" . $item->size . ")";
                                                }
                                                ?></b><br>
                                        </td>
                                        <td class="text-left">{{$item->api_id}}</td>
                                        <td class="text-right"><?php
                                            if (!empty($item->quantity)) {
                                                echo $item->quantity;
                                            } else {
                                                echo "1";
                                            }
                                            ?></td>
                                        <td class="text-right"><?php echo $customerPrice=$item->cus_price;?></td>
                                        <td class="text-right"><?php
                                        if (!empty($item->quantity)) {
                                            $qty=$item->quantity;
                                        } else {
                                            $qty=1;
                                        }
                                        echo $customerPrice= $qty * $item->cus_price;
                                        
                                        ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><b>Sub-Total</b></td>
                                    <td class="text-right"><b><span id="subtotal"><?php echo $sum; ?> {{ $setting->currency}}</span></b></td>

                                </tr>
                                <tr style="display:none;">
                                    <td colspan="3"></td>
                                    <td class="text-right"><b>Delivery Charge</b></td>
                                    <td class="text-right"><input type="hidden" value="<?php echo "0"; ?>">100 ৳</span>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><b> Total</b></td>
                                    <td class="text-right"><b><span id="totalsum"><?php echo $sum + (100); ?>
									{{ $setting->currency}}</span></b></td>

                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><b>Advance</b></td>
                                    <td class="text-right"><span id="advancesval">{{ $multipleorder->dvcharge }}
                                            {{ $setting->currency}}</span></td>

                                </tr>

                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right" style="color: green; font-size: 18px; font-weight: bold;"><b>Grand Total</b></td>
                                    <td class="text-right"><span id="advancesval"
                                                                 style="color: green; font-size: 18px; font-weight: bold;"><?php
                                                                     $adv = (int)$sum + (int)(100) - (int)($multipleorder->dvcharge);
                                                                     echo $adv;
                                                                     ?>{{ $setting->currency}}</span></td>

                                </tr>


                            </tfoot>

                        </table>

                    </div>
                </div>

                <hr>

                <form enctype="multipart/form-data" id="orderUpdateFrm">
                    {{ csrf_field() }}

                    <input type="hidden" id="dvcharge" name="dvcharge" value="{{$multipleorder->dvcharge}}" />


                    <label for="large-input" class="col-form-label">Billing Address</label>
                    <textarea name="billing_details" id="billing_details"
                              style="width: 100%;"><?php
                                  if (!empty($multipleorder->billing_details)) {
                                      echo $multipleorder->billing_details;
                                  }
                                  ?></textarea><br>

                    <label for="large-input" class="col-form-label">Shipping Address</label>
                    <textarea name="shipping_details" id="shipping_details"
                              style="width: 100%;"><?php
                                  if (!empty($multipleorder->shipping_details)) {
                                      echo $multipleorder->shipping_details;
                                  }
                                  ?></textarea><br>


                    <label for="large-input" class="col-form-label">Advance</label>
                    <input type="text" name="advance" id="advance"
                           value="<?php
                           if (!empty($multipleorder->dvcharge)) {
                               echo $multipleorder->dvcharge;
                           }
                           ?>"
                           style="width: 100%;" /><br>


                   
                    <input type="hidden" name="order_id" value="{{ $multipleorder->order_id }}" />
                    <label for="large-input" class="col-form-label">Status</label>
                    <select style="width: 100%;" id="status" name="status">
                        <option value='1'>Received Order</option>
                        <option value='2'>Confirm Order</option>
                        <option value='3'>Shipped Order</option>
                        <option value='4'>Complete Order</option>
                        <option value='5'>Cancel Order</option>
                        <option value='6'>Hold Order</option>
                        <option value='7'>Return Order</option>
                    </select>
					<br><br>
                    <button type="submit" class="btn btn-primary btn-submit btn-block"><i
                            class="fa fa-check-square-o"></i> Save
                    </button>
                </form>

            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="message">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <p style="font-size: 28px; font-weight: bold; color: green; text-align: center;">Successfully
                            Update Order.</p>
                    </div>

                </div>
            </div>
        </div>
       


        <input type="hidden" value="{{$multipleorder->mobile}}" id="mobile_number" name="mobile_number" />
        <input type="hidden" value="Dear Sir/Madam, Thanks for shopping with us. Your order no. {{$multipleorder->OrderId}} is in processing. You will be notified very soon. 
Your trusted, KaruGhor" id="confirm_order" name="confirm_order" />

        <input type="hidden" value="Dear Sir/Madam, Your order no. {{$multipleorder->OrderId}} already shipped at your shipping address. You will be received very soon. Your trusted, KaruGhor"
        id="shipped_order" name="shipped_order" />

        <script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
        <script>
function relaod() {
    location.reload();
}

// Print
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function sendsmsApi(status) {
    if (status == '2') {
        var msg = $("input[name=confirm_order]").val();
    } else if (status = '3') {
        var msg = $("input[name=shipped_order]").val();
    }

    //if(status == 2 || status == 3){
    var mobile_number = '88' + $("input[name=mobile_number]").val();
    var number = '(' + mobile_number + ')';
    $.ajax({
        url: 'http://sms.easydomainhost.com/smsapi?api_key=C20047605daed3b4e512c7.33970501&type=text&contacts=' +
                number + '&senderid=8809601000500&msg=' + msg,
        type: 'GET',
        crossDomain: true,
        success: function () {
            alert("Success");

        },
    })
    //  }

}

$('#orderUpdateFrm').on('submit', function (event) {
    event.preventDefault();
    var advance = $("#advance").val();
    if (advance == "") {
        alert("Please Write Advance Amount");
    } else {
        var adv = $("#advance").val();
        var subtotal = $("#subtotal").html();
        var result = parseInt(subtotal) - parseInt(adv) + (100);
        $("#totalsum").html(result + '৳');
        // $("#advancesval").html(adv);
        $("#dvcharge").val(adv);

        $.ajax({
            url: '{{URL::to("admin/update/update-order")}}',
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                var status = $("select[name=status]").val();
                if (status == '2') {
                    sendsmsApi(status);
                } else if (status == '3') {
                    sendsmsApi(status);
                }

                $('#message').modal('show')
                setTimeout(function () {
                    $('#message').modal('hide')
					location.reload();
                }, 1000);

            }
        })
    }
});

    function statusSelected() {
        $("#status").val(<?php echo $multipleorder->status ?>);
        $("#select_method").val(<?php echo $multipleorder->select_method ?>);
    }
 statusSelected();
</script>
        @endsection