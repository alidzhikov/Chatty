<?php if(\Illuminate\Support\Facades\Session::has('info')): ?>
    <div class="alert alert-info" role="alert">
        <?php echo e(\Illuminate\Support\Facades\Session::get('info')); ?>

    </div>
 <?php endif; ?>