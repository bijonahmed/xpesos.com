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
                                    <i class="fa fa-plus"></i> Salary</a>
                                <input type="text" name="searchdata" id="searchdata" placeholder="Search" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                                <thead>
                                    <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0;">
                                        <th>SL</th>
                                        <th>Employee Name</th>
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
                    <h5 class="modal-title text-white"><i class="fa fa-star"></i> Salary</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="form-group">
                <input type="hidden" id="salary_id" name="salary_id">
						<label for="Xlarge-input" class="col-form-label">Select Employee</label>
						<select id="employeeid" name="employeeid" style="width: 100%;" onchange="getEmployeeId(this.value)">
							<option value="">Select Employee</option>
							<?php
                                    foreach ($employee as $val) {
                                    $name =  $val->employeename ? ' ['. $val->employeename.']' : "";
                                        ?>
							<option value="<?php echo $val->employeeid; ?>"><?php echo $name ; ?>
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
                        <input type="text" id="chaqueno" autocomplete="off" name="chaque_no" placeholder="Chaque No"
                            required style="width: 100%;">
                        
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

function getEmployeeId(employeeid){
    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "employee-salary-row/" + employeeid,
        data: {
            "employeeid": employeeid,
            "_token": _token,
        },
        success: function(data) {
         $("#amount").val(data.amount);
        }
    });

}

// ajax post
$(".btn-submit").click(function(e) {
    e.preventDefault();
    var _token = $("input[name='_token']").val();
    var employeeid = $("select[name=employeeid]").val();
    var payment_type = $("select[name=payment_type]").val();
    var payment_date = $("input[name=payment_date]").val();
    var bank_id = $("select[name=bank_id]").val();
    var chaque_no = $("input[name=chaque_no]").val();
    var amount = $("input[name=amount]").val();
    var reamrks = $("#reamrks").val();
    var salary_id = $("input[name=salary_id]").val();
    var status = $("select[name=status]").val();

    if (employeeid == '') {
        alert("Please insert blank filed.");
        $("#employeeid").focus();
        return false;
    }
    $.ajax({
        type: 'POST',
        url: "save-Salary",
        dataType: "json",
        data: {
            _token: _token,
            employeeid: employeeid,
            payment_type: payment_type,
            payment_date: payment_date,
            bank_id: bank_id,
            chaque_no: chaque_no,
            amount: amount,
            reamrks: reamrks,
            salary_id: salary_id,
            status: status
        },
        success: function(data) {
            $("#bijonform")[0].reset();
            featch_list();
            alert("Successfully Save");
             $('#modal-animation-3').modal('hide');
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
function getbyId(salary_id) {

    var _token = $("input[name='_token']").val();
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: "find-salary-row/" + salary_id,
        data: {
            "salary_id": salary_id,
            "_token": _token,
        },
        success: function(data) {
        console.log(data);
            if(data.payment_type=="Bank"){
                $("#bank_area").show();
                $("#chaque_no").show();

            }else{
                $("#bank_area").hide();
                $("#chaque_no").hide();
            }

            $("#amount").val(data.amount);
            $("#bank_id").val(data.bank_id);
            $("#chaqueno").val(data.chaque_no);
            $("#employeeid").val(data.employeeid);
            $("#payment_date").val(data.payment_date);
            $("#payment_type").val(data.payment_type);
            $("#reamrks").val(data.reamrks);
            $("#status").val(data.status);
            $("#salary_id").val(data.salary_id);
           $('#modal-animation-3').modal('show');
        }
    });
}

function featch_list(query = '') {
    $.ajax({
        url: "{{ route('listBysalary.search') }}",
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