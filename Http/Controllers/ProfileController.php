<?php

namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();
        if(!$user){
            abort(404);
        }
        $isAuthProfile = $user->isAuthProfile();;
        $statuses = $user->statuses()
            ->notReply()
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('profile.index')
            ->with('user',$user)
            ->with('statuses',$statuses)
            ->with('isAuthProfile',$isAuthProfile)
            ->with('authUserIsFriend',Auth::user()->isFriendsWith($user));
    }

    public function getEdit()
    {
       return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'alpha|max:50',
            'last_name' => 'alpha|max:50',
            'location' => 'alpha|max:30|min:2',
        ]);
        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('info','Your profile has been updated!');
    }
}