<?php

namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();
        return view('friends.index')
            ->with('friends', $friends)
            ->with('requests', $requests);
    }

    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user){
            return redirect()->route('home')
                ->with('info', 'That user can not be found');
        }

        if(Auth::user()->id === $user->id ){
            return redirect()->route('home');
        }

        if(Auth::user()->hasFriendRequestPending($user) || $user
                ->hasFriendRequestPending(Auth::user())) {
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request already pending.');
        }

        if(Auth::user()->isFriendsWith($user)){
            return redirect()
                ->route('profile.index', ['username' =>  $user->username])
                ->with('info', 'You are already friends.');
        }

        Auth::user()->addFriend($user);

        return redirect()
            ->route('profile.index', ['username' => $username])
            ->with('info', 'Friend request sent.');
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user){
            return redirect()->route('home')
                ->with('info', 'That user can not be found');
        }

        if(!Auth::user()->hasFriendRequestReceived($user)){
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()
            ->route('profile.index', ['username' => $username])
            ->with('info', 'Friend request accpeted');
    }

    public function postDelete($username)
    {
        $user = User::where('username', $username)->first();

        if(!Auth::user()->isFriendsWith($user)){
            return redirect()
                ->route('friends');
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back();
    }

}
