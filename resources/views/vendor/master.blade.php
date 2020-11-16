<!DOCTYPE html>
<html lang="en">
<head>
<?php $data = DB::table('tbl_setting')->first(); ?>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
     <link rel="icon" href="{{ asset('admin/'.$data->photo) }}" type="image/gif" sizes="16x16">
     @include('fronted.common.allcss')
</head>
<body>
    @include('vendor.common.header_top')
    @include('vendor.common.header_mobile')
    @yield('maincontent')
    @include('vendor.common.footer_top')

    <div id="back2top"><i class="pe-7s-angle-up"></i></div>
    <div class="ps-site-overlay"></div>
    <div id="loader-wrapper">
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
        <div class="ps-search__content">
            <form class="ps-form--primary-search" action="http://nouthemes.net/html/martfury/do_action" method="post">
                <input class="form-control" type="text" placeholder="Search for...">
                <button><i class="aroma-magnifying-glass"></i></button>
            </form>
        </div>
    </div>
    @include('fronted.common.alljs')
</body>

</html>