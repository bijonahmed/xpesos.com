@extends('admin.master')
@section('title','Order Report')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.fmt {
    width: 100%;
}

.h {
    height: 30px;
}

.pd {
    padding: 10px;
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
            <span><strong>Order</strong> Report</span>

        </div>
    </div>
    <!--Start Dashboard Content-->
    <div class="card pd">
        <form enctype="multipart/form-data" action="{{url('/admin/ordersreport')}}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4">
                    <input type="text" id="fromdate" class="fmt" autocomplete="off" name="fromdate"
                        placeholder="From Date" value="<?php echo date("d-m-Y");?>" required>
                </div>
                <div class="col-md-4">
                    <input type="text" id="todate" class="fmt" name="todate" autocomplete="off" placeholder="To Date"
                        value="<?php echo date("d-m-Y");?>" required>
                </div>
                <div class="col-md-3">
                    <select class="fmt h" id="status" name="status" onchange="changeStatus(this.value);">
                        <option value=''>Select Order Status</option>
                        <option value='2'>Confirm Order</option>
                        <option value='3'>Shipped Order</option>
                        <option value='4'>Complete Order</option>
                    </select>
                </div>

            </div>
        </form>
        <div align="right" style="padding: 10px;"><a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true" class="fa fa-print"></i> Print</a></div>
        <div id="printableArea">
        <div class="row">
      
            <div class="col-lg-12">
            <center>Order Status Report</center>
                <center>
                    <div class="loader" id="loader"></div>
                </center>

                <div class="table-responsive">
                    <table class="table-striped table-hover" style="width: 100%; color:black;">
                        <thead>
                            <tr style="background-color: green;color: white; border-radius: 0 6px 0 0">
                                <th style="text-align: center;">SL</th>
                                <th style="text-align: center;">Order ID</th>
                                <th style="text-align: center;">Mobile</th>
                                <th style="text-align: center;">Order Date</th>
                                <th style="text-align: center;">Total Selling</th>
                                <th style="text-align: center;">Selling Price</th>
                                <th style="text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
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
function changeStatus(status) {
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    $("#loader").show();
    // $(".table-responsive").hide();
    $.ajax({
        type: "get",
        url: '{{URL::to("admin/customOrderReport")}}',
        data: {
            status: status,
            fromdate: fromdate,
            todate: todate,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(data) {
            $('.tbody').html(data.table_data);
            $(".result").html(data.result)
            $("#loader").hide();
            $(".table-responsive").show();
        }
    });

}
changeStatus('2');

jQuery(document).ready(function($) {
    $("#fromdate").datepicker();
    $("#todate").datepicker();
});
</script>
@endsection