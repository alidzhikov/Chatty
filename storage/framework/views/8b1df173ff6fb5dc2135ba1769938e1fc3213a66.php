<div class="col-lg-5">


    <?php if(!$statuses->count()): ?>
        <!-- check if its profile page -->
        <?php if(isset($user)): ?>
            <h4><?php echo e($user->getNameOrPronoun("Your","'s")); ?> statuses</h4>
            <p><?php echo e($user->getNameOrPronoun("You haven't"," hasn't")); ?> posted anything yet.</p>
        <?php else: ?>
                <!-- else its timeline page -->
            <p>There's nothing in <?php echo e(Auth::user()->getNameOrPronoun("your","'s")); ?> timeline yet.</p>
        <?php endif; ?>
    <?php else: ?>
        <?php if(isset($user)): ?>
            <h4><?php echo e($user->getNameOrPronoun("Your","'s")); ?> statuses</h4>
        <?php else: ?>
            <h4>Your timeline</h4>
        <?php endif; ?>
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" alt="<?php echo e($status->user->getNameOrUsername()); ?>" src="<?php echo e($status->user->getAvatarUrl()); ?>">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="<?php echo e(route('profile.index', ['username' => $status->user->username])); ?>">
                            <?php echo e($status->user->getNameOrUsername()); ?></a></h4>
                    <p><?php echo e($status->body); ?></p>
                    <ul class="list-inline">
                        <li><?php echo e($status->created_at->diffForHumans()); ?></li>
                        <?php if(!$status->user->isAuthProfile() && $status->user->isFriendsWith(Auth::user())): ?>
                            <li><a href="<?php echo e(route('status.like', ['statusId' => $status->id])); ?>"><?php echo e(Auth::user()->hasLikedStatus($status) ? 'Dislike' : 'Like'); ?></a></li>
                        <?php endif; ?>
                        <li><?php echo e($status->likedLikes()); ?> <?php echo e(str_plural('like', $status->likedLikes() )); ?></li>
                    </ul>
                    <?php $__currentLoopData = $status->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" alt="<?php echo e($reply->user->getNameOrUsername()); ?>" src="<?php echo e($reply->user->getAvatarUrl()); ?>">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="<?php echo e(route('profile.index', ['username' => $reply->user->username])); ?>">
                                        <?php echo e($reply->user->getNameOrUsername()); ?>

                                    </a></h5>
                                <p><?php echo e($reply->body); ?></p>
                                <ul class="list-inline">
                                    <li><?php echo e($reply->created_at->diffForHumans()); ?></li>
                                    <?php if(!$reply->user->isAuthProfile() && $reply->user->isFriendsWith(Auth::user())): ?>
                                        <li>
                                            <a href="<?php echo e(route('status.like', ['statusId' => $reply->id])); ?>"><?php echo e(Auth::user()->hasLikedStatus($reply) ? 'Dislike' : 'Like'); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li><?php echo e($reply->likedLikes()); ?> <?php echo e(str_plural('like', $reply->likedLikes() )); ?></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!isset($authUserIsFriend) || (!empty($authUserIsFriend) || Auth::user()->id === $status->user->id)): ?>
                        <form role="form" action="<?php echo e(route('status.reply', ['statusId' => $status->id])); ?>" method="post">
                            <div class="form-group<?php echo e($errors->has("reply-{$status->id}") ? ' has-error' : ''); ?>">
                                <textarea name="reply-<?php echo e($status->id); ?>" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                                <?php if($errors->has("reply-{$status->id}")): ?>
                                    <span class="help-block"><?php echo e($errors->first("reply-{$status->id}")); ?></span>
                                <?php endif; ?>
                            </div>
                            <input type="submit" value="Reply" class="btn btn-default btn-sm">
                            <input type="hidden" name="_token" value="<?php echo e(Session::token()); ?>">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php echo $statuses->render(); ?>

    <?php endif; ?>
</div>