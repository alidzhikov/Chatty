<?php $__env->startSection('content'); ?>

    <h3>Oops, that page could not be found.</h3>
    <a href="<?php echo e(route('home')); ?>">Go home</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>