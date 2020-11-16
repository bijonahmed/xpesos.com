<div class="so-categories custom-slidercates module clearfix">
     <h3 class="modtitle"><span style="color: #ff3d00; font-size: 22px;">&nbsp;SHOP CATEGORY</span></h3>
   <div class="card-deck-wrapper">
                <?php
            foreach ($category as $v) {
                ?>
          <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
           <a href="{{url('/category/'.$v->slug)}}" title="{{$v->category_name}}" target="_self">
                            <img src="{{ asset('admin/'.$v->photo) }}" title="{{$v->category_name}}" style="height: 100%; width: 100%;" alt="{{$v->category_name}}"/>
                        </a>
                    <div class="cat-title">
                        <center><a href="{{url('/category/'.$v->slug)}}" title="{{$v->category_name}} " target="_self" style="color: #ff3d00; font-weight: bold; text-align: center; color: #ff3d00; font-size: 18px;"> {{$v->category_name}}</a></center>
                    </div>
        </div>
    <?php } ?>
</div>
</div>
    <style>
        /* Single-direction drop shadow */
hr.style-four {
    height: 12px;
    border: 0;
   
}
    </style>
    <hr class="style-four">