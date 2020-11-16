@extends('admin.master')
@section('title',$title)
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="{{asset(url('admin/fstdropdown-master/fstdropdown.css'))}}">
	<script src="{{asset(url('admin/fstdropdown-master/fstdropdown.js'))}}"></script>
<style>
    .modal-lg {
        max-width: 90% !important;
    }
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
</style>
<div class="content-wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('admin/supplier-invoice-list')}}">Back Supplier Invoice List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Supplier Edit Invoice</li>
        </ol>
    </nav>
    <!--Start Dashboard Content-->
    <div class="card" style="padding: 10px;">
        <?php
        $productlist = DB::table('tbl_supplier_invoice_two')
                        ->select(DB::raw('tbl_supplier_invoice_two.total,tbl_supplier_invoice_two.rate,tbl_supplier_invoice_two.qnty,tbl_item.item_id,tbl_product.product_name,tbl_product.product_code'))
                        ->leftJoin('tbl_item', 'tbl_item.item_id', '=', 'tbl_supplier_invoice_two.item_id')
                        ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_item.product_id')
                        ->where('supplier_invoice_id', $supplier_invoice_id)
                        ->orderBy('tbl_supplier_invoice_two.supplier_invoice_id', 'desc')->get();
        ?>
        <center><u>Supplier Invoice<br>[Supplier Invoice ID: <b><?php
                    if (!empty($supp_Invoice_id)) {
                        echo $supp_Invoice_id;
                    }
                    ?></b>]<br></u>

            <button class="btn btn-primary ipt" onClick="printdiv('div_print');">
                <i class="fa fa-print" aria-hidden="true"></i> Invoice Print</button>


        </center>
        <form id="cform" enctype="multipart/form-data" action="{{url('/admin/UpdateSupplierInvoiceParticular')}}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <u><b>Supplier Details</b></u><br>

                    Supplier Name: {{$supplider_row->supplier_name}}<br>
                    Supplier Contact Person: {{$supplider_row->supplier_contact_person_name}}<br>
                    Supplier Email: {{$supplider_row->supplier_email}}<br>
                    Supplier Phone: {{$supplider_row->supplier_phone}}<br>
                    Supplier Address: {{$supplider_row->supplier_address}}<br>

                </div>

                <div class="col-md-3">

                    <input type="text" name="manual_sp_invoice_id" id="manual_sp_invoice_id" placeholder="If Manual Invoice Id" value="{{$manual_sp_invoice_id}}" /><br>
                    <!-- Total Amount: 1256-->
                </div>

            </div>
            <hr>
            <div class="row">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Item Name</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                    <input type="hidden" name="supplier_id" id="supplier_id" value="{{$supplider_row->supplier_id}}"/>
                   <input type="hidden" name="supp_Invoice_id" id="supp_Invoice_id" value="{{$supp_Invoice_id}}"/>
                    <td> <select id="item_id" name="item_id" class="fstdropdown-select"
                                 onchange="getItemInfo(this.value);" style="width: 100%;">
                            <option value="">Select Item</option>
                            <?php
                            $x = 1;
                            foreach ($item as $val) {
                                ?>
                                <option value="<?php echo $val->item_id; ?>"><?php echo $x . '. ' . $val->product_name . ' [' . $val->product_code . '] '; ?>
                                </option>
                                <?php
                                $x++;
                            }
                            ?>
                        </select> </td>
                    <td><input type="text" name="qnty" id="qnty" onkeyup="valCal();"></td>
                    <td><input type="text" name="rate" id="rate" onkeyup="valCal();"></td>
                    <td><input type="text" name="total" id="total"></td>
                    <td><button class="btn btn-primary btn-submit"> + Add</button></td>
                    </tr>

                    </tbody>
                </table>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table-hover" style="width: 100%; color:#000;">
                            <thead>
                                <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
                                    <th style="text-align: center;">SL</th>
                                    <th style="text-align: center;">Item Name</th>
                                    <th style="text-align: center;">Qnty</th>
                                    <th style="text-align: center;">Rate</th>
                                    <th style="text-align: center;">Total</th>
                                    <th>Add</th>
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
                            <span>Grand Total</span>
                            <input type="text" name="grand_total" id="grand_total" placeholder="Grand Total" value="{{$grand_total}}" required/><br>

                            <span>Shipping Cost</span>
                            <input type="text" name="shipping_cost" id="shipping_cost" placeholder="Shipping Cost" value="{{$shipping_cost}}" onkeyup="getShippingValue(this.value)" required/><br>

                            <span>Total</span><br>
                            <input type="text" name="total_amt" id="total_amt" placeholder="Total" value="{{$total_amt}}" required/><br>
                            <span>Advance</span><br>
                            <input type="text" name="advance" id="advance" placeholder="Advance" required value="{{$advance}}" onkeyup="getDueAmt(this.value)"/><br>
                            <span>Due</span><br>
                            <input type="text" name="due" id="due" placeholder="Due" value="{{$due}}" required/>
                        </div><br>

                    </div>
                    <br>
                    <button class="btn btn-primary btn btn-block" type="submit">Finally Save</button>
                </div>
            </div>
    </div>
