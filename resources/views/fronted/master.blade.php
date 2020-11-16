<!DOCTYPE html>
<html lang="en">

<head>
	<title>@yield('title')</title>
	<?php $data = DB::table('tbl_setting')->first(); ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link rel="icon" href="{{ url('admin/'.$data->photo) }}" type="image/gif" sizes="16x16">
	@include('fronted.common.allcss')
</head>

<body>
	@include('fronted.common.header')
	@include('fronted.common.mobile_menu')
	@yield('maincontent')
	@include('fronted.common.newsLetter')
	@include('fronted.common.footer')
	@include('fronted.common.topAndLoader')
	@include('fronted.common.alljs') 
</body>