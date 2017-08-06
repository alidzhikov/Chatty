<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">Chatty</a>
        </div>

        
            <?php if(Auth::check()): ?>
            <ul class="nav navbar-nav nav-pills">
                <li><a href="<?php echo e(route('home')); ?>">Timeline</a></li>
                <li><a href="<?php echo e(route('friend.index')); ?>">Friends</a></li>
            </ul>

            <form action="<?php echo e(route('search.results')); ?>" role="search" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="query" class="form-control"
                           placeholder="Find people"/>
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
            <?php endif; ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if(Auth::check()): ?>
                <li><a href="<?php echo e(route('profile.index',['username' => Auth::user()->username] )); ?>"><?php echo e(Auth::user()->getNameOrUsername()); ?></a></li>
                <li><a href="<?php echo e(route('profile.edit')); ?>">Update profile</a></li>
                <li><a href="<?php echo e(route('auth.signout')); ?>">Sign out</a></li>
                <?php else: ?>
                <li><a href="<?php echo e(route('auth.signup')); ?>">Sign up</a></li>
                <li><a href="<?php echo e(route('auth.signin')); ?>">Sign in</a></li>
                <?php endif; ?>
            </ul>
        </div>
    
</nav>