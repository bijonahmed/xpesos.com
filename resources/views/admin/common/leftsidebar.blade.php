<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
	<div class="brand-logo">
		<a href="{{url('/dashboard')}}">
			<center><h5 class="logo-text"><b><small>futuregenit.com</small></b></h5></center>
		</a>
	</div>
        
   <!--     sdf-->
	<?php 
		 $role_id = Session::get('role_id');
		?>
	<ul class="sidebar-menu do-nicescrol">
		<li class="sidebar-header">MAIN NAVIGATION</li>
		<li>
			<a href="{{url('/dashboard')}}" class="waves-effect">
				<i class="icon-home"></i> <span>Dashboard</span>
			</a>
		</li>
		<li><a href="{{url('/admin/order-list')}}"><i class="fa fa-circle-o"></i>Order List</a></li>
		<?php 
		 if($role_id==1){
		?>
		<li><a href="{{url('/admin/order-report')}}"><i class="fa fa-circle-o"></i>Order Report</a></li>
		<?php }?>
		<li><a href="{{url('/admin/productlist')}}"><i class="fa fa-circle-o"></i>Product List</a></li>
		<?php 
		 if($role_id==1){
		?>
		<li>
			<a href="javaScript:void();" class="waves-effect">
				<i class="icon-plus"></i><span>System Management</span><i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/post-list')}}"><i class="fa fa-circle-o"></i>Post</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/menu-list')}}"><i class="fa fa-circle-o"></i>Menu</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/submenu-list')}}"><i class="fa fa-circle-o"></i>Sub Menu</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/submenu-in-list')}}"><i class="fa fa-circle-o"></i>Sub in Sub</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/slider-list')}}"><i class="fa fa-circle-o"></i>Slider</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/review-list')}}"><i class="fa fa-circle-o"></i>Review</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/gallery-list')}}"><i class="fa fa-circle-o"></i>Gallery</a></li>
			</ul>
                	<ul class="sidebar-submenu">
				<li><a href="{{url('admin/brand-list')}}"><i class="fa fa-circle-o"></i>Brand</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('admin/category-list')}}"><i class="fa fa-circle-o"></i>Category</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/sub-category-list')}}"><i class="fa fa-circle-o"></i>Sub Category </a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/sub-in-sub-category-list')}}"><i class="fa fa-circle-o"></i>Sub In Category
					</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/special-category-list')}}"><i class="fa fa-circle-o"></i>Special Category </a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/contact-list')}}"><i class="fa fa-circle-o"></i>Contact List </a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/company-setting')}}"><i class="fa fa-circle-o"></i>Company Setting</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/user-list')}}"><i class="fa fa-circle-o"></i>User</a></li>
				<li><a href="{{url('/admin/user-rolelist')}}"><i class="fa fa-circle-o"></i>User Role</a></li>
			</ul>
		</li>

		<li>
			<a href="javaScript:void();" class="waves-effect">
				<i class="ti-settings"></i>
				<span>My Inventory</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/item-list')}}"><i class="fa fa-circle-o"></i>Item List </a></li>
				<li><a href="{{url('/admin/item-report')}}" style="display:none;"><i class="fa fa-circle-o"></i>Item Report </a></li>
				<li><a href="{{url('/admin/invoice-list')}}"><i class="fa fa-circle-o"></i>Order
						Invoice</a></li>
				<li><a href="{{url('/admin/vendor-invoice-list')}}"><i class="fa fa-circle-o"></i>Purchase Invoice</a>
				</li>
				<li><a href="{{url('/admin/customer-list')}}"><i class="fa fa-circle-o"></i>Customer List</a></li>
				<li><a href="{{url('/admin/customer-ledger')}}"><i class="fa fa-circle-o"></i>Customer Ledger</a></li>

				<li><a href="{{url('/admin/vendor-list')}}"><i class="fa fa-circle-o"></i>Vendor List</a></li>
				<li><a href="{{url('/admin/vendor-ledger')}}"><i class="fa fa-circle-o"></i>Vendor Ledger</a></li>
			</ul>
		</li>

		<li>
			<a href="javaScript:void();" class="waves-effect">
				<i class="ti-settings"></i>
				<span>My Accounts</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="sidebar-submenu">
				<li ><a href="{{url('/admin/money-transaction')}}"><i class="fa fa-circle-o"></i>Money Transaction</a>
				</li>
				<li><a href="{{url('/admin/party-payment')}}"><i class="fa fa-circle-o"></i>Party
						Payment</a></li>
				<li><a href="{{url('/admin/expense')}}"><i class="fa fa-circle-o"></i>Expense</a></li>
				<li><a href="{{url('/admin/salary-sheet')}}"><i class="fa fa-circle-o"></i>Salary</a></li>
				<li><a href="{{url('/admin/profit-loss-report')}}"><i class="fa fa-circle-o"></i>Profit / Loss</a></li>
				<li><a href="{{url('/admin/details-report')}}"><i class="fa fa-circle-o"></i>Details Report</a></li>
			</ul>
		</li>

		<li style="display:none;">
			<a href="javaScript:void();" class="waves-effect">
				<i class="ti-settings"></i>
				<span>HRM</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/department-list')}}"><i class="fa fa-circle-o"></i>Department List</a></li>
				<li><a href="{{url('/admin/designation-list')}}"><i class="fa fa-circle-o"></i>Designation List</a></li>
				<li><a href="{{url('/admin/employee-list')}}"><i class="fa fa-circle-o"></i>Employee List</a></li>
				<li style="display: none;"><a href="{{url('/admin/salary-list')}}"><i class="fa fa-circle-o"></i>Salary
						List</a></li>
			</ul>
		</li>



		<?php  }elseif($role_id==2){?>
		<li>
			<a href="javaScript:void();" class="waves-effect">
				<i class="icon-plus"></i><span>Order Management</span><i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="sidebar-submenu">
				<li><a href="{{url('admin/recived-order-list')}}"><i class="fa fa-circle-o"></i>Recv.Order</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/confirm-order-list')}}"><i class="fa fa-circle-o"></i>Confirm Order </a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/shipped-order-list')}}"><i class="fa fa-circle-o"></i>Shiped Order
					</a></li>
			</ul>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/complete-order-list')}}"><i class="fa fa-circle-o"></i>Complete Order
					</a></li>
			</ul>

			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/hold-order-list')}}"><i class="fa fa-circle-o"></i>Hold Order
					</a></li>
			</ul>

			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/cancel-order-list')}}"><i class="fa fa-circle-o"></i>Cancel Order
					</a></li>
			</ul>

			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/return-order-list')}}"><i class="fa fa-circle-o"></i>Return Order
					</a></li>
			</ul>
		</li>

		<?php } ?>


		<li style="display:none;">
			<a href="javaScript:void();" class="waves-effect">
				<i class="icon-map"></i>
				<span>Loca. Management</span><i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="sidebar-submenu">
				<li><a href="{{url('/admin/division-list')}}"><i class="fa fa-circle-o"></i>Division</a></li>
				<li><a href="{{url('/admin/district-list')}}"><i class="fa fa-circle-o"></i>District</a></li>
			</ul>
		</li>
		<li>
		</li>
	</ul>
</div>