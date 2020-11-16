@extends('admin.master')
@section('title','Vendor Invoice List')
@section('maincontent')
<script src="{{url('admin/assets/js/jquery.min.js')}}"></script>
<style>
    .modal-lg {
        max-width: 90% !important;
    }
</style>
<div class="content-wrapper">
  <div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Vendor Invoice</strong> List</span>
		</div>
	</div>
    <!--Start Dashboard Content-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="padding: 10px;">
                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group" style="text-align: right;">
                            <a href="#" data-toggle="modal" data-target="#modal-animation-3" onclick="emptyfrm();">
                                <i class="fa fa-plus"></i> Create a New Invoice </a>
                            <input type="text" name="searchproduct" id="searchproduct" placeholder="Search" />
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">
                        <thead>
                            <tr style="background-color: #223035;color: white; border-radius: 0 6px 0 0">
                                <th>SL</th>
                                <th>Vendor Invoice ID</th>
                                <th>Vendor Name</th>
                                <th>Created Date</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Print</th>
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
<div class="modal fade" id="modal-animation-3">
    <!--<form id="cform" enctype="multipart/form-data" action="{{url('/admin/SaveProduct')}}" method="post">-->
    <form id="cform">
        {{ csrf_field() }}
        <div class="modal-dialog modal-sm ">
            <div class="modal-content animated">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa fa-check"></i> Vendor</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-md-11">
                                    <label for="Xlarge-input" class="col-form-label">Select your Vendor</label>
                                    <select id="supplier_id" name="supplier_id" required="required" onchange="getSupplierInvoice(this.value);" style="width: 100%;">
                                        <option value="">Select Category</option>
                                        <?php
                                        foreach ($customer as $val) {
                                            ?>
                                            <option value="<?php echo $val->supplier_id; ?>"><?php echo $val->supplier_name; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fa fa-times"></i>
                                    Close</button>
                            <!--<button type="submit" id="signup" class="btn btn-primary btn-submit"><i class="fa fa-check-square-o"></i> Save
                            </button>-->
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- Modal -->
<script>
    function emptyfrm() {
        $("#cform")[0].reset();
    }

    function getbyIdPrint(supplier_invoice_id) {

        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "supplier/searchSupplierInvoice/" + supplier_invoice_id,
            data: {
                "supplier_invoice_id": supplier_invoice_id,
                "_token": _token,
            },
            success: function (data) {
//            $("#supplier_id").val(data.supplier_id);
//            $("#supplier_name").val(data.supplier_name);
//            $("#supplier_contact_person_name").val(data.supplier_contact_person_name);
//            $("#supplier_email").val(data.supplier_email);
//            $("#supplier_phone").val(data.supplier_phone);
//            $("#supplier_address").val(data.supplier_address);
//            $("#reamrks").val(data.reamrks);
//            $("#status").val(data.status);
//            $('#modal-animation-3').modal();
            }
        });


    }
// ajax post
    function getSupplierInvoice(supplier_id) {
        //alert(supplier_id);
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "supplier/searhSupplierId/" + supplier_id,
            data: {
                "supplier_id": supplier_id,
                "_token": _token,
            },
            success: function (data) {
                //console.log(data.supplier_name);
                window.location.href = "supplier/supplier-invoice/" + data.supplier_id;
            }
        });

    }

// Edit
    function getbyId(supplier_invoice_id) {
        window.location.href = "supplier/editSupplierInvoice/" + supplier_invoice_id;
               // var _token = $("input[name='_token']").val();
//        $.ajax({
//            type: 'GET',
//            dataType: "json",
//            url: "supplier/editSupplierInvoice/" + supplier_invoice_id,
//            data: {
//                "supplier_invoice_id": supplier_invoice_id,
//                "_token": _token,
//            },
//            success: function (data) {
//               console.log(data);
//             //   alert("test");
//            }
//        });

    }
    function featch_list(query = '') {
        //	console.log("test");
        $.ajax({
            url: "{{ route('supplierlistinvlicelist.search') }}",
            method: 'GET',
            data: {
                query: query
            },
            dataType: 'json',
            success: function (data) {
                $('tbody').html(data.table_data);
                $('#total_records').text(data.total_data);
            }
        })
    }
    $(document).on('keyup', '#searchproduct', function () {
        var query = $(this).val();
        featch_list(query);
    });
    featch_list();
    </script>
                @endsection