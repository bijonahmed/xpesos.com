@extends('fronted.master')
@section('title','Login')
@section('maincontent')

<div class='container'>
    <div class='row'>

        @include('fronted.common.leftsidebar')

        <div class='col-md-9'>

            <div class="body-content">

                <div class="sign-in-page">
                    <div class="row">
                        <!-- Sign-in -->
                        <div class="col-md-12 col-sm-12 sign-in">
                            <h4 class="">Sign in</h4>
                            <div style="color:green; text-align: center; font-size: 18px; font-weight: bold;"><?php
                                $messages = Session::get('messages');
                                if (!empty($messages)) {
                                    echo $messages;
                                    session::put('messages', null);
                                }
                                ?></div>

                            <form class="register-form outer-top-xs" method="post" role="form"
                                  action="{{url('/dr-login')}}">
                              {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Username
                                        <span>*</span></label>
                                    <input type="text" class="form-control form-control text-input" required
                                           id="username" name="username" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputPassword1">Password
                                        <span>*</span></label>
                                    <input type="password" class="form-control form-control text-input"
                                           id="password" name="password" required autocomplete="off">
                                </div>
                                <!--   <div class="radio outer-xs">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Remember me!
                                        </label>
                                        <a href="#" class="forgot-password pull-right">Forgot your Password?</a>
                                    </div>-->
                                <button type="submit"
                                        class="btn-upper btn btn-primary checkout-page-button btn-block">Login</button>
                                <a href="{{url('/registration')}}"
                                   class="forgot-password pull-right">Registration</a>
                            </form>
                        </div>

                    </div><!-- /.row -->
                </div><!-- /.sigin-in-->

            </div><!-- /.body-content -->

        </div>
        @endsection