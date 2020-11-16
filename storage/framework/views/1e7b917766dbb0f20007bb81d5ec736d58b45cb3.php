    <?php $__env->startSection('title',$title); ?>
    <?php $__env->startSection('maincontent'); ?>
<style>
.ps-form--account {
	max-width: 430px;
	margin: 0 auto;
	padding-top: 5px;
}
.ps-footer {
    padding-top: 15px;
}
.ps-my-account {
    min-height: 60vh;
    background-color: #f1f1f1;
}
</style>
<div class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li>My account (User)</li>
                </ul>
            </div>
        </div>
        <div class="ps-my-account">
            <div class="container">
                <div class="ps-form--account ps-tab-root">
                    <ul class="ps-tab-list">
                        <li class="active"><a href="#sign-in">Login</a></li>
                        <li><a href="#register">Register</a></li>
                    </ul>
                    <div class="ps-tabs">
                        <div class="ps-tab active" id="sign-in">
                        <div style="color:green; text-align: center; font-szie: 25px;"><?php
                                $messages = Session::get('registration_message');
                                if (!empty($messages)) {
                                    echo $messages;
                                    session::put('registration_message', null);
                                }
                                ?></div>
                            <form action="<?php echo e(url('/check-login-customer')); ?>" method="POST">
                            <?php echo e(csrf_field()); ?>

                            <div class="ps-form__content">
                                <h5>Log In Your Account (User)</h5>
                                <div style="color:red; text-align: center; font-szie: 25px;"><?php
                                $messages = Session::get('messages');
                                if (!empty($messages)) {
                                    echo $messages;
                                    session::put('messages', null);
                                }
                                ?></div>
                                <div class="form-group">
                                    <input class="form-control" type="text"name="customer_username" placeholder="Username" required>
                                </div>
                                <div class="form-group form-forgot">
                                    <input class="form-control" type="text" name="customer_password" required placeholder="Password"><a href="#">Forgot?</a>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox" id="remember-me" name="remember-me">
                                        <label for="remember-me">Rememeber me</label>
                                    </div>
                                </div>
                                <div class="form-group submtit">
                                    <button class="ps-btn ps-btn--fullwidth">Login</button>
                                </div>
                                <br>
                            </div>
                            </form>
                           
                        </div>
                        <div class="ps-tab" id="register">
                     

                        <form id="upload_form" method="post" action="<?php echo e(url('/save-cus-registration')); ?>">
                        <?php echo e(csrf_field()); ?>

                            <div class="ps-form__content">
                                <h5>Register An Account (Customer)</h5>
                                <div class="form-group">
                                    <input class="form-control" name="customer_name" id="customer_name" required type="text" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="email" id="email" type="email" required placeholder="E-Mail" onchange="checkEmail(this.value);">
                                    <div id="errormessageemail" style="text-aling: center; font-size: 18px; color: red;"></div>
                                    
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="mobile" id="mobile" required placeholder="Mobile" onchange="checkMobile(this.value);">
                                    
                                    <div id="errormessagemobile" style="text-aling: center; font-size: 18px; color: red;"></div>

                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Address" required name="address" id="address">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="customer_username" required id="customer_username" placeholder="Username"
                                class="form-control" onchange="checkUserName(this.value);">
                                <div id="errormessage" style="text-aling: center; font-size: 18px; color: red;"></div>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="password" placeholder="Password" required name="customer_password" id="customer_password">
                                </div>
                                <div class="form-group submtit">
                                    <button class="ps-btn ps-btn--fullwidth" id="continuebtn" type="submit">Registration</button>
                                    <br>
                                </div>
                            </div>
                            </form>
                           <br>
                        </div>
                    </div>
                    <br> <br>
               </div>
            </div>
        </div>
    </div>
    <br>
    <div class="modal" tabindex="-1" role="dialog" id="message">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <p style="font-size: 22px; font-weight: bold; text-align: center;">Thanks, Successfully Registration Complete.</p>
                </div>

            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="error">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <p style="font-size: 22px; font-weight: bold; color:red; text-align: center;">Please fillup blank
                        filed.</p>
                </div>

            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('fronted/plugins/jquery-1.12.4.min.js')); ?>"></script>

    <script>
    function checkUserName(username) {
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/checkuserName/" + username,
            data: {
                "username": username,
                "_token": _token,
            },
            success: function(result) {
                
				if (result == 'yes') {
                    $("#continuebtn").hide();
                    $("#errormessage").text("Sorry already username exits.");
                    $("#customer_username").focus();
                }
                if (result == 'no') {
                    $("#errormessage").text("");
                    $("#continuebtn").show();
                }

            }
        });

    }

    function checkEmail(email){
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/checkemailId/" + email,
            data: {
                "email": email,
                "_token": _token,
            },
            success: function(result) {
                
				if (result == 'yes') {
                    $("#continuebtn").hide();
                    $("#errormessageemail").text("Sorry already email Id exits.");
                    $("#email").focus();
                }
                if (result == 'no') {
                    $("#errormessageemail").text("");
                    $("#continuebtn").show();
                }

            }
        });
    }

    function checkMobile(mobile){
        var _token = $("input[name='_token']").val();
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "user/checkMobileNumber/" + mobile,
            data: {
                "email": mobile,
                "_token": _token,
            },
            success: function(result) {
                
				if (result == 'yes') {
                    $("#continuebtn").hide();
                    $("#errormessagemobile").text("Sorry already mobile number exits.");
                    $("#mobile").focus();
                }
                if (result == 'no') {
                    $("#errormessagemobile").text("");
                    $("#continuebtn").show();
                }

            }
        });

    }
    </script>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('fronted.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/pages/customer_registration.blade.php ENDPATH**/ ?>