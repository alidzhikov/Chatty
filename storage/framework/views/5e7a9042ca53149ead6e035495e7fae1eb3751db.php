<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php echo $__env->make('user.partials.userblock', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            <?php if(Auth::user()->hasFriendRequestPending($user)): ?>
                <p>Waiting for <?php echo e($user->getNameOrUsername()); ?> to accept your request.</p>
            <?php elseif(Auth::user()->hasFriendRequestReceived($user)): ?>
                <a href="<?php echo e(route('friend.accept', ['username' => $user->username])); ?>" class="btn btn-primary">Accept friend request.</a>
            <?php elseif(Auth::user()->isFriendsWith($user)): ?>
                <p>You and <?php echo e($user->getNameOrUsername()); ?> are friends</p>

                <form action="<?php echo e(route('friend.delete', ['username' => $user->username])); ?>" method="post">
                    <input type="submit" value="Delete friend" class="btn btn-primary" />
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                </form>
            <?php elseif(Auth::user() != $user): ?>
                <a href="<?php echo e(route('friend.add',['username' => $user->username])); ?>" class="btn btn-primary">Add as friend</a>
            <?php endif; ?>
            <h4>
                <?php if($isAuthProfile): ?>
                    Your friends.
                <?php else: ?>
                    <?php echo e($user->getFirstNameOrUsername()); ?>'s friends.
                <?php endif; ?>
            </h4>
            <?php if(!$user->friends()->count()): ?>
                <?php if($isAuthProfile): ?>
                    <p>You have no friends.</p>
                <?php else: ?>
                    <p><?php echo e($user->getFirstNameOrUsername()); ?> has no friends.</p>
                <?php endif; ?>

            <?php else: ?>
                <?php  $userOld = $user;  ?>
                <?php $__currentLoopData = $user->friends(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <?php echo $__env->make('user.partials.userblock', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php  $user= $userOld;  ?>
            <?php endif; ?>
        </div>
        <?php echo $__env->make('templates.partials.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>