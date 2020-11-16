@extends('fronted.master')
@section('title',"Product Not found")
@section('maincontent')

<div class="main-container container" style="background-color: white;">
    <ul class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i></a></li>
        <li><a href="{{url('/')}}">Page</a></li>
        <li><a href="#">Product Not found</a></li>
    </ul>

    <div class="row">
        <div id="content" class="col-sm-12 item-article" style="padding: 20px;">
            <div class="row box-1-about">
                <div class="col-md-12 welcome-about-us">
                   <center><h3>Sorry Product Not found.</h3></center>
                </div>

            </div>
        </div>
    </div>
</div>



@endsection