<?php $setting = DB::table('tbl_setting')->first(); ?>
<meta name="keywords" content="{{$setting->meta_keywords}}" />
<meta name="description" content="{{$setting->meta_description}}" />
<meta property="og:title" content="<?php if(!empty($ogtitle)){ echo $ogtitle; };?>" />
<meta property="fb:app_id" content="176443367098252" />
<meta property="og:description" content="<?php if(!empty($des)){ echo $des; };?>"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php if(!empty($url)){ echo $url; };?>" />
<meta property="og:image" content="<?php if(!empty($img)){ echo $img; };?>" />
<meta property="og:image:secure_url" content="<?php if(!empty($img)){ echo $img; };?>" />
<meta property="og:image:type" content="image/jpg" />
<meta property="og:image:width" content="150" />
<meta property="og:image:height" content="150" />