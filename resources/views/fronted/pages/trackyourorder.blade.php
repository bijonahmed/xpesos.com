@extends('fronted.master')
@section('title',$title)
@section('maincontent')

<div class="ps-my-account">
    <div class="container">
        <form class="ps-form--account ps-tab-root" action="http://nouthemes.net/html/martfury/link.html" method="get" style="max-width: 1230px;">

            <div class="ps-tabs" style="padding-top: 10px;">
                <div class="ps-tab active" id="sign-in" style="border-radius: 10px;">
                    <div class="ps-form__content" style="text-align: center; font-size: 16px;">
                        <ul class="ps-tab-list">
                            <li>To track your order please enter your Order ID in the box below and press the "Track" button.<br> This was given to you on your receipt and in the confirmation email you should have received.</li>
                        </ul>
                        <h5>Order ID</h5>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Found in your order confirmation email." style="margin-left: 25%; width: 50%;">
                        </div>
                        <h5>Billing email</h5>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Email you used during cheakout." style="margin-left: 25%; width: 50%;">
                        </div>
                        <div class="form-group submtit" style="margin-bottom: 0rem;  padding-bottom: 10px;">
                            <button class="ps-btn ps-btn--fullwidth" style="width: 25%;">Track</button>
                        </div>
                    </div>

                </div>

            </div>
    </div>
    </form>
</div>
</div>

@endsection