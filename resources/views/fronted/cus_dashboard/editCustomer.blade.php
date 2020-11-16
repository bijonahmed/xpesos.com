@extends('fronted.master')
@section('title',$title)
@section('maincontent')
<style>
    .frm {
        margin-bottom: 7px;
        font-family: 'Work Sans', Arial, sans-serif;
    }

    .mrgin {
        margin-bottom: 6px;
    }

    .fnt {
        color: red;
        font-weight: 700;
    }
</style>
<div class="container">

    <div class="row" style="margin: 30px 0px;">
        <div class="col-md-3">
            <ul class="list-group">
                @include('fronted.cus_dashboard.sidebar')
            </ul>
        </div>
        <div class="col-md-9">

            <form method="POST" action="{{url('/update-customer-information')}}">
                {{ csrf_field() }}

                <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{$row->customer_id}}">
                <div class="form-group mrgin">
                    <label class="frm">Name<sup class="fnt">*</sup>
                    </label>
                    <div class="form-group__content">
                        <input class="form-control" type="text" name="customer_name" id="customer_name" value="{{$row->customer_name}}">
                    </div>
                </div>

                <div class="form-group mrgin">
                    <label class="frm">Email address<sup class="fnt">*</sup>
                    </label>
                    <div class="form-group__content">
                        <input class="form-control" type="text" name="email" id="email" value="{{$row->email}}">
                    </div>
                </div>

                <div class="form-group mrgin">
                    <label class="frm">Address<sup class="fnt">*</sup>
                    </label>
                    <div class="form-group__content">
                        <textarea class="form-control" name="address" id="address">{{$row->address}}</textarea>
                    </div>
                </div>


                <div class="form-group submtit">
                    <button class="ps-btn ps-btn" type="submit">Save changes</button>
                </div>

            </form>
            <form method="POST" id="testForm" action="{{url('/update-customer-pass')}}">
                {{ csrf_field() }}
                <h3>Password change</h3>

                <?php
                $messages = Session::get('msg');
                if (!empty($messages)) {
                    echo $messages;
                    session::put('msg', null);
                }
                ?>
                <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{$row->customer_id}}">
                <div class="form-group" style="margin-bottom: 6px;">
                    <label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;"><sup style="color: red; font-weight: 700;">*</sup>New password (leave blank to leave unchanged)
                    </label>
                    <div class="form-group__content">
                        <input class="form-control" type="text" name="customer_password" id="customer_password" required="required">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 6px;">
                    <label style="margin-bottom: 7px; font-family: 'Work Sans', Arial, sans-serif;"><sup style="color: red; font-weight: 700;">*</sup>
                        Confirm new password
                    </label>
                    <div class="form-group__content">
                        <input class="form-control" type="text" name="confirm_password" id="confirm_password" required="required">
                    </div>
                </div>
                <div class="form-group submtit">
                    <button class="ps-btn ps-btn" type="submit">Save changes</button>
                </div>

            </form>
        </div>

    </div>
</div>
<script>
    $("form").submit(function(e) {
        e.preventDefault();
        alert("test");
        //or
        //return false;
    });
</script>
@endsection