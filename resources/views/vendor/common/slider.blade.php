<?php
$data = DB::table('tbl_slider')->where('status', 1)->get();
?> 
<div class="ps-home-banner ps-home-banner--1">
        <div class="ps-container">
            <div class="ps-section__center">
                <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true" data-owl-loop="true"
                    data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                    data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1"
                    data-owl-duration="1000" data-owl-mousedrag="on">
               <?php
                    foreach ($data as $key => $value) {
                        ?>
                    <div class="ps-banner"><a href="#"><img src="{{ asset('admin/'.$value->photo) }}"
                                alt="image" style="height:400px; width: 100%;"></a></div>
                    
                    <?php
                    } ?>
                 
                </div>
            </div>
           
        </div>
    </div>

    