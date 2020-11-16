<style>
	/* Make the image fully responsive */
	.carousel-inner img {
		width: 100%;
		height: 100%;
	}
</style>
<div class="container">
	<div class="ps-home-banner">
		<div id="demo" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ul class="carousel-indicators">
				<li data-target="#demo" data-slide-to="0" class="active"></li>
				<li data-target="#demo" data-slide-to="1"></li>
				<li data-target="#demo" data-slide-to="2"></li>
			</ul>

			<!-- The slideshow -->
			<div class="carousel-inner">
				<?php
				$data = DB::table('tbl_slider')->where('status', 1)->get();
				foreach ($data as $value) {
					if ($value->slider_id == 1) {
				?>
						<div class="carousel-item active">
							<img src="<?php echo e(url('admin/'.$value->photo)); ?>" alt="Los Angeles" width="1100" height="500">
						</div>
					<?php } else { ?>
						<div class="carousel-item">
							<img src="<?php echo e(url('admin/'.$value->photo)); ?>" alt="Chicago" width="1100" height="500">
						</div>
				<?php
					}
				} ?>
			</div>

			<!-- Left and right controls -->
			<a class="carousel-control-prev" href="#demo" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#demo" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>



	</div>
</div><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/common/homeBanner.blade.php ENDPATH**/ ?>