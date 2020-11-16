@extends('fronted.master')
@section('title',$title)
@section('maincontent')
<style>
    .form-group {
        margin-bottom: 1rem;
    }

    textarea.form-control {
        height: auto;
        padding: 1rem;
        resize: none;
    }
</style>
<div class="ps-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">Sell on Xpesos</a></li>
            <li>Seller Registration</li>
        </ul>
    </div>
</div>
<form id="form" method="post" action="{{url('/save-seller-registration')}}">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ps-tab active" id="register">
                    <div class="ps-form__content fps-form__content-new">
                        <h2 class="register-h2">Register An Account</h2>
                        <div style="color:green; text-align: center; font-szie: 25px;"><?php
                                                                                        $messages = Session::get('registration_message');
                                                                                        if (!empty($messages)) {
                                                                                            echo $messages;
                                                                                            session::put('registration_message', null);
                                                                                        }
                                                                                        ?></div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">User Name <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" placeholder="User Name" autocomplete="off" required onchange="checkUserName(this.value);">
                                <span id="errormessage" style="color: red; font-weight: bold; font-size: 20px;"></span>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="Email" class="form-control" placeholder="Email" name="email" autocomplete="off" required onchange="checkEmail(this.value);">
                                <span id="errormessageemail" style="color: red; font-weight: bold; font-size: 20px;"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">&nbsp;</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" placeholder="Verification Code" name="verificationCode" required="required">
                            </div>
                            <div class="col-sm-3">
                                <button class="ps-btn ps-btn--fullwidth ps-btn-resendcde">RE-SEND CODE</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">First Name </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="f_name" required placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Last Name </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="l_name" required placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Store Name <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required name="company" id="company" onchange="" placeholder="Store Name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)">
                                <input type="hidden" name="company_slug" id="slug">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Address <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" name="address" placeholder="Address"></textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Country <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <Select class="form-control" name="country">
                                    <option>-Select a location-</option>
                                    <option>Country 2</option>
                                </Select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">City/Town</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="city_town" placeholder="City/Town">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">State/County</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="state_country" placeholder="State/County">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Postcode/Zip <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="postCodeZip" placeholder="Postcode/Zip">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Store Phone <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required name="storePhone" placeholder="Store Phone" onchange="checkMobile(this.value);">
                                <span id="errormessagemobile" style="color: red; font-weight: bold; font-size: 20px;"></span>


                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" required name="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Password <span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                        </div>


                        <div class="form-group submtit">
                            <button class="ps-btn ps-btn--fullwidth ps-btn-regis" type="submit" id="submitbtn">Login</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>
<script src="{{url('fronted/plugins/jquery-1.12.4.min.js')}}"></script>
<script>
    function convertToSlug(str) {
        //replace all special characters | symbols with a space
        str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
        // trim spaces at start and end of string
        str = str.replace(/^\s+|\s+$/gm, '');
        // replace space with dash/hyphen
        str = str.replace(/\s+/g, '-');
        $("#slug").val(str);
        //return str;
    }


    function checkUserName(username) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/checkSelleruserName/" + username,
            data: {
                "username": username,
                "_token": _token,
            },
            success: function(result) {

                if (result == 'yes') {
                    $("#submitbtn").hide();
                    $("#errormessage").text("Sorry already username exits.");
                    $("#customer_username").focus();
                }
                if (result == 'no') {
                    $("#errormessage").text("");
                    $("#submitbtn").show();
                }

            }
        });

    }

    function checkEmail(email) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/checkSelleremailId/" + email,
            data: {
                "email": email,
                "_token": _token,
            },
            success: function(result) {

                if (result == 'yes') {
                    $("#submitbtn").hide();
                    $("#errormessageemail").text("Sorry already email Id exits.");
                    $("#email").focus();
                }
                if (result == 'no') {
                    $("#errormessageemail").text("");
                    $("#submitbtn").show();
                }

            }
        });
    }

    function checkMobile(mobile) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/checkSellerMobileNumber/" + mobile,
            data: {
                "email": mobile,
                "_token": _token,
            },
            success: function(result) {

                if (result == 'yes') {
                    $("#submitbtn").hide();
                    $("#errormessagemobile").text("Sorry already mobile number exits.");
                    $("#mobile").focus();
                }
                if (result == 'no') {
                    $("#errormessagemobile").text("");
                    $("#submitbtn").show();
                }

            }
        });

    }
</script>
@endsection