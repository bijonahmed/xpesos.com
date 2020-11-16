<title>{{$title}}</title>
@extends('fronted.master')
@section('maincontent')
<style>
.ps-store-list > .container > .ps-section__header {
	padding: 5px 0 5px;
}

.ps-store-list {
	padding-top: 5px;
}
.ps-block--store .ps-block__author .ps-block__user {
	display: block;
	width: 100px;
	height: 1px;
	border-radius: 50%;
}
.widget--vendor .widget-title {
	/* margin-bottom: 35px; */
	font-size: 20px;
	color: #000;
	font-weight: 600;
}
.ps-block--store .ps-block__content {
	padding: 05px 20px 0px;
	border-top: 3px solid #17a2b8;
	text-align: center;
}
</style>
<div class="ps-page--single ps-page--vendor">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li>Store List</li>
            </ul>
        </div>
    </div>
    <section class="ps-store-list">
        <div class="container">
            <div class="ps-section__header">
                <h3>Store list</h3>
            </div>
            <div class="ps-section__wrapper">
                <div class="ps-section__left">

                <form method="post" id="upload_form" enctype="multipart/form-data" action="{{url('/find-store')}}">
                        {{ csrf_field() }}
                    <aside class="widget widget--vendor">
                        <h3 class="widget-title">Search Store</h3>
                        <select class="ps-select" name="user_id" required>
                        <option>Select Store</option>
                        <option value="">All</option>
                            <?php
                                        foreach ($allstorelist as $val) {
                                            ?>
                            <option value="<?php echo $val->user_id; ?>"><?php echo $val->company; ?>
                            </option>
                            <?php }?>
                            </select><br>
                        <button class="btn btn-primary btn-block" style="font-size: 16px;">Find Store</button>
                    </aside>
                        </form>

                    <aside class="widget widget--vendor" style="display:none;">
                        <h3 class="widget-title">Filter by Category</h3>
                        <div class="form-group">
                            <select class="ps-select">
                                <option>Lighting</option>
                                <option>Exterior</option>
                                <option>Custom Grilles</option>
                                <option>Wheels & Tires</option>
                                <option>Performance</option>
                            </select>
                        </div>
                    </aside>
                    <aside class="widget widget--vendor"  style="display:none;">
                        <h3 class="widget-title">Filter by Location</h3>
                        <div class="form-group">
                            <select class="ps-select">
                                <option>Chooose Location</option>
                                <option>Exterior</option>
                                <option>Custom Grilles</option>
                                <option>Wheels & Tires</option>
                                <option>Performance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="ps-select">
                                <option>Chooose State</option>
                                <option>Exterior</option>
                                <option>Custom Grilles</option>
                                <option>Wheels & Tires</option>
                                <option>Performance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Search by City">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Search by ZIP">
                        </div>
                    </aside>
                </div>
                <div class="ps-section__right">
                    <section class="ps-store-box">
                        <div class="ps-section__header">
                            <p>Showing <?php echo count($storelist);?> results</p>
                        </div>
                        <div class="ps-section__content">
                            <div class="row">
                            <?php 
                                    foreach($storelist as $i){
                            ?>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                                <a class="ps-block__user" href="{{ url('store-details/'.$i->company_slug) }}"> 
                                <article class="ps-block--store">
                                        <div class="ps-block__thumbnail bg--cover" data-background="{{ url('admin/'.$i->user_pic) }}"></div>
                                        <div class="ps-block__content">
                                            <div class="ps-block__author">
                                                
                                                </div>
                                            <h4>{{$i->company}}</h4>
                                        </div>
                                    </article></a>
                                </div>
                                    <?php } ?>        
                                
                            </div>
                            <div class="ps-pagination" style="display:none;">
                                <ul class="pagination">
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
 
@endsection