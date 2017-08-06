@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if(Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend request.</a>
            @elseif(Auth::user()->isFriendsWith($user))
                <p>You and {{$user->getNameOrUsername() }} are friends</p>

                <form action="{{ route('friend.delete', ['username' => $user->username]) }}" method="post">
                    <input type="submit" value="Delete friend" class="btn btn-primary" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </form>
            @elseif(Auth::user() != $user)
                <a href="{{ route('friend.add',['username' => $user->username]) }}" class="btn btn-primary">Add as friend</a>
            @endif
            <h4>
                @if($isAuthProfile)
                    Your friends.
                @else
                    {{ $user->getFirstNameOrUsername() }}'s friends.
                @endif
            </h4>
            @if(!$user->friends()->count())
                @if($isAuthProfile)
                    <p>You have no friends.</p>
                @else
                    <p>{{ $user->getFirstNameOrUsername() }} has no friends.</p>
                @endif

            @else
                @php $userOld = $user; @endphp
                @foreach($user->friends() as $user)
                   @include('user.partials.userblock')
                @endforeach
                @php $user= $userOld; @endphp
            @endif
        </div>
        @include('templates.partials.status')

    </div>
@stop