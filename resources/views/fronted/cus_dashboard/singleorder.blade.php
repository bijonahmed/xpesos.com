@extends('fronted.master')
<title>{{$title}}</title>
@section('maincontent')
<div class="modal fade-scale animate" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #193d5b;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <p class="modal-title" id="myModalLabel" style="font-size: 22px;">Update Information..</p>
            </div>
            <div class="modal-body">


                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Particular Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Change Password</a>
                    </li>

                </ul>


                <!-- Tab panes {{url('/update-customer-information')}}-->
                <div class="tab-content">

                    <div id="home" class="container tab-pane active">
                        <form method="POST" action="{{url('/update-customer-information')}}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="customername" class="col-sm-2 col-form-label"> Name</label>
                                <div class="col-sm-10">
                
                                    <input type="text" name="customer_name" class="form-control" id="customer_name"
                                        value="{{$data->customer_name}}" placeholder="Name">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{$data->email}}" placeholder="Email">
                                    <input type="hidden" class="form-control" id="customer_id" name="customer_id"
                                        value="{{$data->customer_id}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Mobile</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" name="mobile" id="mobile"
                                        value="{{$data->mobile}}" placeholder="Mobile">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="address">{{$data->address}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="customer_username"
                                        value="{{$data->customer_username}}" id="customer_username"
                                        placeholder="Username">
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-submit btn btn-block"><i
                                    class="fa fa-check-square-o"></i> Update
                            </button>

                        </form>


                    </div>
                    <div id="menu1" class="container tab-pane fade">
                        <form method="POST" action="{{url('/update-customer-pass')}}">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" id="customer_id" name="customer_id"
                                        value="{{$data->customer_id}}">
                                    <input type="password" class="form-control" value="{{$data->customer_password}}"
                                        placeholder="Password">
                                    <button type="submit" class="btn btn-primary btn-submit btn btn-block"><i
                                            class="fa fa-check-square-o"></i> Update
                                    </button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>


            </div>
        </div>

    </div>

</div>




<div class='container' style="background-color: white;">
    <div class='row'>
        <div class="main-container container">
            <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i></a></li>
                <li><a href="#">Order History</a></li>
            </ul>

            <div class="row">
                <!--Middle Part Start-->
                <div id="content" class="col-sm-9">
                    <div class="title">

                        <div class="alert alert-success">
                            <a href="{{url('/customer-panel')}}">Back</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td colspan="2" class="text-left">Order Details</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width: 50%;" class="text-left"> <b>Order ID:</b> {{ $singleorder->OrderId }}
								<br>
								<b>Order Date:</b> <?php echo date("d-m-Y",strtotime($singleorder->order_date))?></td>
							<td style="width: 50%;" class="text-left"> <b>Payment Method:</b> Cash On Delivery
								<br>
								<b>Shipping Method:</b> Courier Services </td>
						</tr>
					</tbody>
				</table>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td style="width: 100%; vertical-align: top;" class="text-left">Payment Address</td>
							
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-left">
                            {{ $singleorder->shipping_details }}
                                </td>
							
						</tr>
					</tbody>
				</table>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td class="text-left">Product Name</td>
                                <td class="text-left">Product Code</td>
								<td class="text-right">Quantity</td>
								<td class="text-right">Price</td>
								<td class="text-right">Total</td>
								
							</tr>
						</thead>
						<tbody>

                        <?php 
                        $product=  DB::table('tbl_product')->where('product_id', $singleorder->product_id)->where('status', 1)->get();
                        foreach($product as $item){
                        ?>
							<tr>
								<td class="text-left">{{$item->product_name}}</td>
                                <td class="text-left">{{$item->product_code}}</td>
								<td class="text-right">{{$singleorder->qty}}</td>
								<td class="text-right">{{$singleorder->price}}</td>
								<td class="text-right">{{$singleorder->price}}</td>
							
							
							</tr>
                            <?php  } ?>

						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"></td>
								<td class="text-right"><b>Sub-Total</b></td>
								<td class="text-right">{{ $singleorder->price }}</td>
								
							</tr>
							<!-- <tr>
								<td colspan="3"></td>
								<td class="text-right"><b>Flat Shipping Rate</b>
								</td>
								<td class="text-right">$5.00</td>
								<td></td>
							</tr> -->
						 
							<tr>
								<td colspan="3"></td>
								<td class="text-right"><b>Total</b></td>
								<td class="text-right">{{ $singleorder->price }}</td>
								
							</tr>
						</tfoot>
					</table>
				</div>
			
				<div class="buttons clearfix">
					<div class="pull-right"><a class="btn btn-primary" href="{{url('/customer-panel')}}">Continue</a>
					</div>
				</div>



                </div>
                <!--Middle Part End-->
                <!--Right Part Start -->
                <aside class="col-sm-3 hidden-xs" id="column-right">
                    <h2 class="subtitle">Account</h2>
                    <div class="list-group">
                        <ul class="list-item">
                            <?php if(!empty($customer_id = Session::get('customer_id'))){ ?>
                            <li><a href="{{url('/logoutCustomer')}}">Logout</a></li>
                            <?php }else{ ?>
                            <li><a href="register.html">Login</a>
                            </li>
                            <li><a href="register.html">Register</a> </li>
                            <?php } ?>

                            <!-- <li><a href="#">Forgotten Password</a></li> -->
                            <li><a href="#" onclick="UpdateAccount();">My Account</a></li>

                            <!-- <li><a href="#">Order History</a></li> -->

                        </ul>
                    </div>
                </aside>
                <!--Right Part End -->
            </div>
        </div>
    </div>
</div>
<script>
function UpdateAccount() {
    $('#myModal').modal('show');
}
</script>
@endsection