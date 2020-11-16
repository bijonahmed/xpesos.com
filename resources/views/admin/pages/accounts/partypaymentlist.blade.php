@extends('admin.master')
@section('title',$title)
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="content-wrapper">
<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>{{$title}}</strong></span>
		</div>
	</div>
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="padding: 20px;">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" style="text-align: right; padding: 1px;">

                                <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();">
                                    <i class="fa fa-plus"></i> Party Payment </a>
                                <input type="text" name="searchdata" id="searchdata" placeholder="Search" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                                <thead>
                                    <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                        <th>SL</th>
                                        <th>Party Name</th>
                                        <th>Payment Date </th>
										<th>Payment Type </th>
                                        <th>Amount </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="tbodys">
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
<div class="modal fade" id="modal-animation-3">
    <form id="bijonform">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg ">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Party Payment</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Select Vendor</label>
                        <!--<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">-->
                        <select id="supplier_id" name="supplier_id" style="width: 100%;">
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

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Payment Type</label>
                        <!--<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">-->
                        <select style="width: 100%;" name="payment_type" id="payment_type"
                            onchange="PaymentMode(this.value);">
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Payment Date</label>
                        <input type="text" id="payment_date" autocomplete="off" name="payment_date"
                            placeholder="From Date" required style="width: 100%;">

                    </div>

                    <div class="form-group" style="display: none;" id="bank_area">
                        <label for="Xlarge-input" class="col-form-label">Select Bank</label>
                        <!--<input type="text" id="slug" name="slug" placeholder="Slug" required style="width: 100%;">-->
                        <select id="bank_id" name="bank_id" style="width: 100%;">
                            <option value="">Select Bank</option>
                            <?php
                                    foreach ($bank as $val) {
                                    $name =  $val->bank_name ? ' ['. $val->bank_name.']' : "";
                                        ?>
                            <option value="<?php echo $val->bank_id; ?>"><?php echo $name ; ?>
                            </option>
                            <?php
                                    }
                                    ?>
                        </select>
                    </div>



                    <div class="form-group" style="display: none;" id="chaque_no">
                        <label for="Xlarge-input" class="col-form-label">Chaque No</label>
                        <input type="text" id="ch_no" autocomplete="off" name="chaque_no" placeholder="Chaque No"
                            required style="width: 100%;">
                        <input type="hidden" id="party_payment_id" name="party_payment_id">
                    </div>

                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Amount</label>
                        <input type="text" id="amount" name="amount" placeholder="Amount" required style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label for="Xlarge-input" class="col-form-label">Description</label>
                        <textarea id="reamrks" name="reamrks" style="width: 100%;"></textarea>

                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="large-input" class="col-form-label">Status</label>

                        <select id="status" name="status" style="width: 100%;">
                            <option value='1'>Active</option>
                            <option value='0'>Inactive</option>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <div id="showmsg" style="text-align: center;"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

<script>
// ajax post
$(".btn-submit").click(function(e) {
    e.preventDefault();
    var _token = $("input[name='_token']").val();
    var supplier_id = $("select[name=supplier_id]").val();
    var payment_type = $("select[name=payment_type]").val();
    var payment_date = $("input[name=payment_date]").val();
    var bank_id = $("select[name=bank_id]").val();
    var chaque_no = $("input[name=chaque_no]").val();
    var amount = $("input[name=amount]").val();
    var reamrks = $("#reamrks").val();
    var party_payment_id = $("input[name=party_payment_id]").val();
    var status = $("select[name=status]").val();

    if (supplier_id == '') {
        alert("Please insert blank filed.");
        $("#supplier_id").focus();
        return false;
    }
    $.ajax({
        type: 'POST',
        url: "save-party-payment",
        dataType: "json",
        data: {
            _token: _token,
            supplier_id: supplier_id,
            payment_type: payment_type,
            payment_date: payment_date,
            bank_id: bank_id,
            chaque_no: chaque_no,
            amount: amount,
            reamrks: reamrks,
            party_payment_id: party_payment_id,
            status: status
        },
        success: function(data) {
            $("#bijonform")[0].reset();
            featch_list();
        }
    });
});


function PaymentMode(val) {
    //alert(val);
    if (val == "Bank") {
        $("#bank_area").show();
        $("#chaque_no").show();
    } else {
        $("#bank_area").hide();
        $("#chaque_no").hide();
    }
}

jQuery(document).ready(function($) {
    $("#payment_date").datepicker();

});

function emptyfrm() {
    $("#bijonform")[0].reset()
}
// ajax post
function getbyId(party_payment_id) {

    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "edit-party-paymentt/" + party_payment_id,
        data: {
            "party_payment_id": party_payment_id,
            "_token": _token,
        },
        success: function(data) {
            //console.log(data);
            if(data.payment_type=="Bank"){
                $("#bank_area").show();
                $("#chaque_no").show();

            }else{
                $("#bank_area").hide();
                $("#chaque_no").hide();
            }

            $("#amount").val(data.amount);
            $("#bank_id").val(data.bank_id);
            $("#ch_no").val(data.chaque_no);
            $("#party_payment_id").val(data.party_payment_id);
            $("#payment_date").val(data.payment_date);
            $("#payment_type").val(data.payment_type);
            $("#reamrks").val(data.reamrks);
            $("#status").val(data.status);
            $("#supplier_id").val(data.supplier_id);
           $('#modal-animation-3').modal('show');
        }
    });
}

function featch_list(query = '') {
    $.ajax({
        url: "{{ route('listByPartyPayment.search') }}",
        method: 'GET',
        data: {
            query: query
        },
        dataType: 'json',
        success: function(data) {
            $('.tbodys').html(data.table_data);
            $('#total_records').text("Total Data:" + data.total_data);
        }
    })
}
$(document).on('keyup', '#searchdata', function() {
    var query = $(this).val();
    featch_list(query);
});
featch_list();
</script>
@endsection
