@extends('admin.master')
@section('title','Vendor Ledger')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.modal-lg {
    max-width: 90% !important;
}

.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid blue;
    border-bottom: 16px solid blue;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
<div class="content-wrapper">
    <div class="alert alert-success alert-dismissible" role="alert">
        <div class="alert-icon">
            <i class="icon-check"></i>
        </div>
        <div class="alert-message">
            <span><strong>Vendor Ledger</strong> List</span>
        </div>
    </div>
    <!--Start Dashboard Content-->
    <div class="card" style="padding: 10px;">
        <form enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4">
                    <input type="text" id="fromdate" autocomplete="off" name="fromdate" placeholder="From Date"
                        style="width: 100%;" required>
                </div>
                <div class="col-md-4">
                    <input type="text" id="todate" name="todate" autocomplete="off" placeholder="To Date"
                        style="width: 100%;" required>
                </div>
                <div class="col-md-3">
                    <select id="supplier_id" name="supplier_id" style="width: 100%; height: 30px;"
                        onchange="getVendorInfo();">
                        <option value="">Select Vendor</option>
                        <?php
                                    foreach ($vendor as $val) {
                                    $name =  $val->supplier_name ? ' ['. $val->supplier_name.']' : "";
                                        ?>
                        <option value="<?php echo $val->supplier_id; ?>"><?php echo $val->supplier_phone. $name ; ?>
                        </option>
                        <?php
                                    }
                                    ?>
                    </select>
                </div>

            </div>
        </form>
        <center>
            <div class="loader" id="loader" style="display:none;"></div>
        </center>
        <div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true"
                    class="fa fa-print"></i> Print</a></div><br>
        <div id="printableArea">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <div class="table-responsive">
                        <center><span id="totalsum"
                                style="font-size: 22px; font-weight: bold; text-align: center; color: green;"></span>
                        </center>
                        <table class="table table-striped table-hover" style="width: 100%; color:green;" id="itemlist">
                            <thead class="thead-primary">
                                <tr>
                                    <!--	<td style="width: 5px;">S.L</td> -->
                                    <td class="text-left">Invoice ID</td>
                                    <td class="text-left">Invoice Date</td>
                                    <td class="text-left">Vendor Name</td>
                                    <td class="text-left">Grand Total</td>
                                    <td class="text-left">Due</td>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- End Row-->
</div>

</div>
</div>

<script>
// Print
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function getVendorInfo() {
    $("#loader").show();
    var fdate = $("#fromdate").val();
    var tdate = $("#todate").val();
    var supplier_id = $("#supplier_id").val();

    if (fdate == "" || tdate == "") {
        alert("Please Select Date...");
        $("#supplier_id").val("");
    }

    $('#itemlist tbody tr').remove();

    //sl = 1;
    var total = 0;
    $.ajax({
        //url: "{{ route('listByOrder.search') }}",
        url: "SupplierInvoices?fdate=" + fdate + "&tdate=" + tdate + "&supplier_id=" + supplier_id,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            $.map(data, function(item) {
                total += Number(item.total_amt);

                var id = "item_list_" + item.supp_Invoice_id;
                var html = "<tr id='" + id + "'>";
                html += "<td>" + item.supp_Invoice_id + "</td>";
                html += "<td>" + item.invoice_date + "</td>";
                html += "<td>" + item.supplier_name + "</td>";
                html += "<td>" + "৳" + item.total_amt + "</td>";
                html += "<td>" + "৳" + item.due + "</td>";

                html += "</tr>";
                if ($('#' + id).length < 1) {
                    $('#itemlist tbody').append(html);
                    // sl++;
                }
            });

            if (total > 0) {
                $('#totalsum').html("Vendor Total Transection: ৳" + total);
            } else {
                $('#totalsum').html("");
            }
            $("#loader").hide();
        }
    })
}

//fromdate
$.noConflict();
jQuery(document).ready(function($) {
    $("#fromdate").datepicker();
    $("#todate").datepicker();
    $("#status").val();
});
</script>
@endsection