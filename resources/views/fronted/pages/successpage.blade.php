@extends('fronted.master')
@section('title','Thanks')
@section('maincontent')
<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
          <div class="page-header-content">
   
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
              <a href="{{url('/')}}">Home</a>
              </li>
              <li class="list-inline-item">/</li>
              <li class="list-inline-item">
              Payment 
              </li>
            </ul>
          </div>
      </div>
    </div>
  </div>
</section>
<center><h2>{{$success}}</h2></center>
@endsection