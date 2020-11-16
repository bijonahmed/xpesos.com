@extends('admin.master')
@section('title','Newsletter List')
@section('maincontent')
<div class="content-wrapper">
	<div class="alert alert-success alert-dismissible" role="alert">
		<div class="alert-icon">
			<i class="icon-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Newsletter</strong> List</span>
		</div>
	</div>
	<!--Start Dashboard Content-->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="container">
					<div class="card-header">
						<div class="row">
							<div class="col-md-10">
							</div>
							<div class="col-md-2" style="text-align:right;">
								<a href="#" onclick="location.reload();">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Reload </a>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<table class="table table-striped table-dark table-hover" style="width: 100%; color:#fff;">

						<thead>
							<tr>
								<th>SL</th>
								<th>Sending Date</th>
								<th>Email ID</th>
							</tr>
						</thead>
						<tbody>
							<?php
            $x=1;
            foreach($data as $v){
            ?>
							<tr>
								<td><?php echo $x; $x++;?></td>
								<td><?php echo date("d-M-Y",strtotime($v->dates));?></td>
								<td><?php echo $v->email_id;?></td>
							</tr>
							<?php
                              }
                              ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->
</div>
</div>
</div>
@endsection