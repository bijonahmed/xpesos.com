@extends('fronted.master')
<title>{{$title}}</title>
@section('maincontent')
<div class="main-container container" style="background-color: white;">
    <ul class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i></a></li>
        <li><a href="#">{{$title}}</a></li>
    </ul>


    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="page-login">
                <div style="color:red; text-align: center; font-szie: 25px;"><?php
                                $messages = Session::get('messages');
                                if (!empty($messages)) {
                                    echo $messages;
                                    session::put('messages', null);
                                }
                                ?></div>
                <div class="account-border">
                    <div class="row">

                        <form action="{{url('/check-login-customer-by-Mobile')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-sm-12 customer-login">
                                <div class="well">
                                    <h2><i class="fa fa-file-text-o" aria-hidden="true"></i> Customer Login by Mobile</h2>

                                    <div class="form-group">
                                        <label class="control-label " for="input-email">Mobile Number</label>
                                        <input type="text" name="mobile" id="mobile" onkeyup="getLogin(this.value);"
                                            class="form-control" required autofocus />
                                    </div>
                                    <div class="form-group" style="display:none;">
                                        <label class="control-label " for="input-password">Password</label>
                                        <input type="password" name="customer_password" id="customer_password"
                                            class="form-control" required />
                                    </div>
                                </div>
                                <div class="bottom-form">
                                    <!-- <a href="#" class="forgot">Forgotten Password</a> -->
                                    <input type="submit" value="Login" class="btn btn-default pull-right" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    function getLogin(mobile) {
        console.log(mobile);
        $("#customer_password").val(mobile);
    }
    </script>
    @endsection