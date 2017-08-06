<div class="col-lg-5">


    @if(!$statuses->count())
        <!-- check if its profile page -->
        @if(isset($user))
            <h4>{{ $user->getNameOrPronoun("Your","'s") }} statuses</h4>
            <p>{{ $user->getNameOrPronoun("You haven't"," hasn't") }} posted anything yet.</p>
        @else
                <!-- else its timeline page -->
            <p>There's nothing in {{ Auth::user()->getNameOrPronoun("your","'s") }} timeline yet.</p>
        @endif
    @else
        @if(isset($user))
            <h4>{{ $user->getNameOrPronoun("Your","'s") }} statuses</h4>
        @else
            <h4>Your timeline</h4>
        @endif
        @foreach($statuses as $status)
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                            {{ $status->user->getNameOrUsername() }}</a></h4>
                    <p>{{ $status->body }}</p>
                    <ul class="list-inline">
                        <li>{{ $status->created_at->diffForHumans() }}</li>
                        @if(!$status->user->isAuthProfile() && $status->user->isFriendsWith(Auth::user()))
                            <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">{{ Auth::user()->hasLikedStatus($status) ? 'Dislike' : 'Like' }}</a></li>
                        @endif
                        <li>{{ $status->likedLikes() }} {{ str_plural('like', $status->likedLikes() ) }}</li>
                    </ul>
                    @foreach($status->replies as $reply)
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" src="{{ $reply->user->getAvatarUrl() }}">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                                        {{ $reply->user->getNameOrUsername() }}
                                    </a></h5>
                                <p>{{ $reply->body }}</p>
                                <ul class="list-inline">
                                    <li>{{ $reply->created_at->diffForHumans() }}</li>
                                    @if(!$reply->user->isAuthProfile() && $reply->user->isFriendsWith(Auth::user()))
                                        <li>
                                            <a href="{{ route('status.like', ['statusId' => $reply->id]) }}">{{ Auth::user()->hasLikedStatus($reply) ? 'Dislike' : 'Like' }}</a>
                                        </li>
                                    @endif
                                    <li>{{ $reply->likedLikes() }} {{ str_plural('like', $reply->likedLikes() ) }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    @if(!isset($authUserIsFriend) || (!empty($authUserIsFriend) || Auth::user()->id === $status->user->id))
                        <form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
                            <div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error' : '' }}">
                                <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                                @if($errors->has("reply-{$status->id}"))
                                    <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                                @endif
                            </div>
                            <input type="submit" value="Reply" class="btn btn-default btn-sm">
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
        {!! $statuses->render() !!}
    @endif
</div>