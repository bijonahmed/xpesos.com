@extends('admin.master')
@section('title','Multiple Item Report')
@section('maincontent')
<style>
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
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<div class="content-wrapper">
    <div class="alert alert-success alert-dismissible" role="alert">
        <div class="alert-icon">
            <i class="icon-check"></i>
        </div>
        <div class="alert-message">
            <span><strong>All Item </strong> Report</span>
        </div>
    </div>
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="padding: 10px;">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-7">
                        <div class="form-group" style="text-align: right;">
                            <input type="text" name="search" id="search" placeholder="Search Item"
                                style="width: 100%;" />
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" id="fromdate" autocomplete="off" name="fromdate" placeholder="From Date"
                                style="width: 100%;" value="<?php echo date('Y-m-d', strtotime('-7 days'));
							;?>" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="todate" name="todate" autocomplete="off" placeholder="To Date"
                                style="width: 100%; height: 30px;"
                                value="<?php echo date('Y-m-d', strtotime('+1 days'));?>" required>
                        </div>
                        <div class="col-md-3">
                            <select id="category_id" name="category_id" class="fsize" required="required"
                                onchange="getCategoryVal(this.value);checkCateWiseItem(this.value);"
                                style="width: 100%;  100%; height: 30px;">
                                <option value="">Select Category</option>
                                <?php
                                    foreach ($category as $val) {
                                        ?>
                                <option value="<?php echo $val->category_id; ?>"><?php echo $val->category_name; ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select id="sub_cat_id" name="sub_cat_id" class="fsize"
                                onchange="getOnCahangeSubCatVal(this.value);checkSubCateWiseItem(this.value);"
                                style="height: 30px;">
                                <option value="">Select Sub Category</option>
                                <?php
                                    foreach ($sub_cat as $val) {
                                        ?>
                                <option value="<?php echo $val->sub_cat_id; ?>"><?php echo $val->sub_cat_name; ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="sub_in_sub_id" name="sub_in_sub_id" class="fsize"
                                onchange="checkSubCateWiseItem(this.value);checkinSubCateWiseItem(this.value);"
                                style="height: 30px;">
                                <option value="">Select In Sub Category</option>
                                <?php
                                    foreach ($insub_cat as $val) {
                                        ?>
                                <option value="<?php echo $val->sub_in_sub_id; ?>">
                                    <?php echo $val->sub_in_sub_cat_name; ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div align="right" style="padding: 10px;">
                    <a href="#" onclick="printDiv('printableArea')"><i aria-hidden="true" class="fa fa-print"></i> Print</a>
                    <a href="#" onclick="exportTableToExcel('tblData')"><i aria-hidden="true" class="fa fa-file-excel-o"></i> Export</a>
                </div><br>
                <center>
                    <div class="loader" id="loader"></div>
                </center>
                
            <div id="printableArea">
                <div class="table-responsive">
                    <table class="table-striped table-hover" style="width: 100%; color:black;" id="tblData">
                        <thead>
                            <tr style="background-color: green;color: white; border-radius: 0 6px 0 0">
                                <th style="text-align: center;">SL</th>
                                <th style="text-align: center;">Product Code</th>
                                <th style="text-align: center;">Product Name</th>
                                <th style="text-align: center;">Opening Stock</th>
                                <th style="text-align: center;">Total Selling</th>
                                <th style="text-align: center;">Total Purchase</th>
                                <th style="text-align: center;">Qty In Hand</th>
                                <th style="text-align: center;">Value In Stock</th>
                                <th style="text-align: center;">Total Selling Price</th>
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

<!-- Modal -->

<script>
if (typeof $ == 'undefined') {
    var $ = jQuery;
}
//excel Output

function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

// Print
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
//sub_in_sub_id
function getOnCahangeSubCatVal(sub_cat_id) {
    $.ajax({
        type: "get",
        url: '{{URL::to("admin/get-in-sub-category")}}',
        data: {
            sub_cat_id: sub_cat_id,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(response) {
            $("#sub_in_sub_id").empty();
            $("#sub_in_sub_id").append('<option value="">Select inSub Category</option>');
            $.each(response, function(index, insubcategory) {
                $("#sub_in_sub_id").append('<option value="' + insubcategory.sub_in_sub_id + '">' +
                    insubcategory.sub_in_sub_cat_name + '</option>');
            });
        }
    });
}

function getCategoryVal(category_id) {
    $.ajax({
        type: "get",
        url: '{{URL::to("admin/get-sub-category")}}',
        data: {
            category_id: category_id,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(response) {
            $("#sub_cat_id").empty();
            $("#sub_cat_id").append('<option value="">Select Sub Category</option>');
            $.each(response, function(index, subcategory) {
                $("#sub_cat_id").append('<option value="' + subcategory.sub_cat_id + '">' +
                    subcategory.sub_cat_name + '</option>');
            });
        }
    });
}

function checkCateWiseItem(category_id) {

    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    $("#loader").show();
    $.ajax({
        type: "get",
        url: '{{URL::to("admin/findCateWiseItemMultiple")}}',
        data: {
            category_id: category_id,
            fromdate: fromdate,
            todate: todate,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(data) {
            $('#itemrev tbody tr').remove();
            $('tbody').html(data.table_data);
            $('#total_records').text(data.total_data);
            $("#loader").hide();
        }
    });
}

function checkSubCateWiseItem(sub_cat_id) {
    var category_id = $('#category_id').val();
    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    $("#loader").show();
    $.ajax({
        type: "get",
        url: '{{URL::to("admin/findSubCateWiseItemrpt")}}',
        data: {
            sub_cat_id: sub_cat_id,
            category_id: category_id,
            fromdate: fromdate,
            todate: todate,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(data) {
            $('#itemrev tbody tr').remove();
            $('tbody').html(data.table_data);
            $('#total_records').text(data.total_data);
            $("#loader").hide();
        }
    });
}

function checkinSubCateWiseItem(sub_in_sub_id) {
    var category_id = $('#category_id').val();
    var sub_cat_id = $('#sub_cat_id').val();
    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();

    $.ajax({
        type: "get",
        url: '{{URL::to("admin/findInSubCateWiseItemrpt")}}',
        data: {
            category_id: category_id,
            sub_cat_id: sub_cat_id,
            sub_in_sub_id: sub_in_sub_id,
            fromdate: fromdate,
            todate: todate,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(data) {
            $('#itemrev tbody tr').remove();
            $('tbody').html(data.table_data);
            $('#total_records').text(data.total_data);
        }
    });
}

function featch_list(query = '') {

    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    $("#loader").show();
    $(".table-responsive").hide();
    //console.log("test");
    $.ajax({
        url: '{{URL::to("admin/defaultitemreport")}}',
        method: 'GET',
        data: {
            fromdate: fromdate,
            todate: todate,
            query: query,
            _token: $('#token').val()
        },
        dataType: 'json',
        success: function(data) {
            $('tbody').html(data.table_data);
            $("#loader").hide();
            $(".table-responsive").show();
        }
    })
}
$(document).on('keyup', '#search', function() {
    var query = $(this).val();
    featch_list(query);

});
featch_list();

jQuery(document).ready(function($) {
    $("#fromdate").datepicker();
    $("#todate").datepicker();
});
</script>
@endsection