@extends('fronted.master')
@section('title','Customer Panel')
@section('maincontent')

<div class="container">

    <div class="row" style="margin: 30px 0px;">
        <div class="col-md-3">
            <ul class="list-group">
                @include('fronted.cus_dashboard.sidebar')
            </ul>
        </div>
        <div class="col-md-9">
            <p>Hello (<?php echo Session::get('customer_username'); ?> <a href="{{ url('/logoutCustomer') }}" style="color: blue;">Log out</a>)</p>

            <p>From your account dashboard you can view your <a href="{{ url('/customer-order-list') }}" style="color: blue;">recent orders</a>,
                <!-- manage your <a href="#" style="color: blue;">shipping and billing addresses</a>, -->
                and <a href="{{ url('/edit-customer-account') }}" style="color: blue;">edit your password and account details</a>.</p>
            <p><a href="registration.php" style="color: blue;">Become a Vendor</a></p>
        </div>
    </div>
</div>

@endsection