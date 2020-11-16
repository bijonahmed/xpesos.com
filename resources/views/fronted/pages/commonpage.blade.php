@extends('fronted.master')
@section('title',$title)
@section('maincontent')

<div class="main-container container" style="background-color: white;">
    <div class="row">
        <div id="content" class="col-sm-12 item-article" style="padding: 20px;">
            <div class="row box-1-about">
                <div class="col-md-12 welcome-about-us">
                    <div class="title-about-us">
                        <h2>Welcome To Shop</h2>
                    </div>

                    <p style="text-align: justify;"><?php
                        $text = $data->post_description;
                        echo nl2br($text);
                        ?> </p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection