<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Chatty</a>
        </div>

        <div class="collapse navbar-collapse">
            <!-- <?php if(Auth::check()): ?> -->
            <ul class="nav navbar-nav">
                <li><a href="#">Timeline</a></li>
                <li><a href="#">Friends</a></li>
            </ul>

            <form action="#" role="search" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="query" class="form-control"
                           placeholder="Find people"/>
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
            <!-- <?php endif; ?> -->
            <ul class="nav navbar-nav navbar-right">
                <!--<?php if(Auth::check()): ?> -->
                <li><a href="#">Dayle<!-- <?php echo e(Auth::user()->getNameOrUsername()); ?>

                                --></a></li>
                <li><a href="#">Update profile</a></li>
                <li><a href="#">Sign out</a></li>
                <!-- <?php else: ?> -->
                <li><a href="#">Sign up</a></li>
                <li><a href="#">Sign in</a></li>
                <!-- <?php endif; ?> -->
            </ul>
        </div>
    </div>
</nav>