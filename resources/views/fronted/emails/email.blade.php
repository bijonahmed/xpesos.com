<!DOCTYPE html>
<!--Code By Webdevtrick ( https://webdevtrick.com )-->
<html lang="en">
<?php 
	$setting = DB::table('tbl_setting')->first();
	?> 
<head>
  <meta charset="UTF-8">
  <title>Welcome to our xpesos | xpesos.com</title>
</head>
 
<body>
 
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
 
<!--HEADER -->
 
<tbody><tr>
<td align="center">
<table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody><tr>
<td align="center" valign="top" background="https://images.pexels.com/photos/1936299/pexels-photo-1936299.jpeg?cs=srgb&dl=artificial-intelligence-codes-developing-1936299.jpg&fm=jpg" bgcolor="#66809b" style="background-size:cover; background-position:top;height=" 400""="">
<table class="col-600" width="600" height="400" border="0" align="center" cellpadding="0" cellspacing="0">
 
<tbody><tr>
<td height="40"></td>
</tr>
 
 
<tr>
<td align="center" style="line-height: 0px;">
<img style="display:block; line-height:0px; font-size:0px; border:0px;" 
	 src="{{ url('admin/'.$setting->photo) }}" width="109" height="50" alt="logo">
</td>
</tr>
 
 
 
<tr>
<td align="center" style="font-family: 'Raleway', sans-serif; font-size:37px; color:#ffffff; line-height:24px; font-weight: bold; letter-spacing: 5px;">
WELCOME <span style="font-family: 'Raleway', sans-serif; font-size:37px; color:#ffffff; line-height:39px; font-weight: 300; letter-spacing: 5px;">TO XPESOS</span>
</td>
</tr>
 
 
 
 
 
<tr>
<td align="center" style="font-family: 'Lato', sans-serif; font-size:15px; color:#ffffff; line-height:24px; font-weight: 300;">
Now you will recive Email everytime automatically <br>on our new updates.
</td>
</tr>
 
 
<tr>
<td height="10"></td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
 
 
<!-- END HEADERR -->
 
 
<!-- START SHOWCASE -->
 
<tr>
<td align="center">
<table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
<tbody><tr>
<td height="35"></td>
</tr>
 
<tr>
<td align="center" style="font-family: 'Raleway', sans-serif; font-size:22px; font-weight: bold; color:#333;">Username & Password</td>
</tr>
 
<tr>
<td height="10"></td>
</tr>
 
 
<tr>
<td align="center" style="font-family: 'Lato', sans-serif; font-size:14px; color:#757575; line-height:24px; font-weight: 300;">
Username: {{ $email }} <br>
Password: {{ $uniqueId }} <br>
Login link : <a href="{{ url('/user-login-registration') }}" target="_blank">Login Page</a>
<p style="text-align: justify;">
We connect millions of buyers and sellers around the world, empowering people & creating economic opportunity for all.
Within our markets, millions of people around the world connect, both online and offline, to make, sell and buy unique
goods. We also offer a wide range of Seller Services and tools that help creative entrepreneurs start, manage and scale their businesses. Our mission is to reimagine commerce in ways that build a more fulfilling and lasting world, and we’re committed to using the power of business to strengthen communities and empower people.
</p>

</td>
</tr>

</tbody></table>
</td>
</tr>

<tr>
<td align="center">
<table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;">
 
 
 
<tbody>
 
 
<!-- END ABOUT -->
 
 
 
<!-- CHECKOUT BELOW -->
 
<tr>
<td align="center">
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
<tbody>

 
 
<!-- END CHECKOUT BELOW -->
 
 
<!--START PRICING-->
 
<tr>
<td align="center">
<table width="600" class="col-600" align="center" border="0" cellspacing="0" cellpadding="0" style=" border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
<tbody>
<tr>
<td>
 
 
 
 
<table width="1" height="20" border="0" cellpadding="0" cellspacing="0" align="left">
<tbody><tr>
<td height="20" style="font-size: 0;line-height: 0;border-collapse: collapse;">
<p style="padding-left: 24px;">&nbsp;</p>
</td>
</tr>
</tbody></table>
 
 
</td>
</tr>
</tbody></table>
</td>
</tr>
 
 
<!-- END PRICING -->
 
 
<!-- START FOOTER -->
 
<tr>
<td align="center">
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
<tbody><tr>
<td height="5"></td>
</tr>
<tr>
<td align="center" bgcolor="#333" background="https://webdevtrick.com/wp-content/uploads/image-slider1.jpg" height="185">
<table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody><tr>
<td height="25"></td>
</tr>
 
<tr>
<td align="center" style="font-family: 'Raleway',  sans-serif; font-size:26px; font-weight: 500; color:#fbb016; background-color: #333;">Follow Us On Social Media</td>
</tr>
 
 
<tr>
<td height="25"></td>
</tr>
 
 
 
</tbody></table><table align="center" width="35%" border="0" cellspacing="0" cellpadding="0">
<tbody><tr>
<td align="center" width="30%" style="vertical-align: top;">
<a href="https://www.facebook.com/xpesos.co.uk/" target="_blank"> <img src="https://webdevtrick.com/wp-content/uploads/icon-twitter.png"> </a>
</td>
 
<td align="center" class="margin" width="30%" style="vertical-align: top;">
<a href="https://www.facebook.com/xpesos.co.uk/" target="_blank"> <img src="https://webdevtrick.com/wp-content/uploads/icon-fb.png"> </a>
</td>
 
<td align="center" width="30%" style="vertical-align: top;">
<a href="https://www.facebook.com/xpesos.co.uk/" target="_blank"> <img src="https://webdevtrick.com/wp-content/uploads/icon-googleplus.png"> </a>
</td>
</tr>
</tbody></table>
 
 
 
</td></tr></tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
 
<!-- END FOOTER -->
</tbody></table>
  
</body>
</html>