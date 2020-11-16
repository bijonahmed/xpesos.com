@extends('fronted.master')
@section('title','Contact us')
@section('maincontent')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="main-container container" style="background-color: white;">
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="mapouter">
                <div class="gmap_canvas"><iframe width="1400" height="350" id="gmap_canvas" src="https://maps.google.com/maps?q=%20Kallyenpur%2C%20Mirpur%20Road%2C%20Dhaka%2C%20Bangladesh&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/elementor-review/"></a></div>
                <style>
                    .mapouter {
                        position: relative;
                        text-align: right;
                        height: 350px;
                        width: 1080px;
                    }

                    .gmap_canvas {
                        overflow: hidden;
                        background: none !important;
                        height: 350px;
                        width: 1220px;
                    }
                </style>
            </div>
            <div class="info-contact clearfix">
                <div class="col-lg-4 col-sm-4 col-xs-12 info-store">
                    <div class="row">
                        <div class="name-store">
                            <h3>My Shop </h3>
                        </div>
                        <address>
                            <div class="address clearfix form-group">
                                <div class="icon">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="text">{{$data->name}}</div>
                            </div>
                            <div class="phone form-group">

                                <div class="text">Phone : {{$data->tel}}</div>
                            </div>
                            <div class="phone form-group">

                                <div class="text">Hotline : {{$data->hotline}}</div>
                            </div>
                            <div class="phone form-group">

                                <div class="text">Email : {{$data->email}}</div>
                            </div>
                            <div class="phone form-group">

                                <div class="text">Address : {{$data->address}}</div>
                            </div>
                        </address>
                    </div>
                </div>
                <div style="color:green; text-align: center; font-size: 18px; font-weight: bold;"><?php
                                                                                                    $messages = Session::get('contactmsg');
                                                                                                    if (!empty($messages)) {
                                                                                                        echo $messages;
                                                                                                        session::put('contactmsg', null);
                                                                                                    }
                                                                                                    ?></div>
                <div class="col-lg-8 col-sm-8 col-xs-12 contact-form">
                    <form class="form-horizontal" id="cform">
                        {{ csrf_field() }}
                        <fieldset>
                            <span id="sendmessage"></span>
                            <legend>Contact Form</legend>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-name">Your Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="contact_name" value="" id="contact_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">E-Mail Address</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" value="" id="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">Subject</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" value="" id="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-enquiry">Enquiry</label>
                                <div class="col-sm-10">
                                    <textarea name="msg" rows="10" id="msg" class="form-control"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="buttons">
                            <div class="pull-right">
                                <button class="btn btn-default buttonGray btn-block" type="button" onclick="sendContactg();">
                                    <span>Submit</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset(url('fronted/assets/js/jquery-1.11.1.min.js'))}}"></script>
<script>
    function sendContactg() {
        var _token = $("input[name='_token']").val();
        var contact_name = $("input[name=contact_name]").val();
        var email = $("input[name=email]").val();
        var title = $("input[name=title]").val();
        var msg = $("#msg").val();
        if (contact_name == '') {
            alert("Please enter name");
        } else {
            $.ajax({
                type: 'POST',
                url: "savecontactmessages",
                dataType: "json",
                data: {
                    _token: _token,
                    contact_name: contact_name,
                    email: email,
                    title: title,
                    msg: msg
                },
                success: function(data) {

                    //alert(data);
                    $("#sendmessage").text("Successfully send your query");
                    $("#cform")[0].reset();
                    //  window.location.href = "/contact-us";
                }
            });
        }
    }
</script>
@endsection