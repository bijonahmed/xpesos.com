<script src="<?php echo e(url('fronted/plugins/jquery-1.12.4.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/owl-carousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/bootstrap4/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/imagesloaded.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/masonry.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/isotope.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/jquery.matchHeight-min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/slick/slick/slick.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/jquery-bar-rating/dist/jquery.barrating.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/slick-animation.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/lightGallery-master/dist/js/lightgallery-all.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/sticky-sidebar/dist/sticky-sidebar.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/plugins/select2/dist/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(url('fronted/js/main.js')); ?>"></script>
<script>
    function cartAccess() {
        window.location.href = "<?php echo e(url('/show-cart/')); ?>";
    }
    //Autocmoplete Product Search Desktop. 
    $('#product_name').autocomplete({
        source: "<?php echo e(route('autocomplete.AutocompleteProductfetch')); ?>",
        minLength: 1,
        select: function(event, ui) {
            $('#product_name').val(ui.item.value);
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item) {
        return $("<li class='ui-autocomplete-row'></li>")
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };
    $(".loader").show();
    $(document).ready(function() {
        setTimeout(function() {
        //$("#successMessage").hide('blind', {}, 500)
        $(".loader").hide('blind', {}, 500);
        $("#topselling").show();
        $("#todaydel").show();
        $("#globalfestival").show();
        $("#womenFashion").show();
        $("#homeOffice").show();
    }, 3000);
    });
</script><?php /**PATH E:\xampp\htdocs\xposos_sam_laravel\resources\views/fronted/common/alljs.blade.php ENDPATH**/ ?>