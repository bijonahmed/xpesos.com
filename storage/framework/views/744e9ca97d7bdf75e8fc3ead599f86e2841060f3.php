<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $__env->yieldContent('title'); ?></title>
	<?php $data = DB::table('tbl_setting')->first(); ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link rel="icon" href="<?php echo e(url('admin/'.$data->photo)); ?>" type="image/gif" sizes="16x16">
	<?php echo $__env->make('fronted.common.allcss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
	<?php echo $__env->make('fronted.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('fronted.common.mobile_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldContent('maincontent'); ?>
	<?php echo $__env->make('fronted.common.newsLetter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('fronted.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('fronted.common.topAndLoader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('fronted.common.alljs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
</body><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/master.blade.php ENDPATH**/ ?>