@extends('admin.master')
@section('title',$title)
@section('maincontent')
<div class="content-wrapper">
    <div class="alert alert-success alert-dismissible" role="alert">
        <h1>Successfully Update <a href="{{ url('/admin/productlist') }}">Back to product list</a></h1>
    </div>
</div>
@endsection