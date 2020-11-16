    
    <?php $__env->startSection('title','Dashboard'); ?>
    <?php $__env->startSection('maincontent'); ?>
    <div class="content-wrapper">
    	<div class="alert alert-success alert-dismissible" role="alert">
    		<div class="alert-icon">
    			<i class="icon-check"></i>
    		</div>

    		<div class="alert-message">
    			<?php
				$slug = Session::get('company_slug');
				$role_id = Session::get('role_id');
				?>
				<span><strong>Welcome</strong> to   
				<?php 
						$compay = Session::get('company');
						if(!empty($compay)){
							echo $compay;
						}

				?>
				
				<a href="<?php echo e(url('/store-details',$slug)); ?>" style="color:yellow;" target="_blank">Go to store</a></span>
    			Welcome to our system

    		</div>

    	</div>
    	<div class="container-fluid">
    		<!--Start Dashboard Content-->
    		<div class="row mt-3">
    			<?php
				if ($role_id == 1) {
				?>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/productlist')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $t_product; ?></h4>
    										<span class="text-white">My <br>Products</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $t_order; ?></h4>
    										<span class="text-white">Today<br> Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<!-- sdfsdf-->
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/recived-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $recived; ?></h4>
    										<span class="text-white">Received <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/confirm-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $confirm; ?></h4>
    										<span class="text-white">Confirm <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/shipped-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $shipped; ?></h4>
    										<span class="text-white">Shipped <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/complete-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $complete; ?></h4>
    										<span class="text-white">Complete <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/hold-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $hold; ?></h4>
    										<span class="text-white">Hold <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/cancel-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $cancel; ?></h4>
    										<span class="text-white">Canceled <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/return-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $return; ?></h4>
    										<span class="text-white">Return <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				 
    			<?php } elseif ($role_id == 2) { ?>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/productlist')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $t_product; ?></h4>
    										<span class="text-white">My <br>Products</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
					</div>
					<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $t_order; ?></h4>
    										<span class="text-white">Today<br> Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<!-- sdfsdf-->
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/recived-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $recived; ?></h4>
    										<span class="text-white">Received <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/confirm-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $confirm; ?></h4>
    										<span class="text-white">Confirm <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/shipped-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $shipped; ?></h4>
    										<span class="text-white">Shipped <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/complete-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $complete; ?></h4>
    										<span class="text-white">Complete <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/hold-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $hold; ?></h4>
    										<span class="text-white">Hold <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/cancel-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $cancel; ?></h4>
    										<span class="text-white">Canceled <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    				<div class="col-12 col-lg-6 col-xl-2">
    					<a href="<?php echo e(url('/admin/return-order-list')); ?>">
    						<div class="card bg-dark">
    							<div class="card-body">
    								<div class="media">
    									<div class="media-body text-left">
    										<h4 class="text-white count"><?php echo $return; ?></h4>
    										<span class="text-white">Return <br>Order</span>
    									</div>
    									<div class="align-self-center w-circle-icon rounded-circle bg-contrast">
    										<i class="icon-basket-loaded text-white"></i></div>
    								</div>
    							</div>
    						</div>
    					</a>
    				</div>
    			<?php } ?>

    		</div>
    		<!--End Row-->
    	</div>
    	<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/admin/child.blade.php ENDPATH**/ ?>