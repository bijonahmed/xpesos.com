<?php $__env->startSection('title','Customer Ledger'); ?>
<?php $__env->startSection('maincontent'); ?>
<?php echo $__env->make('admin.common.datepicker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="content-wrapper">
   <div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Customer Ledger</strong> List</span>
		</div>
	</div>
    <!--Start Dashboard Content-->
    <div class="card" style="padding: 10px;">
        <form enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <div class="col-md-3">
                    <input type="text" id="fromdate" autocomplete="off" name="fromdate" placeholder="From Date"
                        required>
                </div>
                <div class="col-md-3">
                    <input type="text" id="todate" name="todate" autocomplete="off" placeholder="To Date" required>
                </div>
                <div class="col-md-3">
                    <select id="customer_id" name="customer_id" style="width: 100%;" onchange="getCustomerInfo();">
                        <option value="">Select Customer</option>
                        <?php
                                    foreach ($customer as $val) {
                                    $name =  $val->customer_name ? ' ['. $val->customer_name.']' : "";
                                        ?>
                        <option value="<?php echo $val->customer_id; ?>"><?php echo $val->mobile. $name ; ?>
                        </option>
                        <?php
                                    }
                                    ?>
                    </select>
                </div>

            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="table-responsive">
                    <center><span id="totalsum"
                            style="font-size: 22px; font-weight: bold; text-align: center; color: green;"></span>
                    </center>
                    <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;"
                        id="itemlist">
                        <thead class="thead-primary">
                            <tr>
                                <!--	<td style="width: 5px;">S.L</td> -->
                                <td class="text-left">Order ID</td>
                                <td class="text-left">Order Date</td>
                                <td class="text-left">Customer Name</td>
                                <td class="text-left">Dv Charge</td>
                                <td class="text-left">Price</td>
                                <td class="text-left">Status</td>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div><!-- End Row-->
</div>

</div>
</div>


<script>
function getCustomerInfo() {

    var fdate = $("#fromdate").val();
    var tdate = $("#todate").val();
    var customer_id = $("#customer_id").val();

    if (fdate == "" || tdate == "") {
        alert("Please Select Date...");
        $("#customer_id").val("");
    }

    $('#itemlist tbody tr').remove();

    //sl = 1;
    var total = 0;
    $.ajax({
        //url: "<?php echo e(route('listByOrder.search')); ?>",
        url: "customerOrder?fdate=" + fdate + "&tdate=" + tdate + "&customer_id=" + customer_id,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            $.map(data, function(item) {
                total += Number(item.price); //totalsum+= item.price;
                if (item.status == 1) {
                    var sts = "<span style='color:green'>" + 'Received Order' + "</span>";
                } else if (item.status == 2) {
                    var sts = "<span style='color:red'>" + 'Confirm Order' + "</span>";
                } else if (item.status == 3) {
                    var sts = "<span style='color:blue'>" + 'Shipped Order' + "</span>";
                } else if (item.status == 4) {
                    var sts = "<span style='color:red'>" + 'Complete Order' + "</span>";
                } else if (item.status == 5) {
                    var sts = "<span style='color:red'>" + 'Cancel Order' + "</span>";
                } else if (item.status == 6) {
                    var sts = "<span style='color:#8600b3'>" + 'Hold Order' + "</span>";
                } else if (item.status == 7) {
                    var sts = "<span style='color:red'>" + 'Return Order' + "</span>";
                }
                var id = "item_list_" + item.order_id;
                var html = "<tr id='" + id + "'>";
                html += "<td>" + item.OrderId + "</td>";
                html += "<td>" + item.order_date + "</td>";
                html += "<td>" + item.customer_name + "</td>";
                html += "<td>" + item.dvcharge + "</td>";
                html += "<td>" + item.price + "</td>";
                html += "<td>" + sts + "</td>";
                html += "</tr>";
                if ($('#' + id).length < 1) {
                    $('#itemlist tbody').append(html);
                    // sl++;
                }
            });

            if (total > 0) {
                $('#totalsum').html("Customer Total Transection: " + total + " ৳.");
            } else {
                $('#totalsum').html("");
            }
        }
    })
}

//date
$.noConflict();
jQuery(document).ready(function($) {
    $("#fromdate").datepicker();
    $("#todate").datepicker();
    $("#status").val();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/admin/pages/customer/customerledger.blade.php ENDPATH**/ ?>