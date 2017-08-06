<?php

namespace Chatty\Http\Controllers;

use Chatty\Models\Status;
use Illuminate\Http\Request;
use Chatty\Models\User;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function postStatus(Request $request)
    {
        $this->validate($request,[
            'status'=> 'required|max:1000'
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);

        return redirect()->route('home')->with('info', 'Status updated.');
    }

    public function postReply(Request $request, $statusId)
    {
        $this->validate($request,[
            "reply-{$statusId}" => 'required|max:1000',
        ], [
            'required' => 'The reply body is required.'
        ]);

        $status = Status::notReply()->find($statusId);

        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendsWith($status->user)
            && Auth::user()->id != $status->user->id)
        {
            return redirect()->route('home');
                //->with('info', "You replied to {$status->user->getNameOrUsername}'s status.");
        }
        $reply = new Status();
        $reply->body = $request->input("reply-{$statusId}");
        $reply->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();
    }

    public function getLike($statusId)
    {
        $status = Status::find($statusId);

        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendsWith($status->user)){
            return redirect()->route('home');
        }

        if(Auth::user()->hasReactedToStatus($status)){
            $reactedStatus = Auth::user()->getUserStatusLike($status);
            $reactedStatus->like_type = !($reactedStatus->like_type);
            $reactedStatus->save();
        }else{
            //user_id is fillable that is why it works
            $status->likes()->create(['user_id' => Auth::user()->id,'like_type' => 1]);
        }

        return redirect()->back();
    }
}