</form>
</div>

<!--Start Invoice Modal -->

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
                <b>Invoice ID: {{$supp_Invoice_id}}</b><br>
                Supplier Invoice
                <strong><?php echo date("d-M-Y"); ?></strong> 

            </div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-sm-7">
                        <h6 class="mb-3">From:</h6>
                        <div>
                            <strong>  {{ $setting->name }}</strong>
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
                            <strong>{{$supplider_row->supplier_name}}</strong>
                        </div>
                        <div>Person Name: {{$supplider_row->supplier_contact_person_name}}</div>
                        <div>{{$supplider_row->supplier_address}}</div>
                        <div>Email: {{$supplider_row->supplier_email}}</div>
                        <div>Phone: {{$supplider_row->supplier_phone}}</div>
                    </div>

                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th class="center">Product Name</th>
                                <th class="center">Product Code</th>
                                <th class="center">Qty</th>
                                <th class="center">Rate</th>
                                <th class="center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 1;
                            foreach ($productlist as $item) {
                                ?>
                                <tr>
                                    <td class="center"><?php echo $x; ?></td>
                                    <td class="left strong"><?php echo $item->product_name; ?></td>
                                    <td class="left"><?php echo $item->product_code; ?></td>
                                    <td class="center"><?php echo $item->qnty; ?></td>
                                    <td class="right"><?php echo number_format($item->rate); ?></td>
                                    <td class="right"><?php echo number_format($item->total); ?></td>
                                </tr>
                                <?php
                                $x++;
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">

                    </div>

                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td class="right">৳<?php echo number_format($grand_total); ?></td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Shipping Cost</strong>
                                    </td>
                                    <td class="right">৳<?php echo number_format($shipping_cost); ?></td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">৳<?php echo number_format($total_amt); ?></td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Advance</strong>
                                    </td>
                                    <td class="right">
                                        <strong>৳<?php echo number_format($advance); ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Due</strong>
                                    </td>
                                    <td class="right">
                                        <strong>৳<?php echo number_format($due); ?></strong>
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


<!--End -->

<script>
function valCal(){
var qnty=  $("#qnty").val();
var rate=  $("#rate").val();
$("#total").val(qnty * rate);

}
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

    function getShippingValue(shipping_cost) {
        var grand_total = $("#grand_total").val();
        var total = parseInt(shipping_cost) + parseInt(grand_total);
        //$("#grand_total").val(total);
        $("#total_amt").val(total);
    }

    function getDueAmt(advance) {
        var total_amt = $("#total_amt").val();
        var due = parseInt(total_amt) - parseInt(advance);
        $("#due").val(due);
    }
    function emptyfrm() {
        $("#cform")[0].reset();
    }

    function editItemListId(supplier_invoice_id, item_id) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "/admin/supplier/item-remove/",
            data: {
                "supplier_invoice_id": supplier_invoice_id,
                "item_id": item_id,
                "_token": _token,
            },
            success: function (data) {
                 //alert("success");
                featch_list();
            }
        });

    }

    function featch_list(query = '') {
        //	console.log("test");
        $.ajax({
            url: "{{ route('editItemlistinvoice.search') }}",
            method: 'GET',
            data: {
                query: query
            },
            dataType: 'json',
            success: function (data) {
                //alert(data.total_sum);
                $('.tbodydata').html(data.table_data);
                $('#total_records').text(data.total_data);
                $('#grand_total').val(data.total_sum);
            }
        })
    }
    featch_list();

    // ajax post
    $(".btn-submit").click(function (e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var item_id = $("select[name=item_id]").val();
        //var supplier_id = $("input[name=supplier_id]").val();
        var qnty = $("input[name=qnty]").val();
        var manual_sp_invoice_id = $("input[name=manual_sp_invoice_id]").val();
        var rate = $("input[name=rate]").val();
        var total = $("input[name=total]").val();

        if (item_id == '') {
            alert("Please Select Item Name.");
            $("#item_id").focus();
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "/admin/update-invoice-item",
            dataType: "json",
            data: {
                _token: _token,
                item_id: item_id,
                qnty: qnty,
                //supplier_id: supplier_id,
                manual_sp_invoice_id: manual_sp_invoice_id,
                rate: rate,
                total: total
            },
            success: function (data) {
                // alert("Save");
                //$('#modal-animation-3').modal('hide');
                $("#cform")[0].reset();
                featch_list();

            }
        });
    });
    function getItemInfo(item_id) {

        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "/admin/supplier/search-ItemId/" + item_id,
            data: {
                "item_id": item_id,
                "_token": _token,
            },
            success: function (data) {
                $("#qnty").val(data.qnty);
                $("#rate").val(data.rate);
                var total = data.qnty * data.rate;
                $("#total").val(total);
            }
        });
    }


</script>
@endsection