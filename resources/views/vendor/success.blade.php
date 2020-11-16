@extends('vendor.master')
@section('title','Success Order')
@section('maincontent')

<?php 
$setting = DB::table('tbl_setting')->first();
?>

<div class="row">
<div class="container">
    <p style="font-size: 22px; font-weight: bold;text-align:center; color: green;">{{$setting->recived_order}}</p>
</div>

</div>


@endsection
