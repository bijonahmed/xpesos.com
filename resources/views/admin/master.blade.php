<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Women's Fashion, Men's Fashion,Winter Fashion" />
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <title>@yield('title')</title>
    @include('admin.common.allcss')

</head>

<body>
    <div id="wrapper">
        @include('admin.common.leftsidebar')
        @include('admin.common.header')
        @yield('maincontent')
        <div class="clearfix"></div>
    </div>
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--@include('admin.common.footer')-->
    @include('admin.common.alljs')
</body>

</html>